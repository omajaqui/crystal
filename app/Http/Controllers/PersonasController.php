<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class PersonasController extends Controller
{
    public function personas(Request $request)
    {
        $accion = $request->accion;
        $buscar = $request->buscar; 

        $continuar = '';
        $mensaje   = '';
        $socios    = [];
        $pagination= [];

        $tipoDocumento      = $request->tipoDocumento;
        $documento          = $request->documento;
        $numeroAsociado     = $request->numeroAsociado;
        $nombres            = $request->nombres;
        $apellidos          = $request->apellidos;
        $correo             = $request->correo;
        $tFijo              = $request->tFijo;
        $celular            = $request->celular;
        $ciudad             = $request->ciudad;
        $barrio             = $request->barrio;
        $direccion          = $request->direccion;
        $cuotaMes           = $request->cuotaMes;
        $idPersona          = $request->idPersona;
        $numeroAsociadoAnterior = $request->numeroAsociadoAnterior;

        if ($accion == 'listarSocios') {
            if ($buscar == ''){
                $socios = DB::table("personas")
                            ->join("socios","socios.idPersona","personas.idPersona")
                            ->select("personas.*","socios.valorCuotaMes","socios.numeroAsociado")
                            ->orderBy("socios.idPersona","DESC")
                            ->paginate(5);
            }else{
                $socios = DB::table("personas")
                            ->join("socios","socios.idPersona","personas.idPersona")
                            ->select("personas.*","socios.valorCuotaMes","socios.numeroAsociado")                            
                            ->where("personas.documento","LIKE","%".$buscar."%")
                                ->orWhere("personas.nombres","LIKE","%".$buscar."%")
                                ->orWhere("personas.apellidos","LIKE","%".$buscar."%")
                                ->orWhere("personas.telFijo","LIKE","%".$buscar."%")
                                ->orWhere("personas.celular","LIKE","%".$buscar."%")
                                ->orWhere("personas.correo","LIKE","%".$buscar."%")
                                ->orWhere("personas.ciudad","LIKE","%".$buscar."%")
                                ->orWhere("personas.barrio","LIKE","%".$buscar."%")
                                ->orWhere("personas.direccion","LIKE","%".$buscar."%")
                                ->orWhere("socios.valorCuotaMes","LIKE","%".$buscar."%")
                                ->orWhere("socios.numeroAsociado","LIKE","%".$buscar."%")
                            ->orderBy("socios.idPersona","DESC")
                            ->paginate(5);
            }
                        
            $continuar  = 'S';
            $mensaje    = 'Success';
            $pagination = [
                'total'        => $socios->total(),
                'current_page' => $socios->currentPage(),
                'per_page'     => $socios->perPage(),
                'last_page'    => $socios->lastPage(),
                'from'         => $socios->firstItem(),
                'to'           => $socios->lastItem(),
            ];
        }

        if ($accion == 'guardarSocio') {  
            $getId = DB::select("CALL sp_Gestionarpersonas(?,?,?,?,?,?,?,?,?,?,?,?,?,'','')",
                                        [
                                            $accion,
                                            $tipoDocumento,
                                            $documento,
                                            $numeroAsociado,
                                            $nombres,
                                            $apellidos,
                                            $tFijo,
                                            $celular,
                                            $correo,                                            
                                            $ciudad,
                                            $barrio, 
                                            $direccion,
                                            $cuotaMes
                                        ]
                                );
            if(array_key_exists(0,$getId)){
                $id = $getId[0]->id;
                $request['idPersona'] = $id;
                return $this->register($request);
            }else{
                $continuar = 'N';
                $mensaje   = "No se pudo crear el registro de persona y socio";
            }
            
        }

        if ($accion == 'editarSocio') {
            $update = DB::select("CALL sp_Gestionarpersonas(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                    [
                                        $accion,
                                        $tipoDocumento,
                                        $documento,
                                        $numeroAsociado,
                                        $nombres,
                                        $apellidos,
                                        $tFijo,
                                        $celular,
                                        $correo,                                            
                                        $ciudad,
                                        $barrio, 
                                        $direccion,
                                        $cuotaMes,
                                        $idPersona,
                                        $numeroAsociadoAnterior
                                    ]                            
                                );
            if(array_key_exists(0,$update)){
                $continuar = 'S';
                $mensaje   = "Update Success";
            }else{
                $continuar = 'N';
                $mensaje   = "No se pudo actualizar el registro de socio";
            }
        }

        // Comun response
        $respuesta =  array(
            'pagination' => $pagination,
            'Continuar' => $continuar,
            'Mensaje' => $mensaje,            
            'Socios' => $socios
        );
        return response()->json(compact('respuesta'), 200);
    }

    public function register(Request $request) 
    {
        $continuar = '';
        $mensaje = '';
        $user    = [];       

        $user = new  User();
        $user->idPersona = $request->idPersona;
        $user->user = $request->documento;
        $user->password = bcrypt($request->documento);
        $user->save();

        /* if ($this->loginAfterSignUp) {
            return  $this->login($request);
        }
        */
        if ($user != []){
            $continuar = 'S';
            $mensaje   = 'success';
        }else{
            $continuar = 'S';
            $mensaje   = 'No se pudo crear usuario en la aplicacion';
        }
        // Comun response
        $respuesta =  array(
            'Continuar' => $continuar,
            'Mensaje' => $mensaje
        );
        return response()->json(compact('respuesta'), 200);
    }
        
}