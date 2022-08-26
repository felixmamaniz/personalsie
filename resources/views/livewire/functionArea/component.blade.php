<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" data-toggle="modal"
                    data-target="#theModal">Agregar</a>
                </ul>
            </div>

            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-bordered-bd-warning striped mt-1" >
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                               <th class="table-th text-white">NOMBRE</th>
                               <th class="table-th text-white text-center">DESCRIPCION</th>
                               <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($functionarea as $area) {{--Resive functionarea--}}
                            <tr>
                                <td><h6>{{$area->name}}</h6></td>
                                <td><h6 class="text-center">{{$area->description}}</h6></td>

                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                    wire:click="Edit({{$area->id}})"
                                    class="btn btn-dark mtmobile" title="Edit">
                                    <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                    wire:click="Destroy({{$area->id}})"
                                    class="btn btn-danger mtmobile" title="Destroy">
                                    <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$functionarea->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.functionArea.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Eventos crud
        window.livewire.on('area-added', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('area-updated', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('area-deleted', msg=>{
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

    function Confirm(id){
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
</script>
