<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                    data-target="#theModal">Agregar</a>
                </ul>

                {{--<div class="container mt-5">
                    <h3>Importar Datos</h3>
             
                    @if ( $errors->any() )
             
                        <div class="alert alert-danger">
                            @foreach( $errors->all() as $error )<li>{{ $error }}</li>@endforeach
                        </div>
                    @endif
             
                    @if(isset($numRows))
                        <div class="alert alert-sucess">
                            Se importaron {{$numRows}} registros.
                        </div>
                    @endif
             
                    <form action="{{route('tipo_contratos.import')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-3">
                                <div class="custom-file">
                                    <input type="file" name="alumnos" class="custom-file-input" id="alumnos">
                                    <label class="custom-file-label" for="alumnos">Seleccionar archivo</label>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Importar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>--}}

            </div>
            
            @include('common.searchbox')
            
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1" >
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                               <th class="table-th text-white">NOMBRE</th> 
                               <th class="table-th text-white text-center">IMAGEN</th> 
                               <th class="table-th text-white text-center">ACTIONS</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipos as $tipo)
                            <tr>
                                <td><h6>{{$tipo->name}}</h6></td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{asset('storage/tipoContrato/' .$tipo->image)}}"
                                         alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                    </span>
                                </td>
                                <td class="text-center">
                                        <a href="javascript:void(0)" 
                                        wire:click="Edit({{$tipo->id}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                            class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                            </path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>

                                        <a href="javascript:void(0)"
                                        wire:click="Delete({{$tipo->id}})"
                                        class="btn btn-dark" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                            class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    {{$tipos->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.tipoContrato.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
    
        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show')
        });

        window.livewire.on('tipocont-added', msg=>{
            $('#theModal').modal('hide')
        });

        window.livewire.on('tipocont-updated', msg=>{
            $('#theModal').modal('hide')
        });
    });

    function Confirm(id){
        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR  EL REGISTRO',
            type: 'WARNING',
            showCancelButton: true,
            cancelButtonText: 'cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        }).then(function(result){
            if(result.value){
                window.livewire.emit('deleteRow',id)
                swal.close()
            }
        })
    }

</script>