<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>EventManagement</title>
</head>

<body>
    <div class="container-fluid container-lg">
        <form class="p-3 m-2" id="donationForm">
            <h3>Acopio de residuos</h3>
            <div class="form-group">
                <label>Selecciona tu tipo de usuario:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="userType" id="interno" value="interno" checked>
                    <label class="form-check-label" for="interno">Interno</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="userType" id="externo" value="externo">
                    <label class="form-check-label" for="externo">Externo</label>
                </div>
            </div>
            <div class="form-group">
                <label>Sede</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Fecha</label>
                <input type="date" class="form-control">
            </div>
            <div class="form-group datosExterno">
                <label>Nombre(s)</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group datosExterno">
                <label>Apellido paterno</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group datosExterno">
                <label>Apellido materno</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group datosExterno">
                <label>Genero</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group datosExterno">
                <label>Entidad de procedencia</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group datosExterno">
                <label>Correo electrónico</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group datosExterno">
                <label>Apellido materno</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group datosInterno">
                <label>Clave del donante</label>
                <input type="text" class="form-control" placeholder="Ingresa la clave del donante">
            </div>
            <div class="form-group mt-3">
                <label>Tipo de artículo</label>
                <select class="form-control" placeholder="Por favor selecciona una opcion">
                    <option>Electrónicos</option>
                    <option>Medicamentos</option>
                    <option>Reciclables</option>
                    <option>Colillas cigarro</option>
                    <option>Mezclilla</option>
                    <option>Aceite de cocina</option>
                    <option>Pilas</option>
                    <option>Toner</option>
                </select>
            </div>
            <div class="form-group">
                <label>Cantidad (kg)</label>
                <input type="number" class="form-control" placeholder="0" step="any">
            </div>
            <div class="form-group d-flex flex-row-reverse mt-3">
                <button type="submit" class="btn btn-success w-25">Registrar donación</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userTypeRadios = document.querySelectorAll('input[name="userType"]');
            const claveDonante = document.querySelector('.claveDonante');
            const datosInterno = document.querySelectorAll('.datosInterno');
            const datosExterno = document.querySelectorAll('.datosExterno');

            userTypeRadios.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    if (radio.value === 'interno') {
                        datosInterno.forEach(function(item) {
                            item.style.display = 'block';
                        });
                        datosExterno.forEach(function(item) {
                            item.style.display = 'none';
                        });
                    } else {
                        datosInterno.forEach(function(item) {
                            item.style.display = 'none';
                        });
                        datosExterno.forEach(function(item) {
                            item.style.display = 'block';
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>