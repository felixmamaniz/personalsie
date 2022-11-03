{{-- @Include('common.modalHead') --}}
<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="background: #414141">
                <h5 class="modal-title text-white">
                    <b>{{$componentName}}</b> | {{$selected_id > 0 ? 'EDITAR':'CREAR'}}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">


                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>Nombre</h6>
                            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ingrese funcion">
                            @error('name')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{--<div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Areas</label>
                            <select wire:model="areaid" class="form-control">
                                <option value="Elegir" disabled>Elegir</option>
                                @foreach($area_trabajos as $area)
                                <option value="{{$area->id}}">{{$area->name}}</option>
                                @endforeach
                            </select>
                            @error('areaid') <span class="text-danger er"> {{ $message }}</span> @enderror
                        </div>
                    </div>--}}

                    {{-- <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Areas</label>
                            <br>
                            <div class="btn-group">
                                <select wire:model="areaid" class="form-control col-md-12">
                                    <option value="Elegir" disabled>Elegir</option>
                                    @foreach($area_trabajos as $area)
                                        <option value="{{$area->id}}">{{$area->nameArea}}</option>
                                    @endforeach
                                </select>
                                <a type="button" wire:click="NuevArea()" class="btn btn-warning close-btn text-info">Nuevo</a>
                            </div>
                            <br>
                            @error('areaid') <span class="text-danger er"> {{ $message }}</span> @enderror
                        </div>
                        ///@error('areaid') <span class="text-danger er"> {{ $message }}</span> @enderror
                    </div> --}}

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>Descripcion</h6>
                            <input type="text" wire:model.lazy="description" class="form-control" placeholder="Ingrese descripcion">
                            @error('description')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- @include('common.modalFooter') --}}
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning"
                    data-dismiss="modal" style="background: #3b3f5c">Cancelar</button>
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="Store()"
                    class="btn btn-warning">Guardar</button>

                    {{-- <button type="button" wire:click.prevent="nuevoRegistro()"
                    class="btn btn-warning">Guardar y Cerrar</button> --}}
                @else
                    <button type="button" wire:click.prevent="Update()"
                    class="btn btn-warning">Actualizar</button>
                @endif
            </div>
        </div>
    </div>
</div>


