{{--
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
        