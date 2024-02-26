<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Ambiental</title>
     {{-- <link rel="stylesheet" href="..\app.css"> --}}
    <!-- Agrega tus estilos CSS aquí -->
    <style>
        
body{
    margin: auto;
    font-family: "Nunito", sans-serif;
    font-size: 0.9rem;
    font-weight: 400;
    line-height: 1.6;
    color: #212529;
    text-align: left;
}
*{
    box-sizing: border-box;
}
.pb-3, .py-3 {
    padding-bottom: 1rem !important;
}
element.style {
    background-color: #115089;
}
.pt-3, .py-3 {
    padding-top: 1rem !important;
}
.container, .container-fluid, .container-xl, .container-lg, .container-md, .container-sm {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
div {
    display: block;
}
.justify-content-end {
    justify-content: flex-end !important;
}
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.mb-auto, .my-auto {
    margin-bottom: auto !important;
}
.mt-auto, .my-auto {
    margin-top: auto !important;
}

/*.col-md-2 {
       flex: 0 0 33.33333333%;
    max-width: 33.33333333%;
}
.col-xl-1 {
    flex: 0 0 33.33333333%;
    max-width: 33.33333333%;
}*/
@media (min-width: 768px)
{
    .col-md-2 {
    flex: 0 0 16.66666667%;
    max-width: 16.66666667%;
}
}

.col-4 {
    flex: 0 0 33.33333333%;
    max-width: 33.33333333%;
}
@media (min-width: 1200px){
    .col-xl-1 {
    flex: 0 0 8.33333333%;
    max-width: 8.33333333%;
}
}

.col-xl, .col-xl-auto, .col-xl-12, .col-xl-11, .col-xl-10, .col-xl-9, .col-xl-8, .col-xl-7, .col-xl-6, .col-xl-5, .col-xl-4, .col-xl-3, .col-xl-2, .col-xl-1, .col-lg, .col-lg-auto, .col-lg-12, .col-lg-11, .col-lg-10, .col-lg-9, .col-lg-8, .col-lg-7, .col-lg-6, .col-lg-5, .col-lg-4, .col-lg-3, .col-lg-2, .col-lg-1, .col-md, .col-md-auto, .col-md-12, .col-md-11, .col-md-10, .col-md-9, .col-md-8, .col-md-7, .col-md-6, .col-md-5, .col-md-4, .col-md-3, .col-md-2, .col-md-1, .col-sm, .col-sm-auto, .col-sm-12, .col-sm-11, .col-sm-10, .col-sm-9, .col-sm-8, .col-sm-7, .col-sm-6, .col-sm-5, .col-sm-4, .col-sm-3, .col-sm-2, .col-sm-1, .col, .col-auto, .col-12, .col-11, .col-10, .col-9, .col-8, .col-7, .col-6, .col-5, .col-4, .col-3, .col-2, .col-1 {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
element.style {
    color: white;
}
.text-right {
    text-align: right !important;
}
.m-0 {
    margin: 0 !important;
}
h4{
    color: #5c94d7;
    display: block;
    margin-block-start: 1.33em;
    margin-block-end: 1.33em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}

h4, .h4 {
    font-size: 1.35rem;
}
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
    margin-bottom: 0.5rem;
    font-weight: 500;
    line-height: 1.2;
}
element.style {
    border-left: 2px solid white;
    border-right: 2px solid white;
}
.text-center {
    text-align: center !important;
}

a {
    color: #3490dc;
    text-decoration: none;
    background-color: transparent;
}

.h-100 {
        height: 100% !important;
}
.w-100 {
    width: 100% !important;
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

    <div class="navbar">
        <a href="#">Inicio</a>
        <a href="#">Instalaciones</a>
        <a href="#">Portal de Postulaciones</a>
        <a href="#">Módulo de Gestión Ambiental</a>
    </div>

    @yield('content')


    <!-- Aquí va el contenido de tu página -->
    <footer>
        <ul class="seccionFooter">
            <li>
                <a class="redSocial text-white" href="https://www.facebook.com/AgendaAmbientalUASLP/">Agenda Ambiental UASLP</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16"></svg>
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>            
            </li>
            <li>
                <a class="redSocial text-white" href="https://www.instagram.com/agendaambiental_uaslp/">agendaambiental_uaslp</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16"></svg>
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
            </li>
            <li>
                <a class="redSocial text-white" href="https://twitter.com/UASLP_Ambiental">AgendaAmbientalUASLP</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">…</svg>
                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>                
            </li> 
            <li>
                <a class="redSocial text-white" href="https://www.youtube.com/channel/UCM0lPQitBWgVSXY-wW_5mag">Agenda Ambiental UASLP</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16"></svg>
                <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.122C.002 7.343.01 6.6.064 5.78l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"></path>

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
</body>

</html>
