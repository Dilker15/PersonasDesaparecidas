<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\createUserRequest;
use App\Models\Device;
use App\Models\User;

class UsersController extends Controller
{
    

    public function createUser(createUserRequest $request){
        $newUser = User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>$request['password'],
            'tipo'=>1,
        ]);

        $token = Device::where('token',$request['token'])->first();
        if($token){
             $token->user_id=$newUser->id;
             $token->save();

        }else{
            $device = Device::create([
                'user_id'=>$newUser->id,
                'token'=>$request['token'],
                
            ]);     
        }
       

        return response()->json([
            'res'=>true,
            'mensaje'=>'User creado con Exito',
            'datos'=>$newUser,
        ]);
    }
}
