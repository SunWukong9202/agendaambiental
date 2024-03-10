<!doctype html>
<html lang="en">
@extends('layout')

@section('title', 'events')
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>EventManagement</title>
</head>
@section('content')
<body>
    <nav class="navbar navbar-light bg-light">
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>
    <h2>Publicar Eventos</h2>
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Nombre del Evento</label>
                <input type="text" class="form-control" id="inputEmail4" placeholder="Evento">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Registro</label>
                <input type="text" class="form-control" id="inputPassword4" placeholder="Registro">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Inscripciones</label>
                <input type="text" class="form-control" id="inputPassword4" placeholder="Inscripciones">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress">Objetivo del Evento</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="Objetivo">
        </div>
        <div class="form-group">
            <label for="inputAddress2">Prerrequisitos</label>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Prerrequisitos">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Fecha de Registro</label>
                <input type="date" class="form-control" id="inputCity">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Lugar</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Lugar">
            </div>
            <div class="form-group col-md-4">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Archivo cartel</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </form>
                </select>
            </div>

        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
              Check me out
            </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
@endsection
</html>