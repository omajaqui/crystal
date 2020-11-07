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
    use Session;

class ValidarController extends Controller
{
    public function validarCredenciales(Request $request)
    {        
        $credentials = $request->only('user', 'password');
        $token = '';
        $continuar = '';
        $mensaje   = '';
        $documento = '';        

        try {
            if (!$token = JWTAuth::attempt($credentials)) {                
                $continuar = 'N';
                $mensaje   = 'Correo o contraseña no válidos.';                
            }else{
                $continuar = 'S';
                $mensaje   = 'Login Success';                

                //obtener datos del usuario que inicia sesion
                $getDocument = DB::select("SELECT p.* FROM crystal.users u INNER JOIN crystal.personas p ON u.idpersona=p.idPersona WHERE u.user=?",[$request->user]);
                $idpersona = $getDocument[0]->idPersona;
                $documento = $getDocument[0]->documento;
                
                //guardar token en BD
                DB::select("UPDATE crystal.users SET remember_token=? WHERE idPersona=?",[$token,$idpersona]);
            }
        } catch (JWTException $e) { 
            $continuar = 'N';
            $mensaje   = 'No se pudo crear el token: '.$e;
        }

        $respuesta =  array(
                                'Continuar' => $continuar,
                                'Mensaje' => $mensaje,
                                'Token' => $token,
                                'Documento' => $documento
        );
         
        
        return response()->json(compact('respuesta'), 200); 
    }
    
    public function inicio(Request $request)
    {      
        $documento = $request->documento;
        $token = $request->token;
        $dataUsuario = [];

        //obtener los datos del usuario que inicia sesion
        $dataUsuario = DB::select("SELECT *FROM crystal.personas WHERE documento=?",[$documento]);
       
        //llenar variables de session
        $request->session()->put('tipoUsuario',$dataUsuario[0]->idTipoUsuario);
        $request->session()->put('nombres',$dataUsuario[0]->nombres);
        $request->session()->put('apellidos',$dataUsuario[0]->apellidos);       


        if(array_key_exists(0,$dataUsuario)) {
            $idTipoUsuario = $request->session()->get('tipoUsuario');            
            if($idTipoUsuario==1 || $idTipoUsuario==2 ){
                return view('contenido.admin')
                        ->with([
                                    'Token' => $token,
                                    'IdPersona' => $dataUsuario[0]->idPersona
                              ]);
            }else if($idTipoUsuario==3){

            }
        }

        
    }

    public function datosUsuario(Request $request) {
        return $request;
    }
}
