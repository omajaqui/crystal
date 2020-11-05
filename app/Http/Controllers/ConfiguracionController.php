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
}
