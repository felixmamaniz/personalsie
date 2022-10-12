@Include('common.modalHead')

<div class="row">

  

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Descripcion</label>
            <select wire:model="empleadoid" class="form-control">
                <option value="Elegir" selected>Elegir</option>
               
                    <option value="1">Falta</option>
                    <option value="2">Licencia</option>

            </select>
            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Precio</h6>
            <input type="number" wire:model.lazy="precio" class="form-control">
            {{--<label type="number" wire:model.lazy="nuevoSalario" class="form-control">10</label>--}}
            @error('precio')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
