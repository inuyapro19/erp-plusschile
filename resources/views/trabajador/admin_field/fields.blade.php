<div class="col-lg-11 mx-auto">
    <div class="row">
        <div class="col-xl-2 col-lg-12 col-md-4">
            <div class="upload mt-4 pr-md-4">
                <input type="file" id="input-file-max-fs" class="dropify" data-default-file="{{asset('assets/img/200x200.jpg')}}" data-max-file-size="2M" />
                <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Subir Imagen</p>
            </div>
        </div>
        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
            <div class="form">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="rut">RUT</label>
                            {{Form::text('rut',$trabajador->rut,['class'=>'form-control mb-4','id'=>'rut'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="primer_nombre">Primer Nombre</label>
                            {{Form::text('primer_nombre',$trabajador->primer_nombre,['class'=>'form-control mb-4'])}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="segundo_nombre">Segundo Nombre</label>
                            {{Form::text('segundo_nombre',$trabajador->segundo_nombre,['class'=>'form-control mb-4'])}}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="primer_apellido">Primer Apellido</label>
                            {{Form::text('primer_apellido',$trabajador->primer_apellido,['class'=>'form-control mb-4'])}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="segundo_apellido">Segundo Apellido</label>
                            {{Form::text('segundo_apellido',$trabajador->segundo_apellido,['class'=>'form-control mb-4'])}}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="dob-input">Fecha Nacimiento</label>
                        {{Form::date('fecha_nac',$trabajador->fecha_nac,['class'=>'form-control mb-4'])}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="telefono_celular">Télefono Móvil</label>
                            {{Form::text('telefono_celular',$trabajador->telefono_celular,['class'=>'form-control mb-4'])}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="telefono_local">Télefono (Opcional) </label>
                            {{Form::text('telefono_local',$trabajador->telefono_local,['class'=>'form-control mb-4'])}}
                        </div>
                    </div>



                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            {{Form::email('correo',$trabajador->correo,['class'=>'form-control mb-4'])}}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            {{Form::text('direccion',$trabajador->direccion,['class'=>'form-control mb-4'])}}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="region_id">Región</label>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="comuna_id">Comuna</label>

                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>
</div>
