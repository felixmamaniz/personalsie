@Include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Empledos</label>
            <select wire:model="empleadoid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($empleados as $a)
                <option value="{{$a->id}}">{{$a->name}}</option>
                @endforeach
            </select>
            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Fecha</h6>
            <input type="date" wire:model.lazy="fecha" class="form-control">
            @error('fecha')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select id="seleccion" wire:model="estado" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="Presente" selected>Presente</option>
                <option value="Falta" selected>Falta</option>
                <option value="Licencia" selected>Licencia</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
