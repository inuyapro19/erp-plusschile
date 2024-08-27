@extends('layouts.app')

@section('content')
    <x-base>
        @if($id)
            <checklist-prevencion-create
                :checklist_id="{{ $id }}"
                :id_bus="{{ $id_bus }}"
            />
        @else
            <checklist-prevencion-create ></checklist-prevencion-create>
        @endif

    </x-base>
@endsection
