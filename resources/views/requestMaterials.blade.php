@extends('welcome')

@section('content')


    <div class="container-fluid container-md">
        <h1 class="px-2">Historial de Solicitudes</h1>
        <div class="p-3 row flex-row-reverse ">
            {{-- <button type="button" class="w-25 btn btn-primary" data-toggle="modal" 
                data-target="#myModal">
                Solicitud <i class="bi bi-plus"></i>
            </button> --}}
            <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Solicitud <i class="bi bi-plus"></i>
              </button>
        </div>
        <div class="table-responsive shadow border p-4 rounded-4 mb-5">
            <table class="table table-hover ">
                <thead class="table-light table-borderless">
                    <tr>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Solicitado</th>
                    <th>Aprobado</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $req)
                        <tr>
                            <td>{{ $req['material'] }}</td>                    
                            <td>{{ $req['cantidad'] }} Kg</td>
                            <td>
                                @if ($req['estado'] == 'Aceptada')
                                
                                <span class="badge rounded-pill bg-success">{{ $req['estado'] }}</span>
                                    
                                @elseif ($req['estado'] == 'En curso')
                                <span class="badge rounded-pill bg-secondary">{{ $req['estado'] }}</span>
    
                                @elseif ($req['estado'] == 'Rechazada')
                                <span class="badge rounded-pill bg-danger">{{ $req['estado'] }}</span>
                                    
                                @endif                        
                            </td>
                            <td>{{ $req['solicitado'] }}</td>
                            <td>{{ $req['aprobado'] }}</td>
                            <td>
                                <a
                                    class="btn btn-outline-danger mr-auto"
                                    href="#"
                                    role="button"
                                    >
                                    <i class="bi bi-trash"></i>
                                    </a
                                >
                                <a
                                    class="btn btn-primary ml-auto"
                                    href="#"
                                    role="button"
                                    >
                                    <i class="bi bi-pencil-square"></i>
                                    
                                    </a
                                >
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


      <!-- Modal -->
      <div class="modal fade" id="exampleModal">
        <div class="modal-dialog">
          <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Formulario de Solicitud</h5>
                <button type="button" class="btn-close" data-dismiss="modal">

                </button>
              </div>

            <div class="modal-body">
                <form>
                  <div class="mb-3">
                    <label for="" class="form-label">Material:</label>
                    <select
                        class="form-select form-select-lg"
                        name=""
                        id=""
                    >
                        <option selected disabled>Selecciona un material</option>
                        @foreach ($materiales as $material)
                        <option value="{{ $material }}">{{ $material }}</option>   
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label for="cantidad" class="col-form-label">Cantidad (Kg):</label>
                    <input type="text" class="form-control" id="cantidad">
                  </div>
                  
                  <div class="form-group mb-3">
                    <label for="exampleFormControlTextarea1">Para que desea el material (Opcional):</label>
                    <textarea class="form-control" id="textArea" rows="4"></textarea>
                  </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Enviar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection