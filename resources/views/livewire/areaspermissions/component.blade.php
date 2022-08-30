<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                    <a href="javascript:void(0)" class="btn btn-warning" wire:click="Agregar()">Agregar</a>
                    
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe">ID</th>
                                <th class="table-th text-withe text-center">NOMBRE DEL AREA</th>                                                                                                                 
                                <th class="table-th text-withe text-center">ACCIONES</th>    
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $area)
                                <tr>
                                    <td>
                                        <h6>{{ $area->id }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ ($area->name) }}</h6>
                                    </td>                          
                                    
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $area->id }})"
                                            class="btn btn-warning mtmobile" title="Editar registro">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!--<a href="javascript:void(0)" onclick="Confirm('{/*{ $area->id }}','{/*{ $area->name }}')" 
                                            class="btn btn-warning" title="Eliminar registro">
                                            <i class="fas fa-trash"></i>
                                        </a>-->
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $area->id }}','{{ $area->name }}')" 
                                            class="btn btn-warning" title="Eliminar registro">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.areaspermissions.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('area-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-update', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('item-exists', Msg => {
            noty(Msg)
        })
        window.livewire.on('item-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('modal-hide', Msg => {
            $('#theModal').modal('hide')
        })      
              

    });

    function Confirm(id, name) {
        console.log('hola');
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el permiso ' + '"' + name + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>

