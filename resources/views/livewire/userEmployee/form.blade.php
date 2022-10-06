@Include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Empleado</label>
            <select wire:model="empleadoid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($empleados as $empleado)
                <option value="{{$empleado->id}}">{{$empleado->name}}</option>
                @endforeach
            </select>
            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Usuario</label>
            <select wire:model="userid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($usuarios as $usuario)
                <option value="{{$usuario->id}}">{{$usuario->email}}</option>
                @endforeach
            </select>
            @error('userid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
