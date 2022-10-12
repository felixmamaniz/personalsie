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
                    <table class="table table-bordered table-bordered-bd-warning striped mt-1" >
                        <thead class="text-white" style="background: #02b1ce">
                            <tr>
                               <th class="table-th text-white">EMPLEADO</th>
                               <th class="table-th text-white text-center">USUSRIO</th>
                               <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datos as $dat)
                            <tr>
                                <td><h6>{{$dat->name}}</h6></td>
                                <td><h6 class="text-center">{{$dat->email}}</h6></td>

                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                    wire:click="Edit({{$dat->idUserEmploy}})"
                                    class="btn btn-dark mtmobile" title="Edit">
                                    <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                        onclick="Confirm({{$dat->idUserEmploy}},'{{$dat->verificar}}')"
                                        class="btn btn-dark mtmobile" title="Destroy">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$datos->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.userEmployee.form')
</div>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Eventos crud
        window.livewire.on('usuem-added', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('usuem-updated', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('usuem-deleted', msg=>{
            // mostrar notificacion de que el producto se a eliminado
        });
        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('hidden.bs.modal', msg=>{
            $('.er').css('display','none')
        });
    });

    function Confirm(id, verificar){
        if(verificar == 'si')
        {
            swal({
                title: 'CONFIRMAR',
                text: "¿CONFIRMAS ELIMINAR  EL REGISTRO?",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar',
                padding: '2em'
            }).then(function(result){
            if (result.value){
                    window.livewire.emit('deleteRow', id)
                }
            })
        }
        else
        {
            swal('no es posible eliminar porque tiene datos relacionados')
            return;
        }
        
    }
</script>
<!-- Scripts para el mensaje de confirmacion arriba a la derecha Categoría Creada con Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection
