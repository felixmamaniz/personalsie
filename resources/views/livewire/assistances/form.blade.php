@include('common.modalHead')
<!-- Controles de formulario -->
<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Empleados</label>
            <select wire:model="empleadoid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($employees as $employ)
                <option value="{{$employ->id}}">{{$employ->name}}</option>
                @endforeach
            </select>
            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" wire:model.lazy="fecha"
                class="form-control">
            @error('fecha') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select wire:model.lazy="estado" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                <option value="Presente" selected>Presente</option>
                <option value="Falta" selected>Falta</option>
                <option value="Licencia" selected>Licencia</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')