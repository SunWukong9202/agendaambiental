<!DOCTYPE html>
<html lang="es">
@extends('welcome')

@section('title', 'Submódulo de Información')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            position: relative;
        }

        header,
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }

        #contenedor {
            margin: 0 auto;
            overflow: hidden;
            padding-top: 60px;
            display: block;
        }

        #contenedor-eventos {
            max-width: fit-content;
            margin: 0 auto;
            margin-bottom: 100px;
            overflow: hidden;
            background-color: #ffdab9;
            box-sizing: border-box;
        }

        .evento {
            display: inline-block;
            vertical-align: top;
            margin: 20px;
            box-sizing: border-box;
        }

        .imagen-evento {
            width: 300px;
            height: 300px;
            background-color: #f0f0f0;
            overflow: hidden;
            transition: transform 0.3s;
            position: relative;
        }

        .imagen-evento:hover {
            transform: scale(1.1);
        }

        .imagen-evento img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .registrarse {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            display: none;
        }

        h1 {
            margin-bottom: 0;
        }

        .nombre-evento {
            width: 300px;
            height: auto;
            background-color: #007bff;
            color: white;
            text-align: center;
            box-sizing: border-box;
        }

        .imagen-evento:hover .registrarse {
            display: block;
        }

        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: absolute;
            bottom: 0;
        }

        #contenedor-info-1 {
            margin-bottom: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #imagen0 {
            margin-right: 20px;
            margin-left: 100px;
        }

        #info1 {
            flex: 1;
            margin-right: 100px;
            margin-left: 100px;
        }

        #contenedor-info-2 {
            width: 60%;
            margin-bottom: 50px;
            justify-content: center;
            align-items: center;
        }

    </style>
</head>
@section('content')
<body>

    <header>

    </header>

    <div id="contenedor">
        <div id="contenedor-info-1">
            <div id="imagen0">
                <img src="imagen1.png" alt="Submódulo de eventos">
            </div>
            <div id="info1">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed sapien ut nulla consequat scelerisque
                    non at sem. Nullam vulputate, est a consectetur facilisis, odio dolor accumsan nisl, iaculis viverra
                    lacus sapien id eros. Vestibulum quis ipsum ac metus malesuada molestie. Nam congue ex sed auctor
                    suscipit. Mauris pretium nulla lacus, a sagittis orci viverra vel. Vivamus tincidunt pellentesque
                    convallis. Fusce sed cursus dui, id porta sem. Quisque aliquet lectus id tempor egestas. Duis enim
                    nulla, imperdiet sed purus eu, dignissim mattis odio. Morbi volutpat efficitur erat id sollicitudin.
                    Integer mi leo, tempus venenatis maximus in, ullamcorper in turpis.</p>
                <p>Suspendisse potenti. Mauris sit amet bibendum elit. Nunc sed auctor augue. Aenean at urna tempor,
                    sagittis augue a, efficitur ipsum. Maecenas fringilla ut nulla malesuada dictum. Vivamus ornare,
                    ante egestas ullamcorper viverra, massa ante scelerisque elit, eget gravida eros purus quis massa.
                    Proin efficitur sed ipsum vel sodales. Vestibulum sit amet metus non justo aliquam pellentesque.
                    Proin consequat fermentum sagittis. Vestibulum sit amet magna in est cursus vestibulum.</p>
            </div>
        </div>

        <div id="contenedor-eventos">
            <div class="evento">
                <div class="imagen-evento">
                    <img src="imagen1.png" alt="Evento 1">
                    <button class="registrarse">Registrarse</button>
                </div>
                <div class="nombre-evento">
                    <h1>Evento 1</h1>
                </div>
            </div>

            <div class="evento">
                <div class="imagen-evento">
                    <img src="imagen2.png" alt="Evento 2">
                    <button class="registrarse">Registrarse</button>
                </div>
                <div class="nombre-evento">
                    <h1>Evento 2</h1>
                </div>
            </div>

            <div class="evento">
                <div class="imagen-evento">
                    <img src="imagen3.jpg" alt="Evento 3">
                    <button class="registrarse">Registrarse</button>
                </div>
                <div class="nombre-evento">
                    <h1>Evento 3</h1>
                </div>
            </div>
        </div>

        <div id="contenedor-info-2">
            <div id="info1">
                <h3>lorem Ipsum</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed sapien ut nulla consequat scelerisque
                    non at sem. Nullam vulputate, est a consectetur facilisis, odio dolor accumsan nisl, iaculis viverra
                    lacus sapien id eros. Vestibulum quis ipsum ac metus malesuada molestie. Nam congue ex sed auctor
                    suscipit. Mauris pretium nulla lacus, a sagittis orci viverra vel. Vivamus tincidunt pellentesque
                    convallis. Fusce sed cursus dui, id porta sem. Quisque aliquet lectus id tempor egestas. Duis enim
                    nulla, imperdiet sed purus eu, dignissim mattis odio. Morbi volutpat efficitur erat id sollicitudin.
                    Integer mi leo, tempus venenatis maximus in, ullamcorper in turpis.</p>
                <br>
                <h3>lorem Ipsum</h3>
                <p>Suspendisse potenti. Mauris sit amet bibendum elit. Nunc sed auctor augue. Aenean at urna tempor,
                    sagittis augue a, efficitur ipsum. Maecenas fringilla ut nulla malesuada dictum. Vivamus ornare,
                    ante egestas ullamcorper viverra, massa ante scelerisque elit, eget gravida eros purus quis massa.
                    Proin efficitur sed ipsum vel sodales. Vestibulum sit amet metus non justo aliquam pellentesque.
                    Proin consequat fermentum sagittis. Vestibulum sit amet magna in est cursus vestibulum.</p>
            </div>
        </div>

    </div>

    <footer>

    </footer>

</body>
@endsection
</html>