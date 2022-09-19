<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" 
                        data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>

            @Include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1" >
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                               <th class="table-th text-white">EMPLEADO</th> 
                               <th class="table-th text-white text-center">FECHA</th> 
                               <th class="table-th text-white text-center">ESTADO</th>
                               <th class="table-th text-white text-center">ACTIONS</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asistencias as $asitencia)
                            <tr>
                                <td><h6>{{$asitencia->empleado_id}}</h6></td>
                                <td class="text-center"><h6>{{$asitencia->fecha}}</h6></td>
                                <td class="text-center">
                                    <span class="badge {{$asitencia->estado == 'Presente' ? 'badge-success' : 'badge-danger'}}
                                        text-uppercase">
                                        {{$asitencia->estado}}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                        wire:click="edit({{$estado->id}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                        onclick="Confirm('{{$estado->id}}')"
                                        class="btn btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    {{$asistencias->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.assistances.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('asist-added', Msg => {
           $('#theModal').modal('hide')
           noty(Msg)
        })

        window.livewire.on('asist-updated', Msg => {
           $('#theModal').modal('hide')
           noty(Msg)
        })

        window.livewire.on('asist-deleted', Msg => {
           noty(Msg)
        })

        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })

        window.livewire.on('show-modal', Msg => {
           $('#theModal').modal('show')
        })

        window.livewire.on('asist-withsales', Msg => {
           noty(Msg)
        })
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