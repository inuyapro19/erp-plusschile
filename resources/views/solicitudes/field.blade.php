
<div class="row">
    <div class="form-group col-md-12">
        {!! Form::label('comentario', 'Mensaje:') !!}
        {!! Form::textarea('comentario', null, ['class' => 'form-control','id'=>'comentario']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('tipo_solicitud','Tipo Solicitud') !!}
        {!! Form::select('tipo_solicitud',[
                            'copia de contrato'=>'Copia Contrato',
                            'certificado antiguidad'=>'Certificado antiguidad',
                            'carga familiar'=>'Carga Familiar',
                            'modificación de datos'=>'Modificación de datos'
                            ],false,['class'=>'form-control']) !!}
    </div>

    <div class="clearfix"></div>
    @if(isset($solicitud))
    <div class="form-group col-md-6">
        {!! Form::label('estado','Estado') !!}
        {!! Form::select('estado',[
                            'pendiente'=>'Pendiente',
                            'finalizado'=>'Finalizado',

                            ],$solicitud->estado,['class'=>'form-control']) !!}
    </div>
    @endif
    <!-- Submit Field -->
    <div class="form-group col-md-12" >
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
