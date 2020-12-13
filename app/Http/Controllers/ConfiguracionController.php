<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfiguracionController extends Controller
{
    public function consultarNumsAsociado()
    {
        $continuar = '';
        $mensaje   = '';
        $numeros   = [];

        //establecer todos los numeros como disponibles
        DB::table("crystal.numeroasociado")
        ->update(['disponible' => 'S']);

        //consultar los numeros que estan en uso actualmente
        $uso = DB::select("CALL crystal.spConfiguraciones(?)",['numAsociadosDisponibles']);        
        
        //recorrer resultados de numeros usados y marcar como no disponibles los que estan en uso en la tabla numerosasociados
        $total = count($uso);
        for($i=0; $i<$total; $i++){
            DB::table("crystal.numeroasociado")
            ->where(['numeroAsociado' => $uso[$i]->numeroAsociado])
            ->update(['disponible' => 'N']);
        }

        $numeros = DB::select("SELECT *FROM crystal.numeroasociado WHERE disponible=? ORDER BY idNumeroAsosciado ASC",['S']);
        if (array_key_exists(0,$numeros)) {
            $continuar = 'S';
            $mensaje   = 'Success';
        }else{
            $continuar = 'N';
            $mensaje   = 'No se obtuvieron numeros de asosciados disponibles';
        }


        // Comun response
        $respuesta =  array(
            'Continuar' => $continuar,
            'Mensaje' => $mensaje,
            'Numeros' => $numeros,
        );
        return response()->json(compact('respuesta'), 200);
    }


    /*
        ** Fecha: 20/11/2020
        ** Autor: Omar jaramillo
        ** descripcion: gestiona las actividades segun la accion que se reciba
    */
    public function actividades(Request $request)
    {   
        $accion     = $request->accion;

        $continuar = '';
        $mensaje   = '';
        $dataRespuesta = [];

        /* consulta la actividad que se encuetra vigen o activa para el mes en curso, y todos sus recaudos asociados */
        if ($accion == 'consultaActiva') {

            //listado de socios activos
            $socios = DB::select("CALL crystal.sp_Gestionarpersonas(?,'','','','','','','','','','','','','','','')",['sociosCuotas']);

            //consultar polla del mes en curso
            $po =DB::select("CALL crystal.spGestionarActividades(?,'','')",[$accion]);

            //consultar recaudos del apolla del mes
            $re = DB::select("CALL crystal.spGestionarActividades(?,'','')",['recaudosPolla']);

            $continuar = 'S';
            $mensaje   = 'Success';
            $dataRespuesta = [
                                'socios' => $socios,
                                'pollaMes' => $po,
                                'recaudos' => $re
                             ];
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
