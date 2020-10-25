<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidarController extends Controller
{
    public function validarCredenciales(Request $request)
    {
        //return $this->adminInicio();
        return redirect('/inicio');
    }

    public function inicio()
    {
        return view('contenido.index');
    }
}
