<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
           

                {{-- DATOS DE EMPLEADO --}}
                <div class="card" style="background: #e6e6e9">
                    <div class="card-body">
                        
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
                                        <label>Area de Trabajo</label>
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

                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label>Estado Civil</label>
                                        <select wire:model="estadoCivil" class="form-control">
                                            <option value="Seleccionar" disabled>Elegir</option>
                                            <option value="Soltero" selected>Soltero</option>
                                            <option value="Casado" selected>Casado</option>
                                        </select>
                                        @error('genero') <span class="text-danger er">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label>Contrato</label>
                                        <br>
                                        <div class="p-2 bd-highligh">
                                            <button type="button" wire:click="NuevoContrato()" class="btn btn-warning close-btn text-info">Nuevo Contrato</button>
                                        </div>
                                        <select wire:model="contratoid" class="form-control">
                                            <option value="Elegir" disabled>Elegir</option>
                                            @foreach($contratos as $contrato)
                                                <option value="{{$contrato->id}}">{{$contrato->descripcion}}</option>
                                            @endforeach
                                        </select>
                                        @error('contratoid') <span class="text-danger er"> {{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label>Fecha de Inicio</label>
                                        <input type="date" wire:model.lazy="fechaInicio" class="form-control">
                                    </div>
                                    @error('fechaInicio') <span class="text-danger er">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <div class="form-group custom-file">
                                        <input type="file" class="custom-file-input form-control img-thumbnail center-block" wire:model="image" accept="image/x-png, image/gif, image/jpeg">
                                        <label for="" class="custom-file-label">Imagen {{$image}}</label>
                                        <h6 style="color: red">Seleccione una Imagen con un peso menos de 2Mb</h6>
                                        @error('image') <span class="text-danger er"> {{ $message }}</span> @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    
                    


                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
                            data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                        @if ($selected_id < 1)
                            <button type="button" wire:click.prevent="Store()"
                                class="btn btn-warning close-btn text-info">GUARDAR</button>
                        @else
                            <button type="button" wire:click.prevent="Update()"
                                class="btn btn-warning close-btn text-info">ACTUALIZAR</button>
                        @endif
                </div>

</div>
</div>
</div>
</div>

