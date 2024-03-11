@extends('welcome');

@section('title', 'Registro de solicitud de Reactivos');

@section('content')
    <style>
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
    <div class="container">
        <h1>Solcitud de reactivos</h1>
        <div class="form-container">
            <h2>Datos personales</h2>
            <form id="donation-form">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido_paterno">Apellido Paterno:</label>
                    <input type="text" id="apellido_paterno" name="apellido_paterno" required>
                    <label for="apellido_materno">Apellido Materno:</label>
                    <input type="text" id="apellido_materno" name="apellido_materno" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                </div>

                <h2>Informacion del Reactivo</h2>

                <div class="form-group">
                    <label for="tipo_reactivo">Tipo de Reactivo:</label>
                    <select id="tipo_reactivo" name="tipo_reactivo" required>
                        <option value="react1">Reactivo 1</option>
                        <option value="react2">Reactivo 2</option>
                        <option value="react3">Reactivo 3</option>
                        <option value="react4">Reactivo 4</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" required>
                </div>

                <!--<div class="form-group">
                    <label for="estado_articulo">Estado del Artículo:</label>
                    <input type="text" id="estado_articulo" name="estado_articulo" required>
                </div>
                 -->
                <div class="form-group">
                    <button type="submit" id="enviarSolicitud">Enviar Solicitud</button>
                </div>
            </form>
        </div>
        <div class="success-message" id="success-message">
            ¡Envio exitoso!
        </div>
    </div>

    <script>
        document.getElementById('donation-form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            document.getElementById('success-message').style.display = 'block';
        });
    </script>
@endsection