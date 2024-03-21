<!DOCTYPE html>
<html lang="es">
@extends('welcome')

@section('title', 'Acopio')

@section('content')
    <style>
        .image-wrapper{
            position: relative;
            padding-bottom: 56.25%;
        }

        .image-wrapper img{
            position: absolute;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        select,
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .success-message {
            display: none;
            text-align: center;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
        }
    </style>

    <div class="container container-lg">
        <form class="p-3 m-2" id="donationForm">
            <h3>Acopio de reactivos</h3>

            <div class="row mb-3">
                <div class="col">
                    <div class="image-wrapper">
                        <img id="picture" src="https://img.freepik.com/vector-premium/icono-marco-fotos-foto-vacia-blanco-vector-sobre-fondo-transparente-aislado-eps-10_399089-1290.jpg" alt="">
                    </div>
                </div>
                    
                <div class="col">
                    <label for="photo">Selecciona la foto del reactivo</label>
                    <input type="file" name="photo" id="photo" class="form-control-file">
                </div>
            </div>
            
            <div class="form-group datosExterno">
                <label>Nombre del reactivo</label>
                <input type="text" class="form-control">
            </div>
            
            <div class="form-group datosExterno">
                <label>Grupo</label>
                <input type="text" class="form-control">
            </div>
            
            <div class="form-group datosExterno">
                <label>Fórmula química</label>
                <input type="text" class="form-control">
            </div>

            <div class="form-group mt-3">
                <label>Tipo de envase</label>
                <select class="form-control" placeholder="Por favor selecciona una opcion">
                    <option>Botella de vidrio</option>
                    <option>Botella de plastico</option>
                    <option>Bolsa de plastico</option>
                    <option>Caja cigarro</option>
                    <option selected>Otro</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Peso con envase (g)</label>
                <input type="number" class="form-control" placeholder="0" step="any">
            </div>
            
            <div class="form-group">
                <label>Cantidad disponible para donación del reactivo</label>
                <input type="number" class="form-control" placeholder="0" step="any">
            </div>

            <div class="form-group mt-3">
                <label>Estado</label>
                <select class="form-control" placeholder="Por favor selecciona una opcion">
                    <option>Solido</option>
                    <option>Liquido</option>
                    <option>Gaseoso</option>
                </select>
            </div>

            <div class="form-group">
                <label>Características</label><br>
                <input type="checkbox"> C<br>
                <input type="checkbox"> R<br>
                <input type="checkbox"> E<br>
                <input type="checkbox"> T<br>
                <input type="checkbox"> I<br>
                <input type="checkbox"> B<br>
            </div>

            <div class="form-group">
                <label>Fecha de caducidad</label>
                <input type="date" class="form-control">
            </div>

            <div class="form-group mt-3">
                <label>Condición del reactivo</label>
                <select class="form-control" placeholder="Por favor selecciona una opcion">
                    <option>Nuevo</option>
                    <option>Seminuevo</option>
                    <option>Usado</option>
                </select>
            </div>

            <div class="form-group datosExterno">
                <label>Facultad de procedencia</label>
                <input type="text" class="form-control">
            </div>

            <div class="form-group datosExterno">
                <label>Laboratorio de procedencia</label>
                <input type="text" class="form-control">
            </div>

            <div class="form-group datosExterno">
                <label>Responsable del reactivo</label>
                <input type="text" class="form-control">
            </div>

            <div class="form-group d-flex flex-row-reverse mt-3">
                <button type="submit">Registrar reactivo</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("photo").addEventListener('change', cambiarImagen);
        function cambiarImagen(event){
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload= (event)=>{
                document.getElementById("picture").setAttribute('src', event.target.result)
            };
            reader.readAsDataURL(file);

        }
    </script>
    
@endsection