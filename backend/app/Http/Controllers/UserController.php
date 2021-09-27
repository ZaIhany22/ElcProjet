<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUser(){
        $user=User::all();
        return response($user,201);
    }
    public function login(Request $request)  {
        $fields=$request->validate([
            'email'=>'required|string',
            'password'=>'required|string',
            'role'=>'required'
        ]);

        $user=User::where('email',$fields['email'])->first(); //mverifier hoe ao anaty base ve le olona sinon tonga de erreur
        if(!$user){
            return response([
                'message'=>'Utilisateur inexistant',
                'status' => 401,
            ],401);
        }
            
       

        if($user->role_id=="1" && $fields['role']=="1"){ //mverifier tena admin ve le olona
            if(Hash::check($fields['password'],$user->password)){
                $token=$user->createToken('myapptoken')->plainTextToken;
                $response=[
                    'user'=>$user,
                    'token'=>$token,
                    'message' => 'Connexion reussie',
                    'status'=> 201,
                ];

                return response($response,201);
            }else{
                $response=[
                    'message'=>'mot de passe incorrect',
                    'status'=>'401'
                ];
                return response($response,401);
            }
        }elseif ($user->role_id=="1" && $fields['role']!=1){
            return response('Compte client',201);
        }
        if($user->role_id=="2" && $fields['role']=="2"){ //mverifier hoe client ve le olona 
            if(Hash::check($fields['password'],$user->password)){
                $token=$user->createToken('myapptoken')->plainTextToken;
                $response=[
                    'user'=>$user,
                    'token'=>$token,
                    'message' => 'Connexion reussie',
                    'status'=> 201,
                ];

                return response($response,201);
            }else{
                $response=[
                    'message'=>'mot de passe incorrect',
                    'status'=>'401'
                ];
                return response($response,401);
            }
        }else{
            return response('Vous êtes en mode client',201);
        }
        



        //check password
        /*if(!$user || !Hash::check($fields['password'],$user->password)){
            return response([
                'message'=>'Utilisateur inexistant',
                'status' => 401,
            ],401);
        }

        $token=$user->createToken('myapptoken')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token,
            'message' => 'Logged successfull',
            'status'=> 201,
        ];

        return response($response,201);*/

    }

    public function register(Request $request){
        $fields=$request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed',
            'role_id'=>'required'
        ]);

        $user=User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=>Hash::make($fields['password']),
            'role_id'=>$fields['role_id']

        ]);

        $token=$user->createtoken('myapptoken')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token,
            'status' => 201
        ];

        return response($response,201);

    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message'=>'logout'
        ];
    }
}
