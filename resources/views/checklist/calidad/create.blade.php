@extends('layouts.app')

@section('content')
    <x-base>
        @if($id)
            <checklist-calidad-create
                :checklist_id="{{ $id }}"
                :id_bus="{{ $id_bus }}"
            />
        @else
            <checklist-calidad-create ></checklist-calidad-create>
        @endif

    </x-base>
@endsection
