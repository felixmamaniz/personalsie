<div class="row">
    
    <div class="col-12 text-center">
        <h1>ORDENES DE COMPRA</h1>
    </div>

    
    



    <div class="col-12">
        <div class="table-1">
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
                    <tr style="background-color: rgb(162, 237, 250);" class="text-center">
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
                            <button wire:click.prevent="modalrecibircompra({{$l->codigo}})">
                                Recibir Compra
                            </button>
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


                            <table style="font-size: 12px;">
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

        //Mostrar ventana modal comprar repuesto
        window.livewire.on('modalrecibircompra-show', msg => {
            $('#modalrecibircompra').modal('show')
        });
        //Ocultar ventana modal comprar repuesto
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

