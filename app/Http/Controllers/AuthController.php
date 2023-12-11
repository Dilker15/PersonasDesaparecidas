<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Device;


class AuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // start validatons
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255,email',
            'password' => 'required|min:4',
        ]);
        $validator->setCustomMessages([
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser un correo electronico',
            'password.required' => 'La contraseña es obligatorio',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->sendError('Validation Error.', ['email' => 'Correo electrónico no registrado.']);
            }
            return $this->sendError('Unauthorized', ['password' => 'La contraseña es errónea']);
        }
        // end validations
        if(Auth::guard('api')->attempt($credentials)){



            $tokenMovil = $request['token'];
            // return response()->json([
            //     '$tokerMovil'=>$tokenMovil,
            // ]);
            $device = Device::where('token',$tokenMovil)->first();

            $user = Auth::guard('api')->user()->id;
            $jwt = JWTAuth::attempt($credentials);
            $data = compact('user', 'jwt');

                if($device){
                    $device->user_id=$user;
                    $device->save();

                }else{
                    $device =  Device::create([
                        'user_id'=>$user,
                        'token'=>$tokenMovil,
                        
                    ]);  

                }

                return response()->json([
                    'res'=>true,
                    'device'=>$device->user_id,
                    'user'=>$user,
                    'token'=>$jwt,
                ]);
           
           // return $this->sendResponse($result, 'You have successfully log in');
        }else{
            $succes = false;
            $message = 'Credenciales incorrectas';
            return $this->sendError($message);
        }
    }

    // public function register(Request $request)
    // {
    //     Validaciones y creación del usuario
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|unique:users|max:255',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 422);
    //     }
        
    //     DB::beginTransaction();
    //     try {
    //         $user = User::create([
    //             'name' => $request->input('name'),
    //             'email' => $request->input('email'),
    //             'password' => bcrypt($request->input('password')),
    //         ]);
    //         $credentials= [
    //             'email' => $request->input('name'),
    //             'password' => $request->input('email'),
    //         ];
    //         Crear token JWT
    //         DB::commit();
    //         $token = Auth::attempt($credentials);
    //         return response()->json(['token' => $token]);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //     }
    // }

    public function logout()
    {
        Auth::guard('api')->logout();
        $result = [
        ];
        return $this->sendResponse($result, 'La sesion se cerró correctamente !!!');
    }

}
