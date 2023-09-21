<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Outil,User,Chapitre};
use Illuminate\Support\Facades\Auth;

class AbonnementController extends Controller
{
    //
    private $queryName = "abonnements";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $user = Auth::user();
            $item = new Abonnement();
            if (!empty($request->id))
            {
                $item = Chapitre::find($request->id);
            }
            if (empty($request->user_id))
            {
                $errors = "Renseignez le lecteur";
            }
            if (empty($request->auteur_id))
            {
                $errors = "Renseignez l'auteur";
            }
            $item->user_id = $user->id;
            DB::beginTransaction();
            $item->status_abonnement = 1;
            $item->save();
            $id = $item->id;
            DB::commit();
            return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
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
