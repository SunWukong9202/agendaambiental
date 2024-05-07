@extends('welcome');

@section('title', 'Modulo de Gestion Ambiental');

@if ($user['rol'] == 'Cliente')
@section('navigation')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('informativeSection') }}">Submódulo de Información</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('recursos') }}">Submódulo de recursos</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('recursos') }}">Submódulo de recursos</a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="#" class="nav-link">
                    {{ $user['name'] ?? '' }} - {{ $user['rol'] ?? '' }}
                </a>
            </div>
        </div>
    </nav>   
    @endsection
@endif

@section('content')
    
@endsection

