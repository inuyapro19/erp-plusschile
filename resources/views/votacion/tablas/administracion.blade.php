@if($administracion->count()>0)
    <form action="">
        <h1>Administración</h1>
        <table class="table table-hover table-striped">
            <thead>
            <td>#</td>
            <td>Nombre</td>
            <td>Cargo</td>
            <td>Votación</td>
            </thead>
            <tbody>
            @foreach($lista as $usuarios)
                <tr>
                    <td>#</td>
                    <td>{{$usuarios->name.' '.$usuarios->apellidos}}</td>
                    <td>{{$usuario->cargo}}</td>
                    <td>
                       {{-- <div class="n-chk">
                            <label class="new-control new-radio radio-primary">
                                <input type="radio" class="new-control-input" name="votar" value="{{$usuarios->id}}">
                                <span class="new-control-indicator"></span>
                            </label>
                        </div>--}}
                        <div class="n-chk">
                            <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                                <input type="checkbox" name="votar[]" value="{{$usuarios->id}}" class="new-control-input">
                                <span class="new-control-indicator"></span><span class="new-chk-content"></span>
                            </label>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
@endif
