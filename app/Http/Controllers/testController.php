<?php

namespace App\Http\Controllers;

    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use App\Http\Requests\RegisterAuthRequest;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;

    use App\Models\User;
    //use App\Models\test;

class testController extends Controller
{
    public  $loginAfterSignUp = true;

    public function test()
    {
        $data = DB::select("SELECT *FROM crystal.actividad");
        return $data;
    }

    public  function  register(Request  $request) {
        $user = new  User();
        $user->idPersona = $request->idPersona;
        $user->user = $request->user;
        $user->password = bcrypt($request->password);
        $user->save();

        /* if ($this->loginAfterSignUp) {
            return  $this->login($request);
        } */

        return  response()->json([
            'status' => 'ok',
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = '';
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return  response()->json([
                    'status' => 'invalid_credentials',
                    'message' => 'Correo o contraseña no válidos.',
                ], 401);
            }
        } catch (JWTException $e) {
            return  response()->json([
                'status' => 'error',
                'message' => 'no se pudo crear el token',
            ],500);
        }
        return  response()->json([
            'status' => 'login ok',
            'token' => $token,
        ]);
    }
    
}
