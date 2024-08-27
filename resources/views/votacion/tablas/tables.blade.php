@if($lista->count()>0)
    {!! Form::open(['route' =>['enviar_voto',$clave],'method'=>'post']) !!}
        <h1>{{$titulo ?? ''}} </h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>

        <td>Nombre</td>
        <td>Cargo</td>
        <td>Votación</td>
        </thead>
        <tbody>
        @foreach($lista->users as $usuarios)
            <tr>
                <td>{{$usuarios->name.' '.$usuarios->apellidos}}</td>
                <td>{{$usuarios->cargo}}</td>
                <td>
                    {{-- <div class="n-chk">
                         <label class="new-control new-radio radio-primary">
                             <input type="radio" class="new-control-input" name="votar" value="{{$usuarios->id}}">
                             <span class="new-control-indicator"></span>
                         </label>
                     </div>--}}
                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                            <input type="checkbox" name="voto_id" value="{{$usuarios->id}}" class="new-control-input">
                            <span class="new-control-indicator"></span><span class="new-chk-content"></span>
                        </label>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
</div>

<div class="row">
    <div class="col-md-12 text-left">
        <button class="btn btn-success" type="submit">Votar</button>
    </div>
</div>
    {!! Form::close() !!}

@endif
@push('scripts')
    <script>
        $("input:checkbox").on('click', function() {
            // in the handler, 'this' refers to the box clicked on
            var $box = $(this);
            if ($box.is(":checked")) {
                // the name of the box is retrieved using the .attr() method
                // as it is assumed and expected to be immutable
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                // the checked state of the group/box on the other hand will change
                // and the current value is retrieved using .prop() method
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>
@endpush
