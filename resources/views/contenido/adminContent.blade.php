@extends('layouts.admin')
@section('contenidoAdmin')

@php
    $token = $Token;
    $idpersona = $IdPersona;
@endphp
   
    <template v-if="menu==1">
        <admin-home 
                :token="{{json_encode($token)}}" 
                :idpersona="{{json_encode($idpersona)}}" 
                >
        </admin-home>
    </template> 
    <template v-if="menu==2">
        <admin-socios></admin-socios>
    </template>
    <template v-if="menu==3">
        <admin-cuotas></admin-cuotas>
    </template>
    <template v-if="menu==4">
        <admin-actividades></admin-actividades>
    </template>
    <template v-if="menu==5">
        <admin-prestamos></admin-prestamos>
    </template>  

@endsection