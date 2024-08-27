
<div class="col-md-11 mx-auto">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="nombre2">Nombre</label>
                {{Form::text('nombre2',isset($contacto->nombre_2) ? $contacto->nombre_2 : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="apellido2">Apellido</label>
                {{Form::text('apellido2',isset($contacto->apellido_2) ? $contacto->apellido_2 : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="telefono2">Télefono</label>
                {{Form::text('telefono2',isset($contacto->telefono_2) ? $contacto->telefono_2 : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="correo2">Correo</label>
                {{Form::email('correo2',isset($contacto->correo_2) ? $contacto->correo_2 : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="direccion2">Dirección</label>
                {{Form::text('direccion2',isset($contacto->direccion_2) ? $contacto->direccion_2 : null,['class'=>'form-control mb-4'])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="direccion2">Región</label>
                {!!  Form::select(
                    'contacto_region_id2',
                     $region,
                    isset($contacto->region_id_2) ?  $contacto->region_id_2 : '0',
                     $attributes = $errors->has('contacto_region_id2') ? array( 'class' => 'form-control custom-select is-invalid') : array('class' => 'form-control custom-select')
                    )

                 !!}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="comuna_id">comuna</label>
                {!!  Form::select(
                  'contacto_comuna_id2',
                 $comunas
                 ,
                  isset($contacto->comuna_id_2) ?  $contacto->comuna_id_2 : '0'
                  ,
                   $attributes = $errors->has('contacto_comuna_id2') ? array( 'class' => 'form-control custom-select is-invalid') : array('class' => 'form-control custom-select')
                  )

               !!}
            </div>
        </div>
    </div>
</div>
