<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuotasController extends Controller
{
    public function gestionCuotas(Request $request)
    {
        $accion     = $request->accion;
        $idPersona  = $request->id;
        $documento  = $request->documentoSocio;
        $mes        = $request->mes;
        $cuota      = $request->cuota;
        $descripcion= $request->descripcion;

        $continuar = '';
        $mensaje   = '';
        $datosRespuesta = [];

        $guardarCuota = DB::select("CALL spGestionarCuotas(?,?,?,?,?,?)",[$accion,$idPersona,$documento,$mes,$cuota,$descripcion]);

        if(array_key_exists(0,$guardarCuota)){
            $res = $guardarCuota[0]->res;
            if($res == 'S'){
                $continuar = 'S';
                $mensaje   = 'Success';
            }else{
                $continuar = 'N';
                $mensaje   = $guardarCuota[0]->mensaje;  
            }
        }else{
            $continuar = 'N';
            $mensaje   = 'No se obtuvo respuesta';
        }

        // Comun response
        $respuesta =  array(
            'Continuar' => $continuar,
            'Mensaje' => $mensaje,            
            'DatosRespuesta' => $datosRespuesta
        );
        return response()->json(compact('respuesta'), 200);
    }
}
