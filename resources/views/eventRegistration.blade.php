@extends('welcome')

@section('content')
<div class="container-fluid container-lg">
    <form class="p-3 m-2">
        <h3>
            Datos Personales
        </h3>
        <div class="form-group mt-3">
            <label for="exampleFormControlSelect1">Nivel Academico</label>
            <select class="form-control" placeholder="Por favor selecciona una opcion" id="exampleFormControlSelect1">
                <option>Nivel Medio Superior</option>
                <option>Licenciatura</option>
                <option>Maestria</option>
                <option>Doctorado</option>
                <option>Otro</option>
            </select>
          </div>
        
        <div class="form-group">
            <label for="exampleInputEmail1">Nombre(s)</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled >
        </div>
        <div class="row">
            <div class="col-4 col-4-md">
                <div class="form-group">
                    <label for="exampleInputEmail1">Apellido paterno</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled>
                </div>
            </div>
            <div class="col-4 col-4-md">
                <div class="form-group">
                    <label for="exampleInputEmail1">Apellido materno</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled >
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-4 col-4-md">
                <div class="form-group">
                    <label for="exampleInputEmail1">Facultad</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled>
                </div>
            </div>
            <div class="col-4 col-4-md">
                <div class="form-group">
                    <label for="exampleInputEmail1">Clave Unica</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled >
                </div>
            </div>
        </div>
    
        <div class="form-group">
            <label for="exampleInputEmail1">Telefono</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="(444) 432 3232">
        </div>
    
        <h3>
            Informacion del evento
        </h3>
    
        <div class="form-group mt-3">
          <label for="exampleInputPassword1">Ubicacion</label>
          <input type="text" value="Av. Niño Artillero #221" class="form-control" id="exampleInputPassword1">
        </div>
    
        <div class="form-group mt-3">
            <label for="exampleInputPassword1">Horario</label>
            <input type="text" value="14:00 - 16:00" class="form-control" id="exampleInputPassword1">
        </div>
          
        <h3>
            Informacion Estadistica
        </h3>
        
        
        <div class="form-group mt-3">
            <label for="exampleFormControlSelect1">Has asistido a cursos o talleres en la Agenda Ambiental</label>
            <select class="form-control" placeholder="Por favor selecciona una opcion" id="exampleFormControlSelect1">
                <option>SI</option>
                <option>No</option>
                <option>Prefiero no Responder</option>
            </select>
        </div>
        
        <div class="form-group mt-3">
        <label for="exampleFormControlSelect1">Te Interesaria seguir participando en actividades de la Agenda Ambiental</label>
        <select class="form-control" placeholder="Por favor selecciona una opcion" id="exampleFormControlSelect1">
            <option>SI</option>
            <option>No</option>
            <option>Prefiero no Responder</option>
        </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Comentarios y Sugerencias</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
          </div>
    
        <div class="form-group d-flex flex-row-reverse mt-3">
            <button type="submit" class="btn btn-success w-25">Submit</button>
        </div>
    </form>
</div>

  
    
@endsection