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
                        <thead class="text-white" style="background: #02b1ce">
                            <tr>
                               {{-- <th class="table-th text-white">ID</th> --}}
                               <th class="table-th text-white">CARGO</th>
                               <th class="table-th text-white text-center">AREA</th>
                               <th class="table-th text-white text-center">FUNCIONES</th>
                               <th class="table-th text-white text-center">ESTADO</th>
                               <th class="table-th text-white text-center">ACTIONS</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cargos as $cargo)
                            <tr>
                                {{-- <td><h6>{{$cargo->idcargo}}</h6></td> --}}
                                <td><h6>{{$cargo->name}}</h6></td>
                                <td><h6 class="text-center">{{$cargo->area}}</h6></td>

                                <td><h6 class="text-center">
                                    <a href="javascript:void(0)"
                                        wire:click="NuevaVFuncion()" 
                                        class="btn btn-warning close-btn text-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </h6></td>

                                <td class="text-center">
                                    <span class="badge {{$cargo->estado == 'Disponible' ? 'badge-success' : 'badge-danger'}}
                                        text-uppercase">
                                        {{$cargo->estado}}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="javascript:void(0)" 
                                        wire:click="Edit({{$cargo->idcargo}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                        wire:click="NuevoFuncion()" 
                                        class="btn btn-warning close-btn text-info">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>

                                    <a onclick="Confirmar1({{$cargo->idcargo}},'{{$cargo->verificar}}')" 
                                        class="btn btn-dark mtmobile" title="Destroy">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    {{$cargos->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cargo.form')
    @include('livewire.cargo.nuevaFuncion')
    @include('livewire.cargo.VistaFunciones')
</div>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show')
        });

        window.livewire.on('cargo-added', msg=>{
            $('#theModal').modal('hide')
        });

        window.livewire.on('cargo-updated', msg=>{
            $('#theModal').modal('hide')
        });

        // Fomrmulario de nueva funcion
        window.livewire.on('show-modal-funcion', Msg => {
            $('#theModal-funcion').modal('show')
        })
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('modal-hide-funcion', Msg => {
            $('#theModal-funcion').modal('hide')
        })
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display','none')
        });

        // Formulario Vista de Funciones
        window.livewire.on('show-modal-Vfuncion', Msg => {
            $('#theModal-Vfuncion').modal('show')
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
    }
</script>
<!-- Scripts para el mensaje de confirmacion arriba a la derecha Categoría Creada con Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection