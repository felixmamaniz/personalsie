@Include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Fecha de Inicio</label>
            <input type="date" wire:model.lazy="fechaInicio" class="form-control">
        </div>
        @error('fechaInicio') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Fecha de Final</label>
            <input type="date" wire:model.lazy="fechaFin" class="form-control">
        </div>
        @error('fechaFin') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Descripcion</label>
            <input type="text" wire:model.lazy="descripcion" class="form-control">
        </div>
        @error('descripcion') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nota</label>
            <textarea type="text" class="form-control" wire:model.lazy="nota"></textarea>
        </div>
        @error('nota') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
</div>

@include('common.modalFooter')