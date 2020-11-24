<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamosController extends Controller
{
    public function ahorroSocio(Request $request)
    {
        $accion         = $request->accion;
        $documento      = $request->id;
        $tipo           = $request->tipo;
        $valorCredito   = $request->valorCredito;
        $cantidadCuotas = $request->cantidadCuotas;

        $continuar  = '';
        $mensaje    = '';
        $datosRespuesta = [];
        
        if ($accion == 'consultarAhorro') {   
            $data = DB::select("CALL crystal.spGestionarPrestamos(?,?)",[$accion, $documento]);  
            if(array_key_exists(0,$data)) {
                $res = $data[0]->res;
                if ($res == 'S') {
                    $continuar  = 'S';
                    $mensaje    = 'Success';
                    $datosRespuesta = $data;
                }
                if ($res == 'N') {
                    $continuar  = 'N';
                    $mensaje    = $data[0]->Mensaje;
                }
            }
        }

        if ($accion == 'calcularCuota') {
            $interes = 0;
            //determinar a quien va dirigido el prestamo para establecer el valor del interes
            switch ($tipo) {
                case 'socio': $interes = 0.05; break;
                case 'persona': $interes = 0.10; break;
            }

            //determinar total interese - intereses por mes,
            $intMes = $valorCredito*$interes;
            $totalInt =  $intMes*$cantidadCuotas;

            $totalPrestamo = $valorCredito+$totalInt;

            $vlrCuota = $totalPrestamo/$cantidadCuotas;

            $continuar = 'S';
            $mensaje   = 'Success';
            $datosRespuesta = array('ValorCuota' => $vlrCuota); 

        }

        // Comun response
        $respuesta =  array(
            'Continuar' => $continuar,
            'Mensaje' => $mensaje,            
            'DatosRespuesta' => $datosRespuesta
        );
        return response()->json(compact('respuesta'), 200);
    }

    public function Credito(Request $request)
    {        
        $accion = $request->accion;

        $continuar = '';
        $mensaje   = '';
        $datosRespuesta = [];

        if ($accion == 'creditoGuardar') {
             //calcular
        }


        // Comun response
        $respuesta =  array(
            'Continuar' => $continuar,
            'Mensaje' => $mensaje,            
            'DatosRespuesta' => $request
        );
        return response()->json(compact('respuesta'), 200);
    }
}
