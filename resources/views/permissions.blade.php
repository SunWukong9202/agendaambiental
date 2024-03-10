@extends('layout')

@section('title', 'Admin - Permisos')

@section('content')
    {{-- <header class="navbar fixed-top bg-light-subtle shadow">
        <div class="container-fluid">
            <button
            class="navbar-toggler d-lg-none"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#sidebar"
            aria-controls="sidebar"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="#" class="navbar-brand">Logo</a>
        </div>

        <div
            class="offcanvas offcanvas-start offcanvas-lg"
            data-bs-scroll="true"
            tabindex="-1"
            id="sidebar"
            aria-labelledby="Enable both scrolling & backdrop"
        >
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
                    Dashboard
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>
            <div class="offcanvas-body w-75 ">
                <p>
                    Home
                </p>
                <p class="">Account</p>
            </div>
        </div>
    </header> --}}

    <div class="container-fluid mt-5 pt-4">
        <div class="row">
            {{-- 
                sidebar class is a fixed positioning, 
                col-lg-3 reserve the space needed for the positioning
                d-lg-block indicates begin to render up to lg breakpoint
                --}}
            {{-- <nav class="col-lg-3 bg-light d-none d-lg-block position-fixed  top-0 bottom-0 start-0 mt-4" style="padding-top: 56px">
            
                <ul class="list-unstyled ps-0">
                    <li class="mb-1">
                      <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                        Home
                      </button>
                      <div class="collapse" id="home-collapse">
                        <ul class="btn-toggle-nav list-unstyled
                        fw-normal pb-1 small">
                          <li><a href="#" class="link-dark rounded">Overview</a></li>
                          <li><a href="#" class="link-dark rounded">Updates</a></li>
                          <li><a href="#" class="link-dark rounded">Reports</a></li>
                        </ul>
                      </div>
                    </li>
                    <li class="border-top my-3"></li>
                    <li class="mb-1">
                      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                        Account
                      </button>
                      <div class="collapse" id="account-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="#" class="link-dark rounded">New...</a></li>
                          <li><a href="#" class="link-dark rounded">Profile</a></li>
                          <li><a href="#" class="link-dark rounded">Settings</a></li>
                          <li><a href="#" class="link-dark rounded">Sign out</a></li>
                        </ul>
                      </div>
                    </li>
                  </ul>
            </nav> --}}

            <main class="col-lg-9 ms-lg-auto px-lg-4">
                    <div class="row flex-row-reverse ">
                        <div class="input-group my-3" style="width:320px">
                            <input type="text" class="form-control" placeholder="buscar...">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </div>
        
                    <div class="table-responsive shadow border p-4 rounded-4 mb-5">
                        <table class="table table-hover ">
                            <thead class="table-light table-borderless">
                                <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user['name'] }}</td>                    
                                        <td>{{ $user['email'] }}</td>
                                        <td class="mb-3">
                                            <select
                                                class="form-select form-select-sm"
                                                name=""
                                                id=""
                                            >
                                                @foreach ($roles as $rol)
                                                    @if ($user['rol'] == $rol)
                                                        <option selected>{{ $rol }}</option>
                                                    @else
                                                        <option value="">{{ $rol }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </main>
        </div>
    </div>
    
@endsection