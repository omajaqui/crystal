@extends('layouts.admin')
@section('contenidoAdmin')

@php
    $token = $Token;
    $dataUsuario = $DataUsuario;
@endphp

    <template v-if="menu==1">
        <admin-home 
            :token="{{ json_encode($token) }}"
            :dataUsuario="{{ json_encode($dataUsuario) }}"
        ></admin-home>
    </template>    
    <template v-if="menu==2">
        <admin-socios></admin-socios>
    </template>


@endsection