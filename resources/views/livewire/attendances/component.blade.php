<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

            <!-- Secciones para las Ventas -->
            <div class="widget">

                <div class="widget-heading">
                    <div class="col-12 col-lg-12 col-md-10">
                        <!-- Titulo Detalle Venta -->
                        <h4 class="card-title text-center"><b>REPORTE DE ENTRADAS Y SALIDAS</b></h4>
                
                    </div>
                </div>
                <br>
                <br>

                <div class="widget-content">
                    <div class="row" >

                        <div class="col-sm-2">
                            <h6>Elige el Empleado</h6>
                            <div class="form-group">
                                <select wire:model="userId" class="form-control">
                                    <option value="0">Todos</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <h6>Entradas de la fecha</h6>
                            <div class="form-group">
                                <select wire:model="reportType" class="form-control">
                                    <option value="0">Entradas del Día</option>
                                    <option value="1">Entradas por Fecha</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-sm-2 ">
                            <h6>Fecha Desde</h6>
                            <div class="form-group">
                                <input @if ($reportType != 1) disabled @endif type="date" wire:model="dateFrom"
                                    class="form-control flatpickr" placeholder="Click para elegir">
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <h6>Fecha Hasta</h6>
                            <div class="form-group">
                                <input @if ($reportType != 1) disabled @endif type="date" wire:model="dateTo"
                                    class="form-control flatpickr" placeholder="Click para elegir">
                            </div>
                        </div>
                        
                       

                        <div class="col-sm-2 mt-4">
                                <a class="btn btn-primary 
                                href="{{ url('report/excel' . '/' . $userId . '/' . $reportType. '/' . $dateFrom. '/' . $dateTo) }}"
                                target="_blank">Exportar a Excel</a>

                        </div>
                        <div class="col-sm-5 mt-4">
                            <div class="card-body">
                                @if (isset($errors) && $errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                    {{$error}}
                                    @endforeach
                                </div>
                                @endif

                                <form action="{{url('POST')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="import_file">
                                    <button type="submit" class="btn btn-primary">
                                        IMPORTAR EXCEL
                                    </button>
                                </form>
                            </div>
                            

                            

                            

                    </div>
    
                    </div>
    
                    <br>
    
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                              <tr class="tablehead">
                                <th class="text-center">N°</th>
                                <th>FECHA</th>
                                <th class="text-center">ENTREDA</th>
                                <th class="text-center">SALIDA</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">RETRASO</th>
                                <th class="text-center">HORAS CUMPLIDAS</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="seleccionar">
                                        <td class="text-center">
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            
                                            {{ date("d/m/Y", strtotime($item->fecha)) }}
                                        </td>

                                        <td class="text-center">
                                            {{ ($item->entrada) }}
                                        </td>

                                        <td class="text-center">
                                            {{ ($item->salida) }}
                                        </td>

                                        <td class="text-center">
                                            {{ ($item->employee) }}
                                        </td>

                                        <td class="text-center">
                                            {{ ($item->retraso) }}
                                        </td>
                                        <td class="text-center">
                                            {{ ($item->hcumplida) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    

                                    <tr>
                                        <td colspan="8"></td>
                                    </tr>

                            </tbody>
                        </table>
                    </div>
                </div>



                


            </div>


    </div>

</div>


<script>
   
</script>