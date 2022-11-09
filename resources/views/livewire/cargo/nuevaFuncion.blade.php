<div wire:ignore.self class="modal fade" id="theModal-funcion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
              <h5 class="modal-title text-white">
                  <b>{{$pageTitleFuncion}}</b> | {{$selected_id > 0 ? 'EDITAR':'CREAR'}}
              </h5>
              <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>Nombre</h6>
                            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ingrese funcion">
                            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                
                <button type="button" wire:click.prevent="NuevaFuncion()"
                    class="btn btn-warning close-btn text-info">GUARDAR</button>
                
            </div>
        </div>
    </div>
</div>