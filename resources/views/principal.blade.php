@extends('plantillas.principal')

@section('titulo', 'Principal')

@section('contenido')
    <h1>Principal</h1>
    <p>Bienvenido, {{ auth()->user()->nombre }}.</p>
@endsection
