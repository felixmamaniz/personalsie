<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #ee761c">
          <h5 class="modal-title text-white">
              <b>{{$componentName}}</b> 
          </h5>
          <div class="col-sm-12 col-md-6">
        
        
    </div>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body">

<div class="row">


    <div class="col-sm-12 col-md-6">
        
            
            <div class="form-group">
                <label>Fecha Feridado, festivo o fallo de sistema</label>
                <div></div>
                <input type="date" wire:model="fecha"
                    class="form-control" placeholder="Click para elegir">

                    @error('prueba') <span class="text-danger er"> {{ $message }}</span> @enderror
            </div>
        
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>DESCRIPCION</h6>
            <textarea type="text" wire:model.lazy="descripcion" class="form-control"></textarea>
            @error('descripcion')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

  

</div>

</div>
<div class="modal-footer">
    <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
        data-dismiss="modal" style="background: #ee761c">CANCELAR</button>
        <button type="button" wire:click.prevent="fallo()"
            class="btn btn-warning close-btn text-info">GUARDAR</button>
</div>
</div>

</div>
</div>


