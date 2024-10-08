<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Ambiental</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
           <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />

     {{-- <link rel="stylesheet" href="..\app.css"> --}}
    <!-- Agrega tus estilos CSS aquí -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        a {
            color: #3490dc;
            text-decoration: none;
            background-color: transparent;
        }
        
        img {
            vertical-align: middle;
            border-style: none;
            overflow-clip-margin: content-box;
            overflow: clip;
        }
        a {
            color: #3490dc;
            text-decoration: none;
            background-color: transparent;
        }

        .navbar {
                    background-color: rgb(255, 255, 255); /* Color del navbar */
                    height: 50px; /* Ajusta la altura según tus necesidades */
                    width: 100%; /* Cubre de lado a lado */
                    text-align: left; /* Alinea el texto a la izquierda */
                    padding: 0 20px; /* Agrega espacio interior */
                    display: flex;
                }
        .navbar a{
            color:darkgrey;
            font-family: "Nunito", sans-serif;
            padding: 15px;
        }
        footer{
            padding: 20px 20px 20px;
            background-color: #115089;
            max-width: 100%;
        /* margin: 25px auto;*/
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        .seccionFooter{
            text-align: center;
            display: inline-grid;
            list-style: none;
        /* margin: 25px auto;*/
            width: 300px;
            height: 120px;
            font-family: Myraid light;
        }
        ul{
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            padding-inline-start: 40px;
        }
        .seccionFooter li {
            height: 25px;
            width: auto;
        }
        li {
            display: list-item;
            text-align: -webkit-match-parent;
        }
        .detalleUbicacion {
            margin-left: 15px;
            font-size: 18px;
            display: inline-block;
            text-align: start;
            color: white;
        }
        .mapa {
            display: inline-grid;
        }
        .mapa iframe {
            width: 100%;
            height: 100%;
        }
        .contenidoPagina{
            height:400px;
            width: 100%;
        }
        iframe {
            overflow-clip-margin: content-box !important;
            overflow: clip !important;
            border-width: 2px;
            border-style: inset;
            border-color: initial;
            border-image: initial;
        }


    </style>

    </head>
<body>
    <div class="container-fluid py-3" style="background-color: #115089; ">
        <div class="row justify-content-end ">
            <div class="col-xl-2 col-md-2  col-4 my-auto">
                <h4 style="color: white;" class="m-0 text-right"> Mi portal</h4>                
            </div>
            <div class="col-xl-1  col-md-2  col-4 text-center" style=" border-left: 2px solid white; border-right:2px solid white;">
                <a class="text-center" href="https://ambiental.uaslp.mx">
                    <img src="https://ambiental.uaslp.mx/storage/imagenes/Logos/logoagenda-Bienvenida.png" class="w-100 h-100">
                </a>
            </div>
            <div class="col-xl-1  col-md-2  col-4 my-auto text-center ">
                <a class="http://www.uaslp.mx/" target="_blank" href="#">
                    <img src="https://ambiental.uaslp.mx/storage/imagenes/Logos/LogoUaslp_17Gemas.png" class="w-100 h-100 ">
                </a>
            </div>
        </div>
    </div>

    @section('navigation')
    @show
    <nav class="navbar navbar-expand-lg navbar-light bg-light">        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('agendaAmbiental') }}">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Instalaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Portal de Postulaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client.home') }}">
                        Módulo de Gestión Ambiental
                    </a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="#" class="nav-link">
                    {{ $user['name'] ?? '' }} - {{ $user['rol'] ?? '' }}
                </a>
                <a href="{{ route('logout') }}" class="nav-link">
                    Log out
                </a>
            </div>
        </div>
    </nav>    

    @section('content')
        <div class="contenidoPagina">
        </div>
    @show

    <!-- Aquí va el contenido de tu página -->
    <footer>
        <ul class="seccionFooter">
            <li>
                <a class="redSocial text-white" href="https://www.facebook.com/AgendaAmbientalUASLP/">Agenda Ambiental UASLP</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16"></svg>
            </li>
            <li>
                <a class="redSocial text-white" href="https://www.instagram.com/agendaambiental_uaslp/">agendaambiental_uaslp</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16"></svg>
            </li>
            <li>
                <a class="redSocial text-white" href="https://twitter.com/UASLP_Ambiental">AgendaAmbientalUASLP</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">…</svg>
            </li> 
            <li>
                <a class="redSocial text-white" href="https://www.youtube.com/channel/UCM0lPQitBWgVSXY-wW_5mag">Agenda Ambiental UASLP</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16"></svg>

            </li> 
        </ul>
        <ul>
            <li class="detalleUbicacion"> Agenda Ambiental, UASLP </li>
            <li class="detalleUbicacion"> Manuel Nava #201, último piso </li>
            <li class="detalleUbicacion"> Col. Universitaria, 78210 </li>
            <li class="detalleUbicacion"> San Luis Potosí, S. L. P. México </li>
            <li class="detalleUbicacion"> Tel. +52 (444) 826-2300 Ext. 7204 </li>
        </ul>
        <div class="mapa"> 
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3695.4628484651503!2d-101.01842582602943!3d22.146446948457093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842a98d247b03393%3A0xdf169057b20b53ed!2sAgenda%20Ambiental!5e0!3m2!1ses-419!2smx!4v1708296021779!5m2!1ses-419!2smx" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        

    </footer>
     <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>

</html>
