@Include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Comisiones</label>
            <select wire:model="empleadoid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($empleados as $a)
                <option value="{{$a->id}}">{{$a->name}} {{$a->lastname}}</option>
                @endforeach
            </select>
            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>MULTIPLICADO</h6>
            <input type="number" wire:model.lazy="multiplicado" class="form-control">
            {{--<label type="number" wire:model.lazy="nuevoSalario" class="form-control">10</label>--}}
            @error('multiplicado')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>COMISION DEL</h6>
            <input type="number" wire:model.lazy="comisionn" class="form-control">
            @error('comisionn')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Ventas Del Mes</label>
            <input type="number" wire:model.lazy="venta_comision" class="form-control">
            @error('venta_comision')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Mes de Comision</label>
            <select wire:model="MesVenta" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
               
            </select>
            @error('prueba') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>
    

   <!-- <div class="col-sm-6 ">
        <h4>Horario Caja</h4>
        <div class="form-group">
            <label for="">Entrada</label>
            <input  type="time" wire:model="timefrom"
                class="form-control" placeholder="Click para elegir">
        </div>
        <div class="form-group">
            <label for="">Entrada</label>
            <input type="time" wire:model="timeto"
                class="form-control" placeholder="Click para elegir">
        </div>
    </div>
    -->
</div>

@include('common.modalFooter')
