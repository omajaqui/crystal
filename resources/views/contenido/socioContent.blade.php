@extends('layouts.socio')
@section('contenidoSocio')

@php
    $token = $Token;
    $idpersona = $IdPersona;
@endphp
   
    <template v-if="menu==1">
        <socio-home 
                :token="{{json_encode($token)}}" 
                :idpersona="{{json_encode($idpersona)}}" 
                >
        </socio-home>
    </template>

    <template v-if="menu==2">
        <socio-miahorro></socio-miahorro>
    </template> 

    <template v-if="menu==3">
        <comun-reglas></comun-reglas>
    </template> 

   

@endsection