@extends('layouts.admin')
@section('contenido')

    <template v-if="menu==1">
        <admin-home></admin-home>
    </template>
    <template v-if="menu==2">
        <admin-socios></admin-socios>
    </template>


@endsection