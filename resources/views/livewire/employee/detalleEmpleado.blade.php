<div wire:ignore.self class="modal fade" id="theDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
                <h5 class="modal-title text-white">
                    <b>Detalle de Empleado</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                

                <div class="table-responsive">
                    <table class="table table-bordered border-primary">
                        
                        <tbody>
                            @foreach ($data as $d)
                                        <tr>
                                            <th>ID</th>
                                            <td>{{ $d->id }}</td>
                                        </tr>

                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $d->name }}</td>
                                        </tr>
                                    @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CERRAR
                </button>
            </div>
        </div>
    </div>
</div>