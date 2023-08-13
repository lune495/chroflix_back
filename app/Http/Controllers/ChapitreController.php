<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as Image;
use App\Models\{Outil,User,Chapitre};


class ChapitreController extends Controller
{

    private $queryName = "chapitres";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $item = new Chapitre();
            if (!empty($request->id))
            {
                $item = Chapitre::find($request->id);
            }
            if (empty($request->histoire_id))
            {
                $errors = "Renseignez l'histoire du livre";
            }
            if (empty($request->titre))
            {
                $errors = "Renseignez le titre";
            }
            if (empty($request->corps))
            {
                $errors = "Renseignez le corps";
            }
            DB::beginTransaction();
            $item->titre = $request->titre;
            $item->corps = $request->corps;
            $item->histoire_id =  $request->histoire_id;
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return Chapitre::all();

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
