<div class="row mb-5">
    <div class="col-md-12">
        {!! Form::open(['route' =>'trabajadores.index','class'=>'my-2 mb-2 my-lg-0','method'=>'get']) !!}

            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="rut" placeholder="Buscar por rut">
                </div>
                <div class="col-md-4">
                    <select name="cargos" id="cargos" class=" form-control" >
                        <option value="" selected>----Cargos----</option>
                        @foreach($cargos as $cargo)
                            <option value="{{$cargo->id}}">{{$cargo->nombre_cargo}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="empresas" id="empresas" class=" form-control form-control-sm">
                        <option value="" selected>----Empresas----</option>
                        @foreach($empresas as $empresa)
                            <option value="{{$empresa->id}}">{{$empresa->nombre_empleador}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <select name="ubicaciones" id="ubicaciones" class=" form-control form-control-sm">
                    <option value="" selected>----Ubicaciones----</option>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{$ubicacion->id}}">{{$ubicacion->nombre_ubicacion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="fecha_ingreso_inicio">Fecha Ingreso Inicial</label>
                <input type="date" name="fecha_ingreso_inicio" class="form-control form-control-sm" id="fecha_ingreso_inicio" placeholder="Fecha de ingreso">
            </div>
            <div class="col-md-4">
                <label for="fecha_ingreso_inicio">Fecha Ingreso Final</label>
                <input type="date" name="fecha_ingreso_final" class="form-control form-control-sm" placeholder="Fecha de Final">
            </div>
            <div class="col-md-4">

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success">Filtrar</button>
            </div>
        </div>
        {!! Form::close() !!}
      {{--  <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{route('export.trabajadores')}}" class="btn btn-success" title="Excel"><i class="fa fa-file-excel"></i></a>
                <a href="{{route('export.trabajadores')}}" class="btn btn-danger" title="Pdf"><i class="fa fa-file-pdf"></i></a>
            </div>

        </div>--}}
    </div>

</div>
