@section('css')
<style>
    .tablaservicios {
        width: 100%;
        min-width: 1100px;
        min-height: 140px;
    }
    .tablaservicios thead {
        background-color: #1572e8;
        color: white;
    }
    .tablaservicios th, td {
        border: 0.5px solid #1571e894;
        padding-top: 3px;
        padding-bottom: 3px;
        padding-left: 3px;
        padding-right: 4px;
    }
    .tablaserviciostr:hover {
        background-color: rgba(0, 195, 255, 0.336);
    }
    .detalleservicios{
        border: 1px solid #1572e8;
        border-radius: 10px;
        background-color: #ffffff00;
        /* border-top: 4px; */
        padding: 5px;
    }

    
    /*Estilos para el Boton Pendiente en la Tabla*/
    .pendienteestilos {
        text-decoration: none !important; 
        background-color: rgb(161, 0, 224);
        color: white;
        border-color: rgb(161, 0, 224);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(161, 0, 224);
        display: inline-block;
    }

    /*Estilos para el Boton Proceso en la Tabla*/
    .procesoestilos {
        text-decoration: none !important; 
        background-color: rgb(100, 100, 100);
        color: white; 
        border-color: rgb(100, 100, 100);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 12px;
        padding-right: 12px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(100, 100, 100);
        display: inline-block;
    }

    /*Estilos para el Boton Terminado en la Tabla*/
    .terminadoestilos {
        text-decoration: none !important; 
        background-color: rgb(224, 146, 0);
        color: white;
        border-color: rgb(224, 146, 0);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(224, 146, 0);
        display: inline-block;
    }

    /*Estilos para el Boton Entregado en la Tabla*/
    .entregadoestilos {
        text-decoration: none !important; 
        background-color: rgb(22, 192, 0);
        color: white !important; 
        cursor: default;
        border:none;
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(22, 192, 0);
        display: inline-block;
    }


    /* Estilos para la Tabla - Ventana Modal Asignar Técnico  Responsable*/
    .table-wrapper {
        width: 100%;/* Anchura de ejemplo */
        height: 350px; /* Altura de ejemplo */
        overflow: auto;
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
    }
        


    #preloader_3{
    position:relative;
}
#preloader_3:before{
    width:20px;
    height:20px;
    border-radius:20px;
    background:blue;
    content:'';
    position:absolute;
    background:#9b59b6;
    animation: preloader_3_before 1.5s infinite ease-in-out;
}
 
#preloader_3:after{
    width:20px;
    height:20px;
    border-radius:20px;
    background:blue;
    content:'';
    position:absolute;
    background:#2ecc71;
    left:22px;
    animation: preloader_3_after 1.5s infinite ease-in-out;
}
 
