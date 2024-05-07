@extends('layouts.layout');

@section('title', 'Login');

@section('content')

<section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="sticky-bottom ">
            </div> 

            <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <img src="{{ asset('images/logouaslp.jpg') }}" 
                style="border-radius: 1rem 1rem 0 0;"
                class="img-fluid bg-black " id="imglogo" alt="">

                <div class="card-body p-5 text-center">
    
                    <h3 class="mb-5">Log in</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="form-outline mb-4">
                            <input type="text" id="clave" name="clave" value="{{ old('clave') }}" class="form-control form-control-lg" />
                            <label class="form-label" for="clave">Clave</label>
                        </div>
            
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control form-control-lg" />
                            <label class="form-label" for="password">Contraseña</label>
                        </div>
        
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Log in</button>
                    </form>
                </div>
            
            </div>
        </div>
      </div>
    </div>
  </section>
@endsection