<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayTechService;

class PaymentController extends Controller
{
    
    public function __construct()
    {
    }

    public function processPayment(Request $request)
    {
        $payTechService = new PayTechService('5f7c2f342fb550d8ddfd8aa6a88cd1157466e20c68163c2864fab2cb12e9f4fb', '5b1d7da9c93fdc7cbbd903e6c9bcc6687357559dc6648c042c00699e557d9534');
        // Valider les données de paiement
        $data = [
            'item_name' => 'Nom de larticle',
            'item_price' => 100,
            'command_name' => 'Nom de la commande',
            'ref_command' => 'Référence de la commande 30',
            'env' => 'test',
            'currency' => 'XOF',
            'ipn_url' => 'https://votre-url/ipn',
            'success_url' => 'https://votre-url/success',
            'cancel_url' => 'https://votre-url/cancel',
            'custom_field' => 'Champ personnalisé'
        ];
        // Appeler le service PayTech pour effectuer la demande de paiement
        $paymentResponse = $payTechService->createPayment($data);
         dd($paymentResponse);
        // Vérifier si la demande de paiement a réussi
        if ($paymentResponse['success']) {
            // Rediriger l'utilisateur vers la page de paiement
            return response()->json([
                'redirect_url' => $paymentResponse['redirect_url'],
            ]);
        } else {
            // Gérer les erreurs de demande de paiement
            return response()->json([
                'error' => 'Erreur lors de la demande de paiement',
            ], 500);
        }
    }
}