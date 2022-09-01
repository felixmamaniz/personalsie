<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Detalle de Venta # {{$employeeId}}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1" >
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th class="table-th text-white">NOMBRE</th> 
                                <th class="table-th text-white text-center">APELLIDOS</th> 
                                <th class="table-th text-white text-center">CI</th> 
                                <th class="table-th text-white text-center">SEXO</th> 
                                <th class="table-th text-white text-center">FECHA DE NAC</th> 
                                <th class="table-th text-white text-center">DIRECCION</th> 
                                <th class="table-th text-white text-center">TELEFONO</th>
                                <th class="table-th text-white text-center">FECHA DE ADMISION</th>
                                <th class="table-th text-white text-center">TIEMPO TRANSCURRIDO</th>
                                <th class="table-th text-white text-center">AREA</th>
                                <th class="table-th text-white text-center">PUESTO</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td><h6>{{$d->name}}</h6></td>
                                <td><h6 class="text-center">{{$d->lastname}}</h6></td>
                                <td><h6 class="text-center">{{$d->ci}}</h6></td>
                                <td><h6 class="text-center">{{$d->genero}}</h6></td>
                                <td><h6 class="text-center">{{$d->dateNac}}</h6></td>
                                <td><h6 class="text-center">{{$d->address}}</h6></td>
                                <td><h6 class="text-center">{{$d->phone}}</h6></td>
                                <td><h6 class="text-center">{{$d->dateAdmission}}</h6></td>
                                <td><h6 class="text-center">{{$d->area}}</h6></td>
                                <td><h6 class="text-center">{{$d->puesto}}</h6></td>
                                <td><h6 class="text-center">{{$d->image}}</h6></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-btn text-info" 
                data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>