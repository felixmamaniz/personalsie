@Include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej. Ejemplo">
        </div>
        @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
</div>

@include('common.modalFooter')