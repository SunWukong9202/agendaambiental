@extends('welcome');

@section('title', 'Eventos');

@section('content')
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
            background-color: #DCEEF6;
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
        
        .form-row {
            margin-bottom: 50px;
        }
    </style>

    <div id="contenedor">
        <div id="contenedor-info-1">
            <div id="imagen0">
                <img src="https://conocimiento.blob.core.windows.net/conocimiento/2022/Contables/ContabilidadBancos/CasosPracticos/CP_Usuarios_y_perfiles/drex_usuarios_y_perfiles_custom.png" alt="Submódulo de Acompañamiento de Usuarios">
            </div>
            <div id="info1">
                <h1>Acompañamiento de Usuarios</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed sapien ut nulla consequat scelerisque non at sem. Nullam vulputate, est a consectetur facilisis, odio dolor accumsan nisl, iaculis viverra lacus sapien id eros. Vestibulum
                    quis ipsum ac metus malesuada molestie. Nam congue ex sed auctor suscipit. Mauris pretium nulla lacus, a sagittis orci viverra vel. Vivamus tincidunt pellentesque convallis. Fusce sed cursus dui, id porta sem. Quisque aliquet lectus
                    id tempor egestas. Duis enim nulla, imperdiet sed purus eu, dignissim mattis odio. Morbi volutpat efficitur erat id sollicitudin. Integer mi leo, tempus venenatis maximus in, ullamcorper in turpis.</p>
                <p>Suspendisse potenti. Mauris sit amet bibendum elit. Nunc sed auctor augue. Aenean at urna tempor, sagittis augue a, efficitur ipsum. Maecenas fringilla ut nulla malesuada dictum. Vivamus ornare, ante egestas ullamcorper viverra, massa
                    ante scelerisque elit, eget gravida eros purus quis massa. Proin efficitur sed ipsum vel sodales. Vestibulum sit amet metus non justo aliquam pellentesque. Proin consequat fermentum sagittis. Vestibulum sit amet magna in est cursus
                    vestibulum.
                </p>
            </div>
        </div>

        <div id="contenedor-eventos">

            <h2>¿Necesitar ayuda para desarrollar tu idea? ¡Compártelo!</h2>

            <div class="evento">

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed sapien ut nulla consequat scelerisque non at sem. Nullam vulputate, est a consectetur facilisis, odio dolor accumsan nisl, iaculis viverra lacus sapien id eros. Vestibulum
                    quis ipsum ac metus malesuada molestie. Nam congue ex sed auctor suscipit. Mauris pretium nulla lacus, a sagittis orci viverra vel. Vivamus tincidunt pellentesque convallis. Fusce sed cursus dui, id porta sem. Quisque aliquet lectus
                    id tempor egestas. Duis enim nulla, imperdiet sed purus eu, dignissim mattis odio. Morbi volutpat efficitur erat id sollicitudin. Integer mi leo, tempus venenatis maximus in, ullamcorper in turpis.</p>
                <p>Suspendisse potenti. Mauris sit amet bibendum elit. Nunc sed auctor augue. Aenean at urna tempor, sagittis augue a, efficitur ipsum. Maecenas fringilla ut nulla malesuada dictum. Vivamus ornare, ante egestas ullamcorper viverra, massa
                    ante scelerisque elit, eget gravida eros purus quis massa. Proin efficitur sed ipsum vel sodales. Vestibulum sit amet metus non justo aliquam pellentesque. Proin consequat fermentum sagittis. Vestibulum sit amet magna in est cursus
                    vestibulum.
                </p>


            </div>
            <div class="nombre-evento">

            </div>
        </div>
    </div>


    <div id="info1">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Fecha de Registro</label>
                <input type="date" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress2">Lugar</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Lugar">
            </div>

            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Servicio a Solicitar</label>
            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                    <option selected>Selecciona una Opción</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    </select>

            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="customControlInline">
                <label class="custom-control-label" for="customControlInline">Recuerda mi opción</label>
            </div>

            <label for=" " class="form-label ">Detalles</label>
            <textarea class="form-control " name=" " id=" " rows="3 "></textarea>
        </div>
        <button type="submit " class="btn btn-primary my-1 ">Enviar</button>
    </div>

    <div class="info1">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus cumque dolorem recusandae! Animi necessitatibus delectus, aspernatur illum ipsam aut eius doloremque omnis ea illo ut quibusdam. Beatae aperiam eveniet voluptatem?</p>
    </div>


    </div>
@endsection
