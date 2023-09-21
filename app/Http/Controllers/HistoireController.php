<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as Image;
use App\Models\{Histoire,Outil,User,Chapitre};
use Illuminate\Support\Facades\Auth;


class HistoireController extends Controller
{

    private $queryName = "histoires";

    public function save(Request $request)
    {
        try 
        {
            $errors =null;
            $user = Auth::user();
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
            $image_name = null;
            if($request->hasFile('image')){
                //    $destinationPath = "images/produits";
                   $image = $request->file("image");
                   $image_name = $image->getClientOriginalName();
                    $destinationPath = public_path().'/images';
                    $image->move($destinationPath,$image_name);
                   //Storage::disk('public')->put($image_name,file_get_contents($request->image));
                   //$path = $request->file('image')->storeAs($destinationPath,$image_name);
                }
            $item->image_couverture = $image_name;
            $item->titre = $request->titre;
            $item->genre = $request->genre;
            $item->resume = $request->resume;
            $item->famille_histoire_id = $request->famille_histoire_id;
            $item->user_id = $user->id;
            if (!isset($errors)) 
            {
                $item->save();
                $id = $item->id;
                // if($item->save())
                // {
                //     if(!empty($chapitre_tabs)) {
                //         foreach ($chapitre_tabs as $chapitre_tab) 
                //         {
                //             $chapitre->histoire_id =  $item->id;
                //             $chapitre->titre =  $chapitre_tab['titre'];
                //             $chapitre->save();
                //         }
                //     }
                // }
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
