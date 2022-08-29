@Include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <h6>Nombre</h6>
            <input type="text" wire:model.lazy="name" class="form-control">
            @error('name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <h6>Descripcion</h6>
            <input type="text" wire:model.lazy="description" class="form-control">
            @error('description')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