@keyframes preloader_3_before {
    0% {transform: translateX(0px) rotate(0deg)}
    50% {transform: translateX(50px) scale(1.2) rotate(260deg); background:#2ecc71;border-radius:0px;}
      100% {transform: translateX(0px) rotate(0deg)}
}
@keyframes preloader_3_after {
    0% {transform: translateX(0px)}
    50% {transform: translateX(-50px) scale(1.2) rotate(-260deg);background:#9b59b6;border-radius:0px;}
    100% {transform: translateX(0px)}
}


</style>
@endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center" style="font-size: 110%"><b>Reporte Repuestos</b></h4>
            </div>

            <div class="widget-content">
{{-- PENDIENTE --}}
{{-- 
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <h6>Elige Usuario</h6>
                        <div class="form-group">
                            <select wire:model="userId" class="form-control">
                                <option value="">Todos</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <h6>Elige Estado</h6>
                        <div class="form-group">
                            <select wire:model="estado" class="form-control">
                                <option value="Todos">Todos</option>
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="PROCESO">Proceso</option>
                                <option value="TERMINADO">Terminado</option>
                                <option value="ENTREGADO">Entregado</option>
                                <option value="ABANDONADO">Abandonado</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <h6>Sucursal</h6>
                        <div class="form-group">
                            <select wire:model="sucursal" class="form-control">
                                <option value="0">Todos</option>
                                @foreach ($sucursales as $suc)
                                    <option value="{{ $suc->id }}">{{ $suc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <h6>Tipo de Reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control">
                                <option value="0">Servicios del día</option>
                                <option value="1">Servicios por fecha</option>
                                <option value="2">Repuestos por servicio</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-1 text-center">
                        <h6>Fecha Desde</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom"
                                class="form-control" placeholder="Click para elegir">
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-1 text-center">
                        <h6>Fecha Hasta</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                class="form-control" placeholder="Click para elegir">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <a class="btn btn-primary {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteServicio/pdf' . '/' . $userId . '/' . $estado . '/' . $sucursal . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                            target="_blank" style='font-size:15px'>Generar PDF</a>
                    </div>

                </div> --}}

                {{-- <div class="row">
                    <div class="col-12 col-sm-6 col-md-10 text-center"></div>
                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <a class="btn btn-primary {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteServicio/pdf' . '/' . $userId . '/' . $estado . '/' . $sucursal . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                            target="_blank" style='font-size:15px'>Generar PDF</a>
                    </div>
                </div> --}}

                {{-- <div class="row">
                    <div class="col-lg-3">
                        <label>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">TÉCNICO: {{ $tecnico }}</h6>
                        </label><br />
                    </div>
                    <div class="col-lg-3">
                        <label>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">ESTADO: {{ $estadovista }}</h6>
                        </label><br />
                    </div>
                    <div class="col-lg-3">
                        <label>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">FECHA DESDE:
                                {{ \Carbon\Carbon::parse($fechadesde)->format('d/m/Y') }}</h6>
                        </label><br />
                    </div>
                    <div class="col-lg-3">
                        <label>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">FECHA HASTA:
                                {{ \Carbon\Carbon::parse($fechahasta)->format('d/m/Y') }}</h6>
                        </label><br />
                    </div>
                </div> --}}
{{--FIN PENDIENTE --}}
                {{-- <center><div id="preloader_3" wire:loading></div></center>
                <br> --}}

                <div class="">
                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="tablaservicios">
                                <thead>
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">ORD. SERVICIO</th>
                                        <th class="table-th text-withe text-center">CLIENTE</th>
                                        <th class="table-th text-withe text-center">DETALLE REPUESTOS</th>
                                        <th class="table-th text-withe text-center">TOTAL IMPORTE</th>                             
                                        <th class="table-th text-withe text-center">TEC. SOL.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                        <tr class="tablaserviciostr">
                        
                                            <td width="2%">
                                                <h6 class="text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                       1
                                                </h6>
                                            </td>
                           
                                            <td class="text-center">
                                                <span class="stamp stamp" style="background-color: #1572e8">
                                                 4452
                                                </span>
                                            </td>
                                            
                                            <td class="text-center">
                                                    Rosario Magne
                                            </td>
                                            
                                            <td class="text-right">
                                                <div class="col-lg-12 card">
                                                    <div class="card-head text-center">

                                                        <b class="text-center" >Repuestos De Tienda</b> 
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table">
                                                     
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-lg-12 card">
                                                    <div class="card-head text-center">

                                                        <b class="text-center" >Repuestos De Almacen</b> 
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table">
                                                     
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </td>

                
                                            <td class="text-center">
                                              Bs. 4520
                                            </td>
                
                                            <td class="text-center">
                                              Roger Coaquira
                                            </td>
                                        </tr>
    
                                </tbody>
                                <tfoot>
                                    <tr class="tablaserviciostr">
                                        <td colspan="2" class="text-left">
                                            <span style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>TOTALES</b></span>
                                        </td>
                                        <td class="text-right" colspan="5">
                                            <span style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><strong>
                                                 
                                       
                                            
                                                </strong></span>
                                        </td>
                                        {{-- <td class="text-right" colspan="1">
                                            <span style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><strong>
                                                   
                                  

                                                </strong></span>
                                        </td> --}}
                                       

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('livewire.reporte_service.detallecosto')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        //eventos
        window.livewire.on('show-modal', msg => {
            $('#modalDetails').modal('show')
            noty(msg)
        });

    })
</script>
