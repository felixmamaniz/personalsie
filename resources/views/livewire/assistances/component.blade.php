<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    {{--<a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal" 
                    data-target="#theModal">Agregar</a>--}}
                </ul>
            </div>
            
            @include('common.searchbox')
            
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1" >
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                               <th class="table-th text-white">EMPLEADO</th>
                               <th class="table-th text-white text-center">FECHA</th>
                               <th class="table-th text-white text-center">ESTADO</th>
                               <th class="table-th text-white text-center">ACTIONS</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asitencia)
                            <tr>
                                <td><h6>{{$asitencia->empleado}}</h6></td>
                                <td><h6 class=" text-center">{{$asitencia->fecha}}</h6></td>
                                <td class="text-center">
                                    <span class="badge {{$asitencia->estado == 'Presente' ? 'badge-success' : 'badge-danger'}}
                                        text-uppercase">
                                        {{$asitencia->estado}}
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <a href="javascript:void(0)" 
                                        wire:click="Edit({{$asitencia->idAsist}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a onclick="Confirmar1({{$asitencia->idAsist}},'{{$asitencia->verificar}}')" 
                                        class="btn btn-dark mtmobile" title="Destroy">
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

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function(){

            window.livewire.on('show-modal', msg=>{
                $('#theModal').modal('show')
            });

            window.livewire.on('asist-added', msg=>{
                $('#theModal').modal('hide')
            });

            window.livewire.on('asist-updated', msg=>{
                $('#theModal').modal('hide')
            });
        });

        function Confirmar1(id, verificar)
        {
            if(verificar == 'si')
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
            }else
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