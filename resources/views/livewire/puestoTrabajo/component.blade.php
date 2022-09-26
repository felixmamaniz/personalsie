<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal" 
                    data-target="#theModal">Agregar</a>
                </ul>
            </div>
            
            @include('common.searchbox')
            
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1" >
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                               {{--<th class="table-th text-white">ID</th>--}}
                               <th class="table-th text-white">NOMBRE</th>
                               <th class="table-th text-white text-center">NRO VACANTES</th>
                               <th class="table-th text-white text-center">ESTADO</th>
                               <th class="table-th text-white text-center">ACTIONS</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($puestos as $puesto)
                            <tr>
                                {{--<td><h6>{{$puesto->idpuesto}}</h6></td>--}}
                                <td><h6>{{$puesto->name}}</h6></td>
                                <td><h6 class="text-center">{{$puesto->nrovacantes}}</h6></td>
                                
                                <td class="text-center">
                                    <span class="badge {{$puesto->estado == 'Disponible' ? 'badge-success' : 'badge-danger'}}
                                        text-uppercase">
                                        {{$puesto->estado}}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="javascript:void(0)" 
                                        wire:click="Edit({{$puesto->idpuesto}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a onclick="Confirmar1({{$puesto->idpuesto}},'{{$puesto->verificar}}')" 
                                        class="btn btn-dark mtmobile" title="Destroy">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                        wire:click="DetallePuesto('{{$puesto->idpuesto}}')"
                                        class="btn btn-dark" title="DetallePuesto">
                                        <i class="fas fa-list"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    {{$puestos->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.puestoTrabajo.form')
    @include('livewire.puestoTrabajo.detallePuesto')
</div>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show')
        });

        window.livewire.on('puesto-added', msg=>{
            $('#theModal').modal('hide')
        });

        window.livewire.on('puesto-updated', msg=>{
            $('#theModal').modal('hide')
        });

        // ver detalle de puesto
        window.livewire.on('show-modal-detalle', Msg => {
            $('#modal-details').modal('show')
        })
    });

    function Confirmar1(id, verificar)
    {
        if(verificar == 'no')
        {
            swal('no es posible eliminar porque tiene datos relacionados')
            return;
        }
        else
        {
            swal({
                title: 'CONFIRMAR',
                text: '¿CONFIRMAS ELIMINAR  EL REGISTRO',
                type: 'WARNING',
                showCancelButton: true,
                cancelButtonText: 'cerrar',
                cancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result){
                if(result.value){
                    window.livewire.emit('deleteRow',id)
                    swal.close()
                }
            })
        }
    }
</script>
<!-- Scripts para el mensaje de confirmacion arriba a la derecha Categoría Creada con Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection