<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Histoire};


class HistoireController extends Controller
{
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
