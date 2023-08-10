<?php

namespace App\Http\Controllers;

use App\Models\{User,Outil};
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $queryName = "users";
    // Register
    public function register(Request $request ) {
        $fields = $request->validate([
            'email' => 'required|string',
            'nom' => 'required|string',
            'photo_profil' => 'string',
            'biographie' => 'string',
            'lien_sociaux' => 'string',
            'password' => 'required|string|confirmed',
            'role_id' => 'required|integer',
        ]);
        $user =  User::create([
            'nom' => $fields['nom'],
            'email' => $fields['email'],
            // 'photo_profil' => $fields['photo_profil'] ? $fields['photo_profil'] : null,
            // 'biographie' => $fields['biographie'] ? $fields['biographie'] : null,
            // 'lien_sociaux' => $fields['lien_sociaux'] ? $fields['lien_sociaux'] : null,
            'password' => bcrypt($fields['password']),
            'role_id' => $fields['role_id'],
             
        ]);
        $id = $user->id;
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            // 'user' =>  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]),
            'user' => $user,
            'token' => $token
        ];

         //return Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
        return response($response, 201);
    }

     public function login(Request $request ) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        // Check email
        $user = User::with('role')->where('email',$fields['email'])->first();
        //Check email
            if (!$user || !Hash::check($fields['password'],$user->password)) {
                return response([
                    'message' => 'Mot de passe Incorrect'
                ],401);
                # code...
            }
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Deconnecte'
        ];
    }
}
