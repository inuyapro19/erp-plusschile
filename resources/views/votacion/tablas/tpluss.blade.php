@if($tpluss->count()>0)
    <form action="">
        <h1>TPLUSS</h1>
        <table class="table table-hover table-striped">
            <thead>
            <td>#</td>
            <td>Nombre</td>
            <td>Votación</td>
            </thead>
            <tbody>

            @foreach($tpluss as $usuarios)
                <tr>
                    <td>#</td>
                    <td>{{$usuarios->name.' '.$usuarios->apellidos}}</td>
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
