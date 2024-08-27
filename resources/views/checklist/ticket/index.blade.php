@extends('layouts.app')

@section('content')
    <x-base>
        <ticket-calidad-index
            :permisos="{{ json_encode($permisos) }}">
        </ticket-calidad-index>
    </x-base>
@endsection
