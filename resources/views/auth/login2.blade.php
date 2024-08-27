@extends('auth.app')
@section('content')
<div class="form-container">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 class=""><img src="{{asset('images/logo-pluss-header.png')}}" width="320" alt=""></h1>
                                <p class="text-center" style="font-size: 25px">Intranet</p>
                    <div class="alert alert-warning">
                        Ingresa con tu rut sin puntos y con guión y la contraseña temporal: pluss2021
                        (Deberas cambiar tu contraseña en tu primer ingreso)
                    </div>
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <form class="text-left" action="login" method="POST">
                        @csrf
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="rut" type="text" placeholder="RUT" class="form-control @error('rut') is-invalid @enderror" name="rut" oninput="checkRut(this)" required autocomplete="rut" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper toggle-pass">
                                    <p class="d-inline-block">Mostrar Contraseña</p>
                                    <label class="switch s-primary">
                                        <input type="checkbox" id="toggle-password" class="d-none">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" value="">{{ __('Login') }}</button>
                                </div>

                            </div>

                            {{--<div class="field-wrapper text-center keep-logged-in">
                                  <div class="n-chk new-checkbox checkbox-outline-primary">
                                      <label class="new-control new-checkbox checkbox-outline-primary">
                                          <input type="checkbox" class="new-control-input">
                                          <span class="new-control-indicator"></span>Keep me logged in
                                      </label>
                                  </div>
                              </div>
                                --}}
                              <div class="field-wrapper">
                                  <a href="{{route('password.request')}}" class="forgot-pass-link">Recuperar Contraseña</a>
                              </div>

                        </div>
                    </form>
                    <p class="terms-conditions">© {{date('Y')}} Plusschile. Desarrolado por <a href="https://fizz.cl" target="_blank">Fizz</a></p>

                </div>
            </div>
        </div>
    </div>
    <div class="form-image">
        <div class="l-image">
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function checkRut(rut) {
            // Despejar Puntos
            var valor = rut.value.replace('.','');
            // Despejar Guión
            valor = valor.replace('-','');

            // Aislar Cuerpo y Dígito Verificador
            cuerpo = valor.slice(0,-1);
            dv = valor.slice(-1).toUpperCase();

            // Formatear RUN
            rut.value = cuerpo + '-'+ dv

            // Si no cumple con el mínimo ej. (n.nnn.nnn)
            if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}

            // Calcular Dígito Verificador
            suma = 0;
            multiplo = 2;

            // Para cada dígito del Cuerpo
            for(i=1;i<=cuerpo.length;i++) {

                // Obtener su Producto con el Múltiplo Correspondiente
                index = multiplo * valor.charAt(cuerpo.length - i);

                // Sumar al Contador General
                suma = suma + index;

                // Consolidar Múltiplo dentro del rango [2,7]
                if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }

            }

            // Calcular Dígito Verificador en base al Módulo 11
            dvEsperado = 11 - (suma % 11);

            // Casos Especiales (0 y K)
            dv = (dv == 'K')?10:dv;
            dv = (dv == 0)?11:dv;

            // Validar que el Cuerpo coincide con su Dígito Verificador
            if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }

            // Si todo sale bien, eliminar errores (decretar que es válido)
            rut.setCustomValidity('');
        }
    </script>
@endpush
