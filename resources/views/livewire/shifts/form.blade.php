<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Empleados</label>
                            <select wire:model="empleadoid" class="form-control">
                                <option value="Elegir" selected>Elegir</option>
                                @foreach($employees as $a)
                                    <option value="{{$a->id}}">{{$a->name}} {{$a->lastname}}</option>
                                @endforeach
                            </select>
                            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>
                <br>
                <div class="row justify-content-center">
                    <h2>Horarios</h2>
                </div>
               
                
                  
                
            </div>

              <!-- Lunes -->
              <div class="col-sm-12 bg-light p-3 border">
                    <div class="row justify-content-center" style="font-size: 20px;" >
                    
                        <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >

                            <div class="col-sm-12 col-md-6" >
                                <div class="input-group">
                                    <h3>Lunes Entrada :</h3>                            
                                        <input style="width: 50%" type="time" wire:model.lazy="horalunes" class="form-control">
                        
                                    @error('horalunes') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-5" >
                                <div class="input-group">
                                    <h3> Salida :</h3>                            
                                        <input style="width: 50%" type="time" wire:model.lazy="shoralunes" class="form-control">
                        
                                    @error('shoralunes') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>
                        

                        
                       
                        </div>
                    </div>
                </div>

                <!-- Martes -->
                <div class="col-sm-12 bg-light p-3 border">
                    <div class="row justify-content-center" style="font-size: 20px;" >
                    
                        <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >

                            <div class="col-sm-12 col-md-6" >
                                <div class="input-group">
                                    <h3>Martes Entrada :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="horamartes" class="form-control">
                        
                                    @error('horamartes') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-5" >
                                <div class="input-group">
                                    <h3> Salida :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="shoramartes" class="form-control">
                        
                                    @error('shoramartes') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                 <!-- Miercoles -->
                <div class="col-sm-12 bg-light p-3 border">
                    <div class="row justify-content-center" style="font-size: 20px;" >
                    
                        <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >

                            <div class="col-sm-12 col-md-6" >
                                <div class="input-group">
                                    <h3>Miercoles Entrada :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="horamiercoles" class="form-control">
                        
                                    @error('horamiercoles') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-5" >
                                <div class="input-group">
                                    <h3> Salida :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="shoramiercoles" class="form-control">
                        
                                    @error('shoramiercoles') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                 <!-- Jueves -->
                <div class="col-sm-12 bg-light p-3 border">
                    <div class="row justify-content-center" style="font-size: 20px;" >
                    
                        <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >

                            <div class="col-sm-12 col-md-6" >
                                <div class="input-group">
                                    <h3>Jueves Entrada :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="horajueves" class="form-control">
                        
                                    @error('horajueves') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-5" >
                                <div class="input-group">
                                    <h3> Salida :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="shorajueves" class="form-control">
                        
                                    @error('shorajueves') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                 <!-- Viernes -->
                <div class="col-sm-12 bg-light p-3 border">
                    <div class="row justify-content-center" style="font-size: 20px;" >
                    
                        <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >

                            <div class="col-sm-12 col-md-6" >
                                <div class="input-group">
                                    <h3>Viernes Entrada :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="horaviernes" class="form-control">
                        
                                    @error('horaviernes') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-5" >
                                <div class="input-group">
                                    <h3> Salida :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="shoraviernes" class="form-control">
                        
                                    @error('shoraviernes') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                 <!-- Sabado -->
                <div class="col-sm-12 bg-light p-3 border">
                    <div class="row justify-content-center" style="font-size: 20px;" >
                    
                        <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >

                            <div class="col-sm-12 col-md-6" >
                                <div class="input-group">
                                    <h3>Sabado Entrada :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="horasabado" class="form-control">
                        
                                    @error('horasabado') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-5" >
                                <div class="input-group">
                                    <h3> Salida :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="shorasabado" class="form-control">
                        
                                    @error('shorasabado') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                 <!-- Domingo -->
                <div class="col-sm-12 bg-light p-3 border">
                    <div class="row justify-content-center" style="font-size: 20px;" >
                    
                        <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >

                            <div class="col-sm-12 col-md-6" >
                                <div class="input-group">
                                    <h3>Domingo Entrada :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="horadomingo" class="form-control">
                        
                                    @error('horadomingo') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-5" >
                                <div class="input-group">
                                    <h3> Salida :</h3>                            
                                        <input style="width: 30%" type="time" wire:model.lazy="shoradomingo" class="form-control">
                        
                                    @error('shoradomingo') <span class="text-danger er"> {{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
                        data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                    @if ($selected_id < 1)
                        <button type="button" wire:click.prevent="CreateRole()"
                            class="btn btn-warning close-btn text-info">GUARDAR</button>
                    @else
                        <button type="button" wire:click.prevent="UpdateRole()"
                            class="btn btn-warning close-btn text-info">ACTUALIZAR</button>
                    @endif
    
                </div>
            </div>

            

            
        </div>
    </div>
</div>

<script>
    const horaentrada = document.getElementById('horae');
    const horasalida = document.getElementById('horas');
    function horasDay() {

        let horaNum=24;
        for (let i = 0; i <= horaNum; i++) {
            const option = document.createElement("option");
            option.textContent = i;
            horaentrada.appendChild(option);
        }
    }

    function horasDays() {

        let horaNum=24;
        for (let i = 0; i <= horaNum; i++) {
            const option = document.createElement("option");
            option.textContent = i;
            horasalida.appendChild(option);
            
        }
    }

    horasDay();
    horasDays();

    horaentrada.onchange = function(){
        horasDay()
    }
</script>
