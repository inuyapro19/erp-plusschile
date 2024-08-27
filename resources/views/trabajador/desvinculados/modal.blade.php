<div class="modal fade bd-example-modal-lg" id="historial-desc-{{$modal->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Historial Desvinculaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                    <th>Fecha Desvinculación</th>
                    <th>Causal de Hecho</th>
                    <th>Motivo</th>
                    <th>Derecho</th>
                    </thead>
                    <tbody>
                    @foreach($modal->historial as $historial)
                        <tr>
                            <td>{{$historial->fecha_desvinculacion}}</td>
                            <td>{{$historial->causal_de_hecho}}</td>
                            <td>{{$historial->motivo_interno_empresa}}</td>
                            <td>{{$historial->derecho}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
