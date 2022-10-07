<div class="row">
    
    <div class="col-12 text-center">
        <h1>Ordenes de Compra</h1>
    </div>




    <div class="col-12 col-sm-6 col-md-3 text-center">
        <b>Buscar...</b>
        <div class="form-group">
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text input-gp">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <input type="text" wire:model="search" placeholder="Buscar por Código..." class="form-control">
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3 text-center">
        <b>Sucursal</b>
        <div class="form-group">
            <select wire:model="sucursal_id" class="form-control">
                @foreach($listasucursales as $sucursal)
                <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                @endforeach
                <option value="Todos">Todas las Sucursales</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 text-center">
        <b style="color: white;">|</b>
        <div class="form-group">
            <a href="{{ url('solicitudrepuestos') }}" type="button" class="btn btn-success">Ir a Solicitud de Repuestos</a>
        </div>
    </div>

    
    



    <div class="col-12">
        <div class="table-null">
            <table>
                <thead class="text-center" style="background: #02b1ce; color: white;">
                    <tr class="text-center">
                        <th>No</th>
                        <th>CODIGO</th>
                        {{-- <th>ORDEN DE COMPRA</th> --}}
                        <th>USUARIO</th>
                        <th>COMPRADOR ASIGNADO</th>
                        <th>FECHA</th>
                        <th>ACCION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lista_ordenes as $l)
                    <tr class="fila text-center">
                        <td>
                            <B>{{$loop->iteration}}</B>
                        </td>
                        <td>
                            <span class="stamp stamp" style="background-color: #02b1ce">
                                {{$l->codigo}}
                            </span>
                        </td>
                        <td>
                            <b>{{$l->nombreusuario}}</b>
                        </td>
                        <td>
                            <b>{{$l->nombrecomprador}}</b>
                        </td>
                        <td>
                           <b>{{ \Carbon\Carbon::parse($l->created_at)->format('d/m/Y H:i') }}</b>
                        </td>
                        <td class="text-center">
                            @if($l->estado != "COMPRADO")

                            <button wire:click.prevent="modalrecibircompra({{$l->codigo}})">
                                Recibir Compra
                            </button>

                            @else

                            Compra Finalizada

                            @endif
                        </td>
                        
                    </tr>

                    <tr>
                        <td>

                        </td>
                        <td class="text-center">
                            
                        </td>
                        <td class="text-center">
                            
                        </td>
                        <td>


                            <table style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <b>NOMBRE PRODUCTO</b>
                                        </th>
                                        <th class="text-center">
                                            <b>CANTIDAD</b>
                                        </th>
                                        <th class="text-center">
                                            <b>COSTO</b>
                                        </th>
                                        <th class="text-center">
                                            <b>TOTAL</b>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($l->detalles as $d)
                                        <tr>
                                            <td>
                                                {{$d->nombreproducto}}
                                            </td>
                                            <td class="text-center">
                                                {{$d->cantidad}}
                                            </td>
                                            <td class="text-center">
                                                {{$d->costoproducto}}
                                            </td>
                                            <td class="text-center">
                                                {{$d->costoproducto * $d->cantidad}} Bs
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>


                        </td>
                        <td>

                        </td>
                        <td class="text-center">
                            
                        </td>
                    </tr>



                    
                    @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
    
    



    @include('livewire.ordencompra.modalrecibircompra')
</div>
@section('javascript')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        //Mostrar ventana modal recibircompra
        window.livewire.on('modalrecibircompra-show', msg => {
            $('#modalrecibircompra').modal('show')
        });
        //Ocultar ventana modal recibir compra
        window.livewire.on('modalrecibircompra-hide', msg => {
            $('#modalrecibircompra').modal('hide')
            swal(
            '¡Compra Recibida!',
            @this.message,
            'success'
            )
        });


        //Mostrar cualquier tipo de Mensaje Ventana de Ok
        // window.livewire.on('mensaje-ok', event => {
        //         swal(
        //             '¡Solicitud Aceptada!',
        //             @this.message,
        //             'success'
        //             )
        //     });


    });


    // Código para lanzar la Alerta de Cambiar el estado de una solicitud
    // function ConfirmarCambiar(iddetalle, codigo) {
    // swal({
    //     title: '¿Aceptar la Solicitud?',
    //     text: "Se registrará la solicitud como aceptada",
    //     type: 'warning',
    //     showCancelButton: true,
    //     cancelButtonText: 'Cancelar',
    //     confirmButtonText: 'Aceptar',
    //     padding: '2em'
    //     }).then(function(result) {
    //     if (result.value) {
    //         window.livewire.emit('aceptarsolicitud', iddetalle, codigo)
    //         }
    //     })
    // }

</script>

<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->

@endsection

