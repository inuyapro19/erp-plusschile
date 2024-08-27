

<div class="col-md-11 mx-auto">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="empleador_id">Empleador</label>
                {{Form::text('empleador_id',  isset($contrato->empleador) ?  $contrato->empleador : null,['class'=>'form-control mb-4','disabled'])}}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="ubicacion">Ubicación</label>
                {{Form::text('ubicacion',  isset($contrato->ubicacion) ?  $contrato->ubicacion : null,['class'=>'form-control mb-4','disabled'])}}
            </div>
        </div>

        <div class="col-sm-6">
            <label class="dob-input">Fecha Ingreso</label>
            {{Form::date('fecha_ingreso', isset($contrato->fecha_ingreso) ? $contrato->fecha_ingreso  : \Carbon\Carbon::now(),['class'=>'form-control mb-4','disabled'])}}
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="cargo">Cargo</label>
                {{Form::text('cargo',  isset($contrato->cargo) ?  $contrato->cargo : null,['class'=>'form-control mb-4','disabled'])}}
            </div>
        </div>

      {{--  <div class="col-sm-6">
            <div class="form-group">
                <label for="prevision_id">AFP</label>
                {!!  Form::select(
                    'prevision_id',
                     $afp,
                    isset($contrato->prevision_id) ?  $contrato->prevision_id : '0',
                     $attributes = $errors->has('prevision_id') ? array( 'class' => 'form-control custom-select is-invalid') : array('class' => 'form-control custom-select','disabled')
                    )

                 !!}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="salud_id">Salud</label>
                {!!  Form::select(
                    'salud_id',
                     $salud,
                    isset($contrato->salud_id) ?  $contrato->salud_id : '0',
                     $attributes = $errors->has('salud_id') ? array( 'class' => 'form-control custom-select is-invalid') : array('class' => 'form-control custom-select','disabled')
                    )

                 !!}
            </div>
        </div>--}}

    </div>
</div>
