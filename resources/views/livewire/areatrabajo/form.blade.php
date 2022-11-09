@Include('common.modalHead')

<div class="row">

    {{-- <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Cargo</label>
            <select wire:model="cargoid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($cargos as $cargo)
                    <option value="{{$cargo->id}}">{{$cargo->name}}</option>
                @endforeach
            </select>
            @error('cargoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div> --}}

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Area de  Trabajo</h6>
            <input type="text" wire:model.lazy="nameArea" class="form-control" placeholder="Ingrese nombre">
            @error('nameArea')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Descripcion</h6>
            <input type="text" wire:model.lazy="descriptionArea" class="form-control" placeholder="Ingrese descripcion">
            @error('descriptionArea')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
