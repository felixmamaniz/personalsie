<div wire:ignore.self class="modal fade" id="modalrecibircompra" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #02b1ce; color: white;">
          <h5 class="modal-title" id="exampleModalLongTitle">
            ORDEN DE COMPRA
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span style="color: white;" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">




          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="row">

                  <div class="col-6 col-sm-4">
                    <label><b>Monto Bs Cambio</b></label>
                    <input type="number" wire:model="monto_bs_cambio" placeholder="Dato Opcional..." class="form-control">
                    @error('monto_bs_cambio')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror

                  </div>

                  <div class="col-6 col-sm-4">
                    <label for="exampleFormControlInput1"><b>El Dinero Entrará a la Cartera</b></label>
                    <select wire:model="cartera_id" class="form-control" aria-label="Default select example">
                        <option value="Elegir">Lista de Carteras en su Caja</option>
                        @foreach($lista_carteras as $c)
                        <option value="{{$c->idcartera}}">{{ucwords(strtolower($c->nombrecartera))}}</option>
                        @endforeach
                    </select>
                    @error('cartera_id')
                      <span class="text-danger er">{{ $message }}</span>
                    @enderror

                  </div>

                  <div class="col-6 col-sm-4">
                    <label><b>Destino Producto</b></label>
                    <select wire:model.lazy="destino" class="form-control">
                      <option value='Elegir'>Elegir Destino</option>
                      @foreach($data_suc as $data)
                        <option value="{{$data->destino_id}}">{{$data->nombre}}-{{$data->name}}</option>
                      @endforeach
                  </select>
                    @error('tipo_documento')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror 
                  </div>

                </div>

                <br>

                <div class="row">

                  <div class="col-6 col-sm-4">
                    <label><b>Proveedor</b></label>

                    <input list="provider" wire:model="provider_id" class="form-control" placeholder="Ingrese Proveedor...">
                    <datalist id="provider">
                      @foreach($providers as $p)
                          <option value="{{$p->nombre_prov}}">{{$p->nombre_prov}}</option>
                      @endforeach
                    </datalist>


                    {{-- <input type="number" wire:model="monto_bs_cambio" placeholder="Dato Opcional..." class="form-control">
                    @error('monto_bs_cambio')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror --}}
                  </div>

                  <div class="col-6 col-sm-4">
                    <label><b>Nro. de Documento</b></label>
                    <input type="number" wire:model="monto_bs_cambio" placeholder="Dato Opcional..." class="form-control">
                    @error('monto_bs_cambio')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="col-6 col-sm-4">
                    <label><b>Tipo de Documento</b></label>
                    <select wire:model='tipo_documento' class="form-control">
                      <option value='FACTURA' selected>Factura</option>
                      <option value='NOTA DE VENTA'>Nota de Venta</option>
                      <option value='RECIBO'>Recibo</option>
                      <option value='NINGUNO'>Ninguno</option>
                    </select>
                    @error('tipo_documento')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror 
                  </div>

                </div>

                <br>











              </div>




            </div>

            <br>


            <div class="row">
              <div class="table-1">
                <table>
                  <thead>
                      <tr class="text-center">
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($lista_productos->sortBy("product_name") as $l)
                      <tr>
                        <td class="text-left">
                          {{$l['product_name']}}
                        </td>
                        <td class="text-center">
                        {{$l['quantity']}}
                        </td>
                        <td class="text-right">
                          {{ number_format($l['price'], 2)}}
                        </td>
                        <td class="text-right">
                          {{ number_format($l['price'] * $l['quantity'], 2)}}
                        </td>
                        <td>
                          <div class="btn-group" role="group" aria-label="Basic example">
                            {{-- <button wire:click.prevent="InsertarSolicitud({{$l['product_id']}})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(10, 137, 235); color:white">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <button wire:click.prevent="DecrementarSolicitud({{$l['product_id']}})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(255, 124, 1); color:white">
                                <i class="fas fa-chevron-down"></i>
                            </button> --}}
                            <button wire:click.prevent="EliminarItem({{$l['product_id']}})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(230, 0, 0); color:white">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>






            </div>




            @if(strlen($this->monto_bs_cambio) > 0)
              <div class="col-12 text-center">
                <div class="form-group">
                  <label>Se generará un ingreso con el siguiente detalle</label>
                  <textarea wire:model.lazy="detalleingreso" placeholder="Detalle para generar el egreso por compra de repuestos" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
              </div>
              @endif








          </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>


          @if($lista_productos->count() > 0)
          <button wire:click="finalizar_compra()" type="button" class="btn btn-primary">Recibir Compra y Entregar Productos</button>
          @endif




        </div>
      </div>
    </div>
</div>