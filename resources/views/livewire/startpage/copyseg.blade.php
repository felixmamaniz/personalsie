{{--
    /*Carbon::setLocale('es');
        $TiempoTranscurrido = setlocale(LC_TIME, 'es_ES.utf8');

        $date = Carbon::now();
        $TiempoC = Carbon::parse($date)->format('Y-m-d', '$fechaInicio');

        $fechaInicio = '$dateAdmission';
        $fechaActual = $TiempoC;

        $currentDate = Carbon::createFromFormat('Y-m-d', '$fechaInicio');
        $shippingDate = Carbon::createFromFormat('Y-m-d', '$fechaFin');

        $diferencia_en_dias = $currentDate->diffInDays($shippingDate);

        //$diferencia_en_dias = $shippingDate->diffInDays($currentDate);

        $TiempoTranscurrido =  $diferencia_en_dias;
        */


    REALIZAR
    REDUCIR TAMAÑO Y PESO DE IMAGEN
    https://codea.app/blog/reducir-el-tamano-de-una-imagen

    // empleados

    contrato
    fecha de inicio en tabla enpleado
    fecha fin en contrato

    aumentar columna fotos
    puesto de trabajo
    estado civil

    detalle del empleado
    
    no aplica estos datos
        formacion
        titulacion
        cursos
        certificados
        conocimientos
        experiencias

    contrato
        fcha inico
        fecha fin
        descripcion
        -> no requerido = tipo de contrato
        notas
        -> agregar estado

        php artisan make:model "NOMBRE DE LA TABLA EN SINGULAR" -m 
        php artisan make:livewire nombre
        php artisan make:seeder "nombreSeeder" -> de cada tabla o migracion

    //$fechaInicio =   '$dateAdmission';//'2020-8-30 00:00:00';
    //$fechaActual = Carbon::now();//'2022-12-31 00:00:00';//'date("Y-m-d")'; //Carbon::now();

    EmployeeController

    //$dateFrom = 
    //$date = Carbon::now();
    // $TiempoTranscurrido = Carbon::parse($date)->format('Y-m-d');
    // tiempo transcurrido de año mes y dia
        
    //$TiempoTranscurrido = $date->subYear(2021);
    //$TiempoTranscurrido = $date->subMonth(30);
    //$TiempoTranscurrido = $date->subDay(8);
    //$TiempoTranscurrido = Carbon::createFromDate(2020,30,8)->age;

	Models
	protected $dates = [
        	'dateAdmission',
    ];

        /*
        Carbon::setLocale('es');
        $TiempoTranscurrido = setlocale(LC_TIME, 'es_ES.utf8');

        $date = Carbon::now();
        $TiempoC = Carbon::parse($date)->format('Y-m-d');

        $fechaInicio = '$dateAdmission';
        $fechaActual = $TiempoC;

        //pruebadbhvdg

        $segundos = strtotime($fechaActual) - strtotime($fechaInicio);  // segundos
        $segRedondeados = floor($segundos);

        $minutos = $segRedondeados / 60;    // minutos
        $minRedondeados = floor($minutos);

        $horas = $minRedondeados / 60;  // horas
        $horasRedondeados = floor($horas);

        $dias = $horasRedondeados / 24;     // dias
        $diasRedondeados = floor($dias);    // para redondeo de un dia mas ceil()

        $meses = $diasRedondeados / 28;     // meses
        $mesesRedondeados = floor($meses);

        $años = $mesesRedondeados - 12;     // años
        $añosRedondeados = floor($años);

        //dd( $TiempoTranscurrido);
        if($añosRedondeados > 0){
            $TiempoTranscurrido = $añosRedondeados . " Años ". $mesesRedondeados . " Meses y ". $diasRedondeados . " Dias";
        }else{
            if($añosRedondeados < 1){
                $TiempoTranscurrido = $mesesRedondeados . " Meses y ". $diasRedondeados . " Dias";
            }else{
                $TiempoTranscurrido = $diasRedondeados . " Dias";
            }
        }*/


        https://es.stackoverflow.com/questions/348757/diferencia-de-d%C3%ADas-entre-dos-fechas
--}}
        

 {{-- DATOS DE CONTRATO 
                    
                    <div class="card-body" style="background: #e6e6e9" >
                        <h5 class="card-title">Datos de Contrato</h5>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Final</label>
                                    <input type="date" wire:model.lazy="fechaFin" class="form-control">
                                </div>
                                @error('fechaFin') <span class="text-danger er">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <input type="text" wire:model.lazy="descripcion" class="form-control">
                                </div>
                                @error('descripcion') <span class="text-danger er">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Nota</label>
                                    <textarea type="text" class="form-control" wire:model.lazy="nota"></textarea>
                                </div>
                                @error('nota') <span class="text-danger er">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Estado de Contrato</label>
                                    <select wire:model="estado" class="form-control">
                                        <option value="Elegir" disabled>Elegir</option>
                                        <option value="Activo" selected>Activo</option>
                                        <option value="Finalizado" selected>Finalizado</option>
                                    </select>
                                    @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>--}}