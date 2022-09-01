@Include('common.modalHead')
<!-- Controles de formulario -->
<div class="row">
    
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej. Juan">
        </div>
        @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Apellidos</label>
            <input type="text" wire:model.lazy="lastname" class="form-control" placeholder="ej. Perez">
        </div>
        @error('lastname') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>CI</label>
            <input type="text" wire:model.lazy="ci" class="form-control" placeholder="ej. 6869334">
        </div>
        @error('ci') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Sexo</label>
            <select wire:model="genero" class="form-control">
                <option value="Seleccionar" disabled>Elegir</option>
                <option value="Masculino" selected>Masculino</option>
                <option value="Femenino" selected>Femenino</option>
            </select>
            @error('genero') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Fecha de Nacimiento</label>
            <input type="date" wire:model.lazy="dateNac" class="form-control">
        </div>
        @error('dateNac') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Direccion</label>
            <input type="text" wire:model.lazy="address" class="form-control" placeholder="ej. Av. America">
        </div>
        @error('address') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Telefono</label>
            <input type="number" wire:model.lazy="phone" class="form-control" placeholder="ej. 44444444">
        </div>
        @error('phone') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Fecha de Admision</label>
            <input type="date" wire:model.lazy="dateAdmission" class="form-control">
        </div>
        @error('dateAdmission') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Areas</label>
            <select wire:model="areaid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($areas as $area)
                <option value="{{$area->id}}">{{$area->name}}</option>
                @endforeach
            </select>
            @error('areaid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Puesto de Trabajo</label>
            <select wire:model="puestoid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($puestos as $puesto)
                <option value="{{$puesto->id}}">{{$puesto->name}}</option>
                @endforeach
            </select>
            @error('puestoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/gif, image/jpeg">
            <label for="" class="custom-file-label">Imagen {{$image}}</label>
            @error('image') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

</div>
@include('common.modalFooter')
