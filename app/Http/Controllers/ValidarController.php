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
            if($idTipoUsuario==1012 || $idTipoUsuario==2201 ){
                return view('contenido.adminContent')
                        ->with([
                                    'Token' => $token,
                                    'IdPersona' => $dataUsuario[0]->idPersona
                              ]);
            }else if($idTipoUsuario==3){

            }
        }else{
            return view('login');
        }

        
    }

    public function datosUsuario(Request $request) 
    {       
        $idUsuario = $request->idUSuario;
        $continuar = '';
        $mensaje   = '';
        $datos     = [];

        //Consultar datos de la persona que inicio sesion paramostrar en los componentes de VUE JS
        $datos = DB::select("SELECT *FROM crystal.personas WHERE idPersona=?",[$idUsuario]);

        if (array_key_exists(0,$datos)) {
            $continuar = 'S';
            $mensaje   = 'Success';
        }else{
            $continuar = 'N';
            $mensaje   = 'No se encontraron datos de la persona ingresada.';
        }
        
        // Comun response
        $respuesta =  array(
            'Continuar' => $continuar,
            'Mensaje' => $mensaje,
            'DatosUsuario' => $datos
        );
        return response()->json(compact('respuesta'), 200);
    }

    public function preRegistroSocio(Request $request)
    {
        $accion     = $request->accion;
        $tipoDoc    = $request->tipoDoc;
        $doc        = $request->doc;
        $nombres    = $request->nombres;
        $apellidos  = $request->apellidos;
        $correo     = $request->correo;
        $barrio     = $request->barrio;
        $direccion  = $request->direccion;
        $tFijo      = $request->tFijo;
        $celular    = $request->celular;
        $valorCuota = $request->valorCuota;

        $continuar = '';
        $mensaje   = '';
        $dataRespuesta = [];

        if ($accion == 'preRegistro') {
            //llamar al procedimiento que creara un registro con los datos de la persona
            $reg = DB::select("CALL crystal.spGestionPreRegistro(?,?,?,?,?,?,?,?,?,?,?)",
                                [
                                    $accion,
                                    $tipoDoc,
                                    $doc,
                                    $nombres,
                                    $apellidos,
                                    $correo,
                                    $barrio,
                                    $direccion,
                                    $tFijo,
                                    $celular,
                                    $valorCuota
                                ]
                             );
            if (array_key_exists(0,$reg)) {
                $continuar = 'S';
                $mensaje   = 'Success';
                $dataRespuesta = $reg;
            }else{
                $continuar = 'N';
                $mensaje   = 'No se pudo guardar el registro intenta nuevamente.';
            }
        }
        // Comun response
        $respuesta =  array(
            'Continuar' => $continuar,
            'Mensaje' => $mensaje,
            'DataRespuesta' => $dataRespuesta
        );
        return response()->json(compact('respuesta'), 200);
    }
}
