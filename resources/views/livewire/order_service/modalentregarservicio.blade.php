<div wire:ignore.self class="modal fade" id="entregarservicio" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    Entregar Servicio - Orden de Servicio N°:{{$this->id_orden_de_servicio}}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="text-center">
                    <label>
                        <h5><b>{{strtoupper($this->nombrecliente)}}</b> - {{$this->celularcliente}}</h5>
                    </label>
                </div>



                @if(Auth::user()->hasPermissionTo('Boton_Entregar_Servicio'))

                    @if(@Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
                    <div class="row justify-content-center">

                        <div class="form-row m-0 p-0">
                            <div class="form-row text-center pr-1">
                                <div class="col-md-12">
                                    <label for="validationTooltip01">Precio del Servicio Bs</label>
                                    <input type="number" wire:model.lazy="edit_precioservicio" class="form-control">
                                </div>
                                @error('edit_precioservicio')
                                        <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-row text-center pl-1">
                                <div class="col-md-12">
                                    <label for="validationTooltip01">A Cuenta Bs</label>
                                    <input type="number" wire:model="edit_acuenta" class="form-control">
                                </div>
                            </div>
                         
                        </div>
                        @else
                        <div class="form-row">
                            <div class="form-row text-center justify-content-center" style="width: 60.33%; margin-right: 7px;">
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        
                                        <label for="validationTooltip01">Precio del Servicio Bs</label>
                                        <input type="number" disabled wire:model.lazy="edit_precioservicio" class="form-control">
                                    </div>
                                </div>
                                @error('edit_precioservicio')
                                        <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                            <div class="form-row text-center" style="width: 33.33%; margin-right: 7px;">
                                <div class="col-md-12">
                                    <label for="validationTooltip01">A Cuenta Bs</label>
                                    <input type="number" disabled wire:model="edit_acuenta" class="form-control">
                                </div>
                            </div>
                            <div class="form-row text-center" style="width: 33.33%">
                                <div class="col-md-12">
                                    <label>Monto a Cobrar Bs</label>
                                    <div class="text-center">
                                        <label for="validationTooltipUsername"> <h2>{{number_format($this->edit_saldo,2)}}</h2> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </div>




                    @if($this->estadocaja == "abierto")
                    <div class="row">
                        <div class="col-sm-6 col-md-3">

                        </div>
                        <div class="col-sm-6 col-md-6">
                                <div class="form-group text-center">
                                    <strong>Tipo de Pago</strong>
                
                                    <select wire:model="tipopago" class="form-control">
                                        <option disabled value="Elegir">Elegir</option>
                                        @foreach ($listacarteras as $cartera)
                                        <option value="{{$cartera->idcartera}}">{{ucwords(strtolower($cartera->nombrecartera)) .' - ' .ucwords(strtolower($cartera->dc))}}</option>
                                        @endforeach
                                        @foreach ($listacarterasg as $carteras)
                                        <option value="{{$carteras->idcartera}}">{{ucwords(strtolower($carteras->nombrecartera)) .' - ' .ucwords(strtolower($carteras->dc))}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                        </div>
                 
                    </div>

           

                    <div class="row justify-content-center">
                        <div class="col-lg-11">

                        <center>  <label class="m-2" > <strong>Detalle de Repuestos</strong></label></center> 
                               <div class="table-repuestos-entrega-servicio">
                                   @if ($repuestosalmacen->isNotEmpty() or $repuestostienda->isNotEmpty())
                                   <table>
                                        <thead>
                                            <tr>
                                            <th class="text-center">Nombre Producto</th>
                                            <th class="text-center">Nombre Destino</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Precio Venta</th>
                                            <th class="text-center">SubTot.</th>
                                            
                                            </tr>
                                        </thead>
                                    @endif
                                       @if ($id_servicio != null)
                                       @forelse ($repuestosalmacen as $item)
                                       
                                       <tbody>
                                        <tr wire:key="{{$item['orderM']}}">
                                            <td>
                                                {{$item['product_name']}}
                                            </td>
                                            <td>
                                                {{$item['destiny_name']}}

                                            </td>
                                            <td>
                                                {{$item['quantity']}}

                                            </td>
                                            <td>
                                                <div class="input-group"  style="min-width: 120px; max-width: 130px; align-items: center;">
                                                    <input type="number" style="max-height: 30px;" 
                                                    class="form-control" placeholder="Bs.." aria-label="Recipient's username" value="{{ $item['precioventa'] }}"
                                                    wire:change="changePrecioVenta({{$item['product_id']}},'{{$item['destiny_id']}}',$event.target.value)">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Bs</span>
                                                </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{$item['subtotal']}}
                                            </td>
                                            </tr>
                                        @empty
                                        <p>-Este servicio no cuenta con Repuestos de Almacenes</p>
                                        @endforelse
                                        @forelse ($repuestostienda as $item)
                                        
                                        <tr wire:key="{{$item['orderM']}}">
                                            <td>
                                                {{$item['product_name']}}
                                            </td>
                                            <td>
                                                {{$item['destiny_name']}}

                                            </td>
                                            <td>
                                                {{$item['quantity']}}

                                            </td>
                                            <td>
                                                <div class="input-group"  style="min-width: 120px; max-width: 130px; align-items: center;">
                                                    <input type="number" style="max-height: 30px;" 
                                                    class="form-control" placeholder="Bs.." aria-label="Recipient's username" value="{{ $item['precioventa'] }}"
                                                    wire:change="changePrecioVenta({{$item['product_id']}},'{{$item['destiny_id']}}',$event.target.value)">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Bs</span>
                                                </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{$item['subtotal']}}
                                            </td>
                                            </tr>
                                        @empty
                                        <p>-Este Servicio no cuenta con Repuestos/Productos de Tienda</p>
                                        @endforelse


                                                          
                                        @endif
                                     

                                                                           
                                   
                                     
                   
                                       </tbody>
                                   </table>
                               </div>
                        </div>
                    
                      
                    </div>
                    <div class="text-right col-lg-11">
                        <div class="row">
                         <div class="col-lg-12">
                             <div class="row justify-content-center pt-1">
                                <hr class="ml-5 p-0 pl-1" width="100%" style="background-color: #8d8181">

                             </div>

                         </div>
                    
                   
                        </div>
                     </div>

                    <div class="row justify-content-center">
                        <div class="text-right col-lg-11 mt-2 pt-2">
                           <div class="row">
                            <div class="col-lg-5">
                                <div class="row justify-content-end pt-2">
                                    <label>Monto a Cobrar Servicio</label>

                                </div>

                            </div>
                       
                            <div class="text-left col-lg-5">
                                <label for="validationTooltipUsername"> <h2>{{number_format($this->edit_saldo,2)}}</h2> </label>
                            </div>
                           </div>
                        </div>
                        <div class="text-right col-lg-11">
                           <div class="row">
                            <div class="col-lg-5">
                                <div class="row justify-content-end pt-2">
                                    <label>Producto/Repuesto</label>

                                </div>

                            </div>
                       
                            <div class="text-left col-lg-5">
                                <label for="validationTooltipUsername"> <h2>{{$sumaProductosTienda}}</h2> </label>
                            </div>
                           </div>
                        </div>
                        <div class="text-right col-lg-11">
                            <div class="row">
                             <div class="col-lg-12">
                                 <div class="row justify-content-center pt-1">
                                    <hr class="ml-3 p-0" width="100%" style="background-color: #8d8181">
 
                                 </div>
 
                             </div>
                        
                       
                            </div>
                         </div>
                      
                        <div class="text-right col-lg-11">
                           <div class="row">
                            <div class="col-lg-5">  
                                <div class="row justify-content-end pt-2">
                                    <label> <strong style="font-size: 1.10rem">Total a Cobrar</strong> </label>

                                </div>

                            </div>
                       
                            <div class="text-left col-lg-5 pt-2">
                                <label for="validationTooltipUsername"> <h2>{{$totalServicio}}</h2>  </label>
                            </div>
                           </div>
                        </div>

                        
                    
                      
                    </div>
                  
                    @else

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h2>No tiene ninguna caja abierta</h2>
                        </div>
                    </div>

                    @endif


                @else

                <center>No tiene los Permisos para Entregar Servicios</center>

                @endif

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                @if($this->estadocaja == "abierto")
                <button type="button" class="btn btn text-white" wire:click="entregarservicio()" style="background-color: rgb(22, 192, 0)">Registrar Como Entregado</button>
                @endif
            </div>
        </div>
    </div>
</div>