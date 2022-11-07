@extends('layouts.app')

@section('contenido')
    @livewire('employee-records-livewire', ['id' => $id])
@endsection
