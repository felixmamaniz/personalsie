@Include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ingrese nombre de Cargo">
            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Areas</label>
            <select wire:model="areaid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($areas as $area)
                    <option value="{{$area->id}}">{{$area->nameArea}}</option>
                @endforeach
            </select>
            @error('areaid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    @if ($selected_id > 1)
        <div class="col-sm-12 col-md-5">
            <div class="form-group">
                <label>Estado de Cargo</label>
                <select id="seleccion" wire:model="estado" class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    <option value="Disponible" selected>Disponible</option>
                    <option value="No Disponible" selected>No Disponible</option>
                </select>
                @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
            </div>
        </div>
    @endif
</div>

@include('common.modalFooter')