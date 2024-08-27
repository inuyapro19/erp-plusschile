
<div class="row">
    <div class="form-group col-md-6">
        {!! Form::label('tipo_reclamo','Tipo Mensaje') !!}
        {!! Form::select('tipo_reclamo',[
                            'reclamo'=>'Reclamo',
                            'sugerencia'=>'Sugerencia',
                            'felicitaciones'=>'Felicitaciones'
                            ],false,['class'=>'form-control']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('area_id','Area') !!}
        {!! Form::select('area_id',$area,false,['class'=>'form-control']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('area_operacional','Area operacional') !!}
        {!! Form::select('area_operacional',[
                'seguridad'=>'Seguridad',
                'salud'=>'Salud',
                'medio ambiental'=>'Medio Ambiental',
                'operacional'=>'Operacional',
                'recursos humanos'=>'Recursos Humanos'
            ],false,['class'=>'form-control']) !!}
    </div>
    <div class="form-group col-md-8">
        {!! Form::label('mensaje_descripcion', 'Escriba su mensaje de raclamo , sugerencia , felicitaciones :') !!}
        {!! Form::textarea('mensaje_descripcion', null, ['class' => 'form-control','id'=>'mensaje_descripcion']) !!}
    </div>

    <div class="form-group col-md-8">
        {!! Form::label('mensaje_propuestas', 'Tiene alguna Propuesta:') !!}
        {!! Form::textarea('mensaje_propuestas', null, ['class' => 'form-control','id'=>'mensaje_propuestas']) !!}
    </div>

    <div class="form-group col-md-8">
        {!! Form::label('mensaje_de_mejoras', 'Sugerencia de Mejoras:') !!}
        {!! Form::textarea('mensaje_de_mejoras', null, ['class' => 'form-control','id'=>'mensaje_de_mejoras']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('mensaje_anonimo','Mensaje anonimo') !!}
        {!! Form::select('mensaje_anonimo',[
                            'si'=>'si',
                            'no'=>'no'
                            ],false,['class'=>'form-control']) !!}
    </div>
    <div class="clearfix"></div>

<!-- Submit Field -->
    <div class="form-group col-md-12" >
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

