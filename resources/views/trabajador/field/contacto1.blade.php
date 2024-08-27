
<div class="col-md-11 mx-auto">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="nombre1">Nombre</label>
                {{Form::text('nombre1',isset($contacto->nombre) ? $contacto->nombre : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="apellido1">Apellido</label>
                {{Form::text('apellido1',isset($contacto->apellido) ? $contacto->apellido : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="telefono1">Télefono</label>
                {{Form::text('telefono1',isset($contacto->telefono) ? $contacto->telefono : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="correo1">Correo</label>
                {{Form::email('correo1',isset($contacto->correo) ? $contacto->correo : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="direccion1">Dirección</label>
                {{Form::text('direccion1',isset($contacto->direccion) ? $contacto->direccion : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="direccion">Región</label>
                {!!  Form::select(
                    'contacto_region_id1',
                     $region,
                    isset($contacto->region_id) ?  $contacto->region_id : '0',
                     $attributes = $errors->has('contacto_region_id1') ? array( 'class' => 'form-control custom-select is-invalid') : array('class' => 'form-control custom-select')
                    )

                 !!}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="comuna_id">comuna</label>
                {!!  Form::select(
                  'contacto_comuna_id1',
                 $comunas
                 ,
                  isset($contacto->comuna_id) ?  $contacto->comuna_id : '0'
                  ,
                   $attributes = $errors->has('contacto_comuna_id1') ? array( 'class' => 'form-control custom-select is-invalid') : array('class' => 'form-control custom-select')
                  )

               !!}
            </div>
        </div>
    </div>
</div>
