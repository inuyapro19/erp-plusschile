@extends('layouts.app')

@section('content')
    <x-base>
        <ticket-prevencion-index
            :permisos="{{ json_encode($permisos) }}">
        </ticket-prevencion-index>
    </x-base>
@endsection
