
@extends('layouts.app')

@section('content')
    <x-base>
        <checklist-prevencion-index
            :permisos="{{ json_encode($permisos) }}"
        ></checklist-prevencion-index>
    </x-base>
@endsection
