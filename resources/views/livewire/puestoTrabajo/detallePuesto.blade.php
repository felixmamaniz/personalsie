<div wire:ignore.self class="modal fade" id="modal-details" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Detalle del puesto</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1" >
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-white">NOMBRE DE EMPLEADO</th>
                                <th class="table-th text-white">ESTADO</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><h6>{{$name}}</h6></td>
                                <td><h6>{{$estado}}</h6></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning close-btn text-info" 
                data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>