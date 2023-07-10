<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\{Commande,Outil,User,Histoire};
use App\Services\PayTechService;

use Illuminate\Http\Request;

class CommandeController extends Controller
{
    //
    private $queryName = "commandes";
    
    /**
    * @var string
    */
    private $apiSecret = "5f7c2f342fb550d8ddfd8aa6a88cd1157466e20c68163c2864fab2cb12e9f4fb";
    /**
    * @var string
    */
    private $apiKey = "5b1d7da9c93fdc7cbbd903e6c9bcc6687357559dc6648c042c00699e557d9534";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $item = new Commande();
            if (!empty($request->id))
            {
                $item = Commande::find($request->id);
            }
            DB::beginTransaction();
            $item->user_id = $request->user_id;
            $item->histoire_id = $request->histoire_id;
            $histoire = Histoire::find($request->histoire_id);
            if (!isset($histoire)) {
                $errors = "Livre inexistant";
            }
            if (!isset($errors)) 
            {
                $item->save();
                $item->ref_commande = "COM-00{$item->id}";
                $item->nom_commande = "commande numero {$item->id}";
                $id = $item->id;
                $item->save();
                DB::commit();
                $payTechService = new PayTechService($this->apiSecret,$this->apiKey);
                // Valider les données de paiement
                $data = [
                    'item_name' => $histoire->titre,
                    // 'item_price' => $histoire->prix,
                    'item_price' => 20000,
                    'command_name' => $item->nom_commande,
                    'ref_command' => $item->ref_commande,
                    'env' => 'test',
                    'currency' => 'XOF',
                    'ipn_url' => 'https://votre-url/ipn',
                    'success_url' => 'https://votre-url/success',
                    'cancel_url' => 'https://votre-url/cancel',
                    'custom_field' => 'Champ personnalisé'
                ];
                // Appeler le service PayTech pour effectuer la demande de paiement
                $paymentResponse = $payTechService->createPayment($data);
                // Vérifier si la demande de paiement a réussi
                if ($paymentResponse['success'] == 1) {
                    // Rediriger l'utilisateur vers la page de paiement
                $item->status = "1";
                    $item->save();
                    return response()->json([
                        'redirect_url' => $paymentResponse['redirect_url'],
                    ]);
                } else {
                    // Gérer les erreurs de demande de paiement
                    return response()->json([
                        'error' => 'Erreur lors de la demande de paiement',
                    ], 500);
                }
                //return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
            }
            if (isset($errors))
            {
                throw new \Exception('{"data": null, "errors": "'. $errors .'" }');
            }
        } catch (\Throwable $e) {
                DB::rollback();
                return $e->getMessage();
        }
    }
}