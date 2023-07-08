<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Histoire,Outil,User,Chapitre};


class HistoireController extends Controller
{

    private $queryName = "histoires";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $item = new Histoire();
            $chapitre = new Chapitre();
            if (!empty($request->id))
            {
                $item = Histoire::find($request->id);
            }
            if (empty($request->famille_histoire_id))
            {
                $errors = "Renseignez la categorie du livre";
            }
            if (empty($request->titre))
            {
                $errors = "Renseignez le titre";
            }
            $str_json_chapitre = json_encode($request->tab_chapitres);
            $chapitre_tabs = json_decode($str_json_chapitre, true);
            DB::beginTransaction();
            $item->titre = $request->titre;
            $item->genre = $request->genre;
            $item->resume = $request->resume;
            $item->famille_histoire_id = $request->famille_histoire_id;
            $item->user_id = $request->user_id;
            if (!isset($errors)) 
            {
                $item->save();
                $id = $item->id;
                if($item->save())
                {
                    foreach ($chapitre_tabs as $chapitre_tab) 
                    {
                        $chapitre->histoire_id =  $item->id;
                        $chapitre->titre =  $chapitre_tab['titre'];
                        $chapitre->save();
                    }
                }
                DB::commit();
                return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return Histoire::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

     /**
     * Search for a name.
     * @param str $name
     */
    public function search($name)
    {
        //
        return Histoire::where('titre','like','%'.$name)->get();
    }
}
