<form class="p-3 m-2">
    <h3>
        Datos Personales
    </h3>

    <div class="form-group mt-3">
        <label for="exampleFormControlSelect1">Evento</label>
        <select class="form-control" wire:change="updateEventInf($event.target.value)" id="exampleFormControlSelect1">
            <option disabled selected>Selecciona Un Evento</option>
            @foreach ($events as $e)
                <option value="{{$e->id}}">{{ $e->name }}</option>
            @endforeach
        </select>
    </div>
    

    <div class="row">
        <div class="col-4 col-4-md">
            <div class="form-group">
                <label for="exampleInputEmail1">Clave Unica</label>
                <x-input-text name='clave' wire:model.blur="clave" class="form-control"/>
            </div>
        </div>
        <div class="col-4 col-4-md">
            <div class="form-group">
                <label for="exampleInputEmail1">Facultad</label>
                <input type="text" disabled value="{{ $user?->facultad ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label for="exampleInputEmail1">Nombre(s)</label>
        <input type="text" disabled value="{{ $user?->name ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled >
    </div>
    <div class="row">
        <div class="col-4 col-4-md">
            <div class="form-group">
                <label for="exampleInputEmail1">Apellido paterno</label>
                <input type="text" disabled value="{{ $user?->ap_pat ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled>
            </div>
        </div>
        <div class="col-4 col-4-md">
            <div class="form-group">
                <label for="exampleInputEmail1">Apellido materno</label>
                <input type="text" disabled value="{{ $user?->ap_mat ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled >
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <label for="exampleFormControlSelect1">Nivel Academico</label>
        <input type="text" disabled value="{{ $user?->nivel_academico ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled >
      </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Telefono</label>
        <input type="text" disabled value="{{ $user?->telefono ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>

    <h3>
        Informacion del evento
    </h3>

    <div class="form-group mt-3">
      <label for="exampleInputPassword1">Ubicacion</label>
      <input type="text" value="{{$ubicacion}}" disabled class="form-control" id="exampleInputPassword1">
    </div>

    <div class="form-group mt-3">
        <label for="exampleInputPassword1">Horario</label>
        <input type="text" value="{{$horario}}" disabled class="form-control" id="exampleInputPassword1">
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