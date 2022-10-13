<div wire:ignore.self class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #02b1ce; color: white;">
          <h5 class="modal-title" id="exampleModalLongTitle">
            EDITAR ORDEN DE COMPRA
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span style="color: white;" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-6 col-sm-4">

              <label for="exampleFormControlInput1"><b>Será Comprado Por:</b></label>
              <select wire:model="editar_usuario_comprador_id" class="form-control" aria-label="Default select example">
                <option value="Elegir">Seleccione Usuario</option>
                @foreach($lista_usuarios as $u)
                <option value="{{$u->id}}">{{ucwords(strtolower($u->name))}}</option>
                @endforeach
              </select>
              @error('usuario_id')
              <span class="text-danger er">{{ $message }}</span>
              @enderror

            </div>
            <div class="col-6 col-sm-4">
              <label for="exampleFormControlTextarea1"><b>Monto Bs Compra</b></label>
                <input type="number" wire:model="editar_monto_bs_compra" placeholder="Ingrese Bs para la Compra..." class="form-control">
                @error('monto_bs_compra')
                <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6 col-sm-4">
              <label for="exampleFormControlInput1"><b>Cartera</b></label>
                    <select wire:model="editar_cartera_id" class="form-control" aria-label="Default select example">
                        <option value="Elegir">Lista de Carteras en su Caja</option>
                        @foreach($lista_carteras as $c)
                        <option value="{{$c->idcartera}}">{{ucwords(strtolower($c->nombrecartera))}}</option>
                        @endforeach
                        @foreach($lista_cartera_general as $g)
                        <option value="{{$g->idcartera}}">{{ucwords(strtolower($g->nombrecartera))}}</option>
                        @endforeach
                    </select>
                    @error('cartera_id')
                      <span class="text-danger er">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-12 text-center">
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Detalle del Egreso</label>
                <textarea wire:model.lazy="editar_detalleegreso" placeholder="Detalle para generar el egreso por compra de repuestos" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
            </div>

          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button wire:click.prevent="actualizarordencompra()" type="button" class="btn btn-primary">Actualizar Información</button>
        </div>
      </div>
    </div>
</div>