@section('css')
<style>
            /*Estilos para el Boton Pendiente en la Tabla*/
        .recibir {
        text-decoration: none !important; 
        background-color: #4894ef;
        cursor: pointer;
        color: white;
        border-color: #4894ef;
        border-radius: 5px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 2px;
        padding-right: 2px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: #4894ef;
        display: inline-block;
    }
    .recibir:hover {
        background-color: rgb(255, 255, 255);
        color: #4894ef;
        transition: all 0.4s ease-out;
        border-color: #4894ef;
        text-decoration: underline;
        -webkit-transform: scale(1.05);
        -moz-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
        
    }
</style>
@endsection

<div class="row">
    
    <div class="col-4 text-center">
        
    </div>
    <div class="col-4 text-center">
        <h1>Ordenes de Compra</h1>
    </div>
    <div class="col-4 text-right">
        <div class="form-group">
            <a href="{{ url('solicitudrepuestos') }}" type="button" class="btn btn-success">Ir a Solicitud de Repuestos</a>
        </div>
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
                        <th>COMPRADOR / MONTO BS / CARTERA</th>
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
                            <b>{{$l->nombrecomprador}} / {{$l->monto_bs_compra}} Bs / {{$l->nombrecartera}}</b>
                        </td>
                        <td>
                           <b>{{ \Carbon\Carbon::parse($l->created_at)->format('d/m/Y H:i') }}</b>
                        </td>
                        <td class="text-center">
                            @if($l->estado != "COMPRADO")

                            <button class="recibir" wire:click.prevent="modalrecibircompra({{$l->codigo}})" title="Recibir Orden de Compra">
                                Recibir Compra
                            </button>
                            <button wire:click.prevent="modaleditar({{$l->codigo}})" class="recibir" title="Editar Orden de Compra">
                                <i class="far fa-edit"></i>
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
                                                @if($d->status == "INACTIVO")
                                                <span class="stamp stamp" style="background-color: crimson">
                                                    NO COMPRADO
                                                </span>

                                                @endif
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
    @include('livewire.ordencompra.modaleditar')
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

        //Mostrar ventana modal recibircompra
        window.livewire.on('modaleditar-show', msg => {
            $('#modaleditar').modal('show')
        });

        //Ocultar ventana modal editar orden de compra
        window.livewire.on('modaleditar-hide', msg => {
            $('#modaleditar').modal('hide')
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.message,
                padding: '2em',
            })
        });

    });

</script>

<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->

@endsection

