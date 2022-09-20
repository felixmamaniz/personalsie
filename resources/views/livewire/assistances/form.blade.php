@include('common.modalHead')
<!-- Controles de formulario -->
<div class="row">

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
                <option value="Elegir" disabled>Elegir</option>
                <option value="Presente" selected>Presente</option>
                <option value="Falta" selected>Falta</option>
                <option value="Licencia" selected>Licencia</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Empleados</label>
            <select wire:model="empleadoid" class="form-control">
                <option value="Elegir"disabled>Elegir</option>
                @foreach($empleados as $empleado)
                    <option value="{{$empleado->id}}">{{$empleado->name}}</option>
                @endforeach
            </select>
            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    <div class="modal-body">

        <div class="table-responsive">
            <table class="table table-bordered table striped mt-1" >
                <thead class="text-white" style="background: #3b3f5c">
                    <tr>
                    <th class="table-th text-white">EMPLEADO</th> 
                    <th class="table-th text-white text-center">ACCION</th>
                    </tr>
                </thead>
                <tbody>
                    {{--@foreach ($details as $d)
                    <tr>
                        <td><h6>{{$d->id}}</h6></td>
                        <td><h6 class="text-center">{{$d->product}}</h6></td>
                        <td><h6 class="text-center">{{number_format($d->price,2)}}</h6></td>
                        <td><h6 class="text-center">{{number_format($d->quantity,0)}}</h6></td>
                        <td><h6 class="text-center">{{number_format($d->price * $d->quantity,2)}}</h6></td>

                        
                    </tr>
                    @endforeach--}}
                </tbody>
                {{--<tfoot>
                    <tr>
                        <td colspan="3"><h5 class="text-center font-weight-bold">TOTALES</h5></td>
                        <td><h5 class="text-center">{{$countDetails}}</h5></td>
                        <td><h5 class="text-center">${{number_format($sumDetails,2)}}</h5></td>
                    </tr>
                </tfoot>--}}
            </table>
        </div>

    </div>


</div>

@include('common.modalFooter')