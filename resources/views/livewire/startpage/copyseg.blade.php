{{--
    REALIZAR
    REDUCIR TAMAÑO Y PESO DE IMAGEN
    https://codea.app/blog/reducir-el-tamano-de-una-imagen

    // empleados

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

{{--
    
    //Devuelve el tiempo en minutos de una venta reciente
    public function Ejemplo($id)
    {
        //Variable donde se guardaran los minutos de diferencia entre el tiempo de una venta y el tiempo actual
        $minutos = -1;
        //Guardando el tiempo en la cual se realizo la venta
        $date = Carbon::parse(Employee::find($id)->created_at)->format('Y');
        //Comparando que el dia-mes-año de la venta sean iguales al tiempo actual
        if($date == Carbon::parse(Carbon::now())->format('Y'))
        {
            //Obteniendo la hora en la que se realizo la venta
            $hora = Carbon::parse(Sale::find($idventa)->created_at)->format('H');
            //Obteniendo la hora de la venta mas 1 para incluir horas diferentes entre una hora venta y la hora actual en el else
            $hora_mas = $hora + 1;
            //Si la hora de la venta coincide con la hora actual
            if($hora == Carbon::parse(Carbon::now())->format('H'))
            {
                //Obtenemmos el minuto de la venta
                $minutos_venta = Carbon::parse(Sale::find($idventa)->created_at)->format('i');
                //Obtenemos el minuto actual
                $minutos_actual = Carbon::parse(Carbon::now())->format('i');
                //Calculamos la diferencia
                $diferenca = $minutos_actual - $minutos_venta;
                //Actualizamos la variable $minutos por los minutos de diferencia si la venta fue hace 1 hora antes que la hora actual
                if($diferenca <= 60)
                {
                    $minutos = $diferenca;
                }
            }
            else
            {
                //Ejemplo: Si la hora de la venta es 14:59 y la hora actual es 15:01
                //Usamos la variable $hora_mas para comparar con la hora actual, esto para obtener solo a las ventas que sean una hora antes que la hora actual
                if($hora_mas == Carbon::parse(Carbon::now())->format('H'))
                {
                    //Obtenemmos el minuto de la venta con una hora antes que la hora actual
                    $minutos_venta = Carbon::parse(Sale::find($idventa)->created_at)->format('i');
                    //Obtenemos el minuto actual
                    $minutos_actual = Carbon::parse(Carbon::now())->format('i');
                    //Restamos el minuto de la venta con el minuto actual y despues le restamos 60 minutos por la hora antes añadida ($hora_mas)
                    $mv = (($minutos_venta - $minutos_actual) - 60) * -1;
                    //Actualizamos la variable $minutos por los minutos de diferencia si la venta fue hace 1 hora antes que la hora actual
                    if($mv <= 60)
                    {
                        $minutos = $mv;
                    }
                }
            }
        }

        
        return $minutos;
    }
--}}

{{-- Tiempo Restante 
    tt = tiempo trascurrido = tiempo que esta hasta el momento
    tr = tiempo restante
    estadia = fehaInicio + fechaFinal
    tr = estadia - tt

    tt = 2 meses
    tr = 1
    estadia = 3 pasante
    tr = 3 - 2
    tiempo restante = tr = 1

--}}
        