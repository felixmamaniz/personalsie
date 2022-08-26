<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}}</b>
                </h4>
            </div>
            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model="area" class="form-control">
                            <option value="Elegir" selected disabled><<-- Selecciona un Area -->></option>
                            @foreach ($areas as $area)
                            <option value="{{$area->id}}">{{$area->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button wire:click.prevent="SyncALL()" type="button" 
                    class="btn btn-warning mbmobile inblock mr-5">Sincronizar Todos</button>

                    <button onclick="Revocar()" type="button" 
                    class="btn btn-warning mbmobile mr-5">Revocar Todos</button>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table striped mt-1" >
                                <thead class="text-white" style="background: #ee761c">
                                    <tr>
                                       <th class="table-th text-white text-center">ID</th> 
                                       <th class="table-th text-white text-center">FUNCION</th> 
                                       <th class="table-th text-white text-center">AREA CON LA FUNCION</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($funciones as $funcion)
                                    <tr>
                                        <td><h6 class="text-center">{{$funcion->id}}</h6></td>
                                        <td class="text-center">
                                            <div class="n-check">
                                                <label class="new-control new-checkbox checkbox-primary">
                                                    <input type="checkbox"
                                                    wire:change="syncPermiso($('#p' + {{$funcion->id}}).is(':checked'),
                                                     '{{$funcion->name}}' )"
                                                    id="p{{$funcion->id}}"
                                                    value="{{$funcion->id}}"
                                                    class="new-control-input"
                                                    {{$funcion->checked == 1 ? 'checked' : '' }}
                                                    >
                                                    <span class="new-control-indicator"></span>
                                                    <h6>{{$funcion->name}}</h6>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                         <h6>espacio para verificar</h6>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$funciones->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('sync-error', msg=>{
            noty(msg)
        });

        window.livewire.on('permi', msg=>{
            noty(msg)
        });

        window.livewire.on('syncall', msg=>{
            noty(msg)
        });

        window.livewire.on('removeall', msg=>{
            noty(msg)
        });
    });

    function Revocar(){
        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS REVOCAR TODO LOS PERMISOS',
            type: 'WARNING',
            showCancelButton: true,
            cancelButtonText: 'cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        }).then(function(result){
            if(result.value){
                window.livewire.emit('revokeall')
                swal.close()
            }
        })
    }
</script>
