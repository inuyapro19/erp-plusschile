<div class="modal fade bd-example-modal-lg" id="mensajes-{{$modal->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sugerencias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>{{$modal->anonimo == 'no' ? $modal->trabajador->primer_nombre .' '.$modal->trabajador->primer_apellido : '' }}</h3>
                <div class="form-group col-md-6">
                    {!! Form::label('tipo_reclamo','Tipo Mensaje') !!}
                    {!! Form::select('tipo_reclamo',[
                                        'reclamo'=>'Reclamo',
                                        'sugerencia'=>'Sugerencia',
                                        'felicitaciones'=>'Felicitaciones'
                                        ],$modal->tipo_reclamo,['class'=>'form-control','disabled'=>true]) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('area_id','Area') !!}
                    {!! Form::select('area_id',$area,$modal->areas_id,['class'=>'form-control','disabled'=>true]) !!}
                </div>

                <div class="form-group col-md-6">
                    {!! Form::label('area_operacional','Area operacional') !!}
                    {!! Form::select('area_operacional',[
                            'seguridad'=>'Seguridad',
                            'salud'=>'Salud',
                            'medio ambiental'=>'Medio Ambiental',
                            'operacional'=>'Operacional',
                            'recursos humanos'=>'Recursos Humanos'
                        ],$modal->area_operacion,['class'=>'form-control','disabled'=>true]) !!}
                </div>

                <div class="form-group col-md-8">
                    {!! Form::label('mensaje_descripcion', 'Escriba su mensaje de raclamo , sugerencia , felicitaciones :') !!}
                    {!! Form::textarea('mensaje_descripcion', $modal->mensaje_descripcion, ['class' => 'form-control','id'=>'mensaje_descripcion','disabled'=>true]) !!}
                </div>

                <div class="form-group col-md-8">
                    {!! Form::label('mensaje_propuestas', 'Tiene alguna Propuesta:') !!}
                    {!! Form::textarea('mensaje_propuestas',  $modal->mensaje_propuestas, ['class' => 'form-control','id'=>'mensaje_propuestas','disabled'=>true]) !!}
                </div>

                <div class="form-group col-md-8">
                    {!! Form::label('mensaje_de_mejoras', 'Sugerencia de Mejoras:') !!}
                    {!! Form::textarea('mensaje_de_mejoras',  $modal->mensaje_de_mejoras, ['class' => 'form-control','id'=>'mensaje_de_mejoras','disabled'=>true]) !!}
                </div>

                <div class="form-group col-md-8">
                    {!! Form::label('respuesta_sugerencia', 'Sugerencia de Mejoras:') !!}
                    {!! Form::textarea('respuesta_mejora',  $modal->mensaje_de_mejoras, ['class' => 'form-control','id'=>'mensaje_de_mejoras','disabled'=>true]) !!}
                </div>

                {!! Form::open(['route' => 'sugerencia.respuesta','files'=>'true']) !!}
                    <input type="hidden" name="id" value="{{$modal->id}}">
                        <div class="form-group col-md-8">
                            {!! Form::label('respuestas', 'Responder Sugerencia:') !!}
                            {!! Form::textarea('respuesta',  null, ['class' => 'form-control','id'=>'respuesta','disabled'=>false]) !!}
                        </div>
                        <button type="submit" class="btn btn-success">Enviar</button>
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
