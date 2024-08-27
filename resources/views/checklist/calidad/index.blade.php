
@extends('layouts.app')

@section('content')
    <x-base>
        <checklist-calidad-index
            :permisos="{{ json_encode($permisos) }}"
        ></checklist-calidad-index>
    </x-base>
@endsection
