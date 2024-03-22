@extends('welcome');

@section('title', 'Eventos');

@section('content')

    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-6 d-flex justify-content-center align-items-center">
                <img 
                class="img-fluid"
                src="https://conocimiento.blob.core.windows.net/conocimiento/2022/Contables/ContabilidadBancos/CasosPracticos/CP_Usuarios_y_perfiles/drex_usuarios_y_perfiles_custom.png" alt="Submódulo de Acompañamiento de Usuarios">
            </div>
            <div class="col-6 text-justify">
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

        <div class="row m-5 bg-info-subtle rounded-4 p-5">
            <div class=" col-sm-6 bg-info-subtle text-justify">
                <h2>¿Necesitar ayuda para desarrollar tu idea? ¡Compártelo!</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed sapien ut nulla consequat scelerisque non at sem. Nullam vulputate, est a consectetur facilisis, odio dolor accumsan nisl, iaculis viverra lacus sapien id eros. Vestibulum
                    quis ipsum ac metus malesuada molestie. Nam congue ex sed auctor suscipit. Mauris pretium nulla lacus, a sagittis orci viverra vel. Vivamus tincidunt pellentesque convallis. Fusce sed cursus dui, id porta sem. Quisque aliquet lectus
                    id tempor egestas. Duis enim nulla, imperdiet sed purus eu, dignissim mattis odio. Morbi volutpat efficitur erat id sollicitudin. Integer mi leo, tempus venenatis maximus in, ullamcorper in turpis.</p>
                <p>Suspendisse potenti. Mauris sit amet bibendum elit. Nunc sed auctor augue. Aenean at urna tempor, sagittis augue a, efficitur ipsum. Maecenas fringilla ut nulla malesuada dictum. Vivamus ornare, ante egestas ullamcorper viverra, massa
                    ante scelerisque elit, eget gravida eros purus quis massa. Proin efficitur sed ipsum vel sodales. Vestibulum sit amet metus non justo aliquam pellentesque. Proin consequat fermentum sagittis. Vestibulum sit amet magna in est cursus
                    vestibulum.
                </p>
            </div>
            <div class="col-sm-6 p-5">
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
                <button type="submit " class="btn btn-primary my-1 mt-3
                ">Enviar</button>
            </div>
        </div>
    </div>

@endsection
