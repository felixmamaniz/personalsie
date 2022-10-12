<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\DetalleSalidaProductos;
use App\Models\Lote;
use App\Models\Movimiento;
use App\Models\ProductosDestino;
use App\Models\SalidaLote;
use App\Models\SalidaProductos;
use App\Models\SalidaServicio;
use App\Models\Service;
use App\Models\ServiceRepDetalleSolicitud;
use App\Models\ServiceRepEstadoSolicitud;
use App\Models\ServiceRepSolicitud;
use App\Models\ServOrdenCompra;
use App\Models\ServOrdenDetalle;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class SolicitudRepuestosController extends Component
{
    //Para poner cualquier mensaje en pantalla
    public $message;
    //Guarda el id de una Órden de Servicio
    public $orden_de_servicio_id;
    //Guarda el id de una solicitud
    public $solicitud_id;
    //Guarda el Total Bs de todos los productos a comprar
    public $total_bs;
    //Almacena todos los productos a comprar
    public $lista_productos;
    //Guarda el id de un usuario para que realice la compra
    public $usuario_id;
    //Guarda el Monto en Bs para la Compra
    public $monto_bs_compra;
    //Guarda el id de una cartera seleccionada para la compra
    public $cartera_id;
    //Guarda el id de la sucursal seleccionada
    public $sucursal_id;
    //Variable para almacenar las palabras en la busquedas de solicitudes
    public $search;
    //Guarda el detalle con el que se generará el egreso por compra de repuestos
    public $detalleegreso;

    public function mount()
    {
        $this->lista_productos = collect([]);
        $this->sucursal_id = "Todos";
        $this->cartera_id = 'Elegir';
        foreach($this->listarcarteras() as $list)
        {
            if($list->tipo == 'CajaFisica')
            {
                $this->cartera_id = $list->idcartera;
                break;
            }
        }
    }
    public function render()
    {


        if($this->usuario_id > 0 && $this->monto_bs_compra >= $this->total_bs && $this->cartera_id > 0)
        {
            $nombre_comprador = User::find($this->usuario_id)->name;
            $this->detalleegreso = "Para la compra de repuestos en servicios, dinero entregado a " . $nombre_comprador;
        }
        if(strlen($this->search) == 0)
        {
            if($this->sucursal_id == "Todos")
            {
                $lista_solicitudes = ServiceRepSolicitud::join("users as u","u.id","service_rep_solicituds.user_id")
                ->join("sucursals as s","s.id","service_rep_solicituds.sucursal_id")
                ->select("service_rep_solicituds.id as id",
                DB::raw('0 as minutos'),
                DB::raw('0 as detalles'),
                "service_rep_solicituds.order_service_id as codigo","s.name as nombresucursal",
                "u.name as nombresolicitante", "service_rep_solicituds.created_at as created_at")
                ->orderBy("service_rep_solicituds.created_at", "desc")
                ->get();
                foreach($lista_solicitudes as $l)
                {
                    $l->minutos = $this->solicitudreciente($l->id);
                    $l->detalles = $this->obtenerdetalles($l->id);
                }
            }
            else
            {
                $lista_solicitudes = ServiceRepSolicitud::join("users as u","u.id","service_rep_solicituds.user_id")
                ->join("sucursals as s","s.id","service_rep_solicituds.sucursal_id")
                ->select("service_rep_solicituds.id as id",
                DB::raw('0 as minutos'),
                DB::raw('0 as detalles'),
                "service_rep_solicituds.order_service_id as codigo","s.name as nombresucursal",
                "u.name as nombresolicitante", "service_rep_solicituds.created_at as created_at")
                ->where("s.id",$this->sucursal_id)
                ->orderBy("service_rep_solicituds.created_at", "desc")
                ->get();
                foreach($lista_solicitudes as $l)
                {
                    $l->minutos = $this->solicitudreciente($l->id);
                    $l->detalles = $this->obtenerdetalles($l->id);
                }
            }
        }
        else
        {
            if($this->sucursal_id == "Todos")
            {
                $lista_solicitudes = ServiceRepSolicitud::join("users as u","u.id","service_rep_solicituds.user_id")
                ->join("sucursals as s","s.id","service_rep_solicituds.sucursal_id")
                ->select("service_rep_solicituds.id as id",
                DB::raw('0 as minutos'),
                DB::raw('0 as detalles'),
                "service_rep_solicituds.order_service_id as codigo","s.name as nombresucursal",
                "u.name as nombresolicitante", "service_rep_solicituds.created_at as created_at")
                ->where('service_rep_solicituds.order_service_id', 'like', '%' . $this->search . '%')
                ->orderBy("service_rep_solicituds.created_at", "desc")
                ->get();
                foreach($lista_solicitudes as $l)
                {
                    $l->minutos = $this->solicitudreciente($l->id);
                    $l->detalles = $this->obtenerdetalles($l->id);
                }
            }
            else
            {
                $lista_solicitudes = ServiceRepSolicitud::join("users as u","u.id","service_rep_solicituds.user_id")
                ->join("sucursals as s","s.id","service_rep_solicituds.sucursal_id")
                ->select("service_rep_solicituds.id as id",
                DB::raw('0 as minutos'),
                DB::raw('0 as detalles'),
                "service_rep_solicituds.order_service_id as codigo","s.name as nombresucursal",
                "u.name as nombresolicitante", "service_rep_solicituds.created_at as created_at")
                ->where('service_rep_solicituds.order_service_id', 'like', '%' . $this->search . '%')
                ->where("s.id",$this->sucursal_id)
                ->orderBy("service_rep_solicituds.created_at", "desc")
                ->get();
                foreach($lista_solicitudes as $l)
                {
                    $l->minutos = $this->solicitudreciente($l->id);
                    $l->detalles = $this->obtenerdetalles($l->id);
                }
            }
        }



        






        $lista_usuarios = User::select("users.*")
        ->where("users.status","ACTIVE")
        ->get();


        return view('livewire.solicitudrepuestos.component', [
            'lista_solicitudes' => $lista_solicitudes,
            'lista_usuarios' => $lista_usuarios,
            'lista_carteras' => $this->listarcarteras(),
            'lista_cartera_general' => $this->listarcarterasg(),
            'listasucursales' => Sucursal::all(),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    //Obtener el Id de la Sucursal donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }
    //Devuelve los detalles de una solicitud
    public function obtenerdetalles($idsolicitud)
    {
        $detalles = ServiceRepDetalleSolicitud::join("service_rep_solicituds as srs","srs.id","service_rep_detalle_solicituds.solicitud_id")
        ->join("products as p","p.id","service_rep_detalle_solicituds.product_id")
        ->join("service_rep_estado_solicituds as e","e.detalle_solicitud_id","service_rep_detalle_solicituds.id")
        ->leftjoin("destinos as d","d.id","service_rep_detalle_solicituds.destino_id")
        ->select("service_rep_detalle_solicituds.id as iddetalle","p.nombre as nombreproducto","p.costo as costoproducto",
        "service_rep_detalle_solicituds.cantidad as cantidad"
        ,"service_rep_detalle_solicituds.tipo as tipo","e.estado as estado", "d.nombre as nombredestino")
        ->where("srs.id", $idsolicitud)
        ->where("e.status", "ACTIVO")
        ->get();
        return $detalles;
    }

    //Muestra el Modal Iniciar Compra
    public function modal_iniciar_compra()
    {

        $this->lista_productos = collect([]);

        $productos = ServiceRepDetalleSolicitud::join("service_rep_estado_solicituds as e", "e.detalle_solicitud_id", "service_rep_detalle_solicituds.id")
        ->join("products as p", "p.id", "service_rep_detalle_solicituds.product_id")
        ->select("service_rep_detalle_solicituds.id as iddetalle","p.id as idproducto","p.nombre as nombreproducto","service_rep_detalle_solicituds.cantidad as cantidad", "p.costo as costo", "p.precio_venta as precio")
        ->where("service_rep_detalle_solicituds.tipo", "CompraRepuesto")
        ->where("e.status", "ACTIVO")
        ->where("e.estado", "PENDIENTE")
        ->get();


        $bs = 0;

        foreach($productos as $p)
        {
            $this->lista_productos->push([
                'detalle_id' => $p->iddetalle,
                'product_id' => $p->idproducto,
                'product_name' => $p->nombreproducto,
                'price'=> $p->precio,
                'cost' => $p->costo,
                'quantity' => $p->cantidad
            ]);
            $bs = ($p->costo * $p->cantidad) + $bs;
        }

        $this->total_bs = $bs;


        $this->emit("modalcomprarepuesto-show");
    }
    //Crea o Inicia una Orden de Compra
    public function iniciar_compra()
    {
        $rules = [ /* Reglas de validacion */
            'usuario_id' => 'required|not_in:Elegir',
            'monto_bs_compra' => 'required|not_in:0',
            'cartera_id' => 'required|not_in:Elegir',
        ];
        $messages = [ /* mensajes de validaciones */
            'usuario_id.required' => 'Seleccione un usuario',
            'monto_bs_compra.required' => 'Escriba un monto válido',
            'cartera_id.required' => 'Escriba una cartera',
        ];

        $this->validate($rules, $messages);
        if($this->monto_bs_compra >= $this->total_bs)
        {

            //Creando el movimiento con el monto dado para la compra
            $movimiento = Movimiento::create([
                'type' => 'TERMINADO',
                'status' => 'ACTIVO',
                'import' => $this->monto_bs_compra,
                'user_id' => Auth()->user()->id,
            ]);
            //Creando el egreso de cartera movimiento 
            CarteraMov::create([
                'type' => 'EGRESO',
                'tipoDeMovimiento' => 'EGRESO/INGRESO',
                'comentario' => $this->detalleegreso,
                'cartera_id' => $this->cartera_id,
                'movimiento_id' => $movimiento->id,
            ]);
    
            $nombrecartera = Cartera::find($this->cartera_id)->nombre;
    
            $this->message = "Se creó el egreso de: " . $this->monto_bs_compra . " Bs de la cartera " . $nombrecartera;




            //Creando la órden de Compra
            $orden_compra = ServOrdenCompra::create([
                'user_id' => Auth()->user()->id,
                'movimiento_id' => $movimiento->id,
                'idcomprador' => $this->usuario_id,
            ]);
            
            //Obtenemos los detalles de la coleccion lista_productos
            foreach($this->lista_productos as $l)
            {
                //Buscando el detalle de la solicitud
                $detalle = ServiceRepDetalleSolicitud::find($l['detalle_id']);
    
                //Buscando los estados Pendientes del detalle de la solicitud
                foreach($detalle->estado_solicitud as $e)
                {
    
                    if($e->estado == 'PENDIENTE' && $e->status == 'ACTIVO')
                    {
                        //Actualizando los estados pendientes ACTIVO a iNACTIVO
                        $e->update([
                            'status' => 'INACTIVO'
                        ]);
                        //Creando nuevo estado ACTIVO para cada detalle solicitud
                        ServiceRepEstadoSolicitud::create([
                            'detalle_solicitud_id' => $l['detalle_id'],
                            'user_id' => Auth()->user()->id,
                            'estado' => 'COMPRANDO',
                            'status' => 'ACTIVO',
                        ]);
    
    
                        //Creando el detalle de la orden de compra
                        ServOrdenDetalle::create([
                            'orden_compra_id' => $orden_compra->id,
                            'detalle_solicitud_id' => $l['detalle_id'],
                            'product_id' => $l['product_id'],
                            'cantidad' => $l['quantity'],
                            'status' => 'ACTIVO',
                        ]);
                    }
                }
                
            }
    

            $this->emit("modalcomprarepuesto-hide");
        }
        else
        {
            $this->message = "Por favor ponga un monto mayor o igual al Precio Total Estimado";
            $this->emit("mensaje-info");
        }
    }
    //Devuelve todos los productos de una solicitud
    public function productos_solicitud($idsolicitud)
    {
        $productos = ServiceRepSolicitud::join("service_rep_detalle_solicituds as d", "d.solicitud_id", "service_rep_solicituds.id")
        ->join("products as p", "p.id", "d.product_id")
        ->select("p.nombre as nombreproducto","p.precio_venta as precio", "p.costo as costo", "d.cantidad as cantidad")
        ->where("service_rep_solicituds.id", $idsolicitud)
        ->groupBy("p.id")
        ->get();
        return $productos;
    }
    //Devuelve el tiempo en minutos de una Solicitud Reciente
    public function solicitudreciente($idsolicitud)
    {
        //Variable donde se guardaran los minutos de diferencia entre el tiempo de la solicitud y el tiempo actual
        $minutos = -1;
        //Guardando el tiempo en la cual se realizo la solicitud
        $date = Carbon::parse(ServiceRepSolicitud::find($idsolicitud)->created_at)->format('Y-m-d');
        //Comparando que el dia-mes-año de la solicitud sean iguales al tiempo actual
        if($date == Carbon::parse(Carbon::now())->format('Y-m-d'))
        {
            //Obteniendo la hora en la que se realizo la solicitud
            $hora = Carbon::parse(ServiceRepSolicitud::find($idsolicitud)->created_at)->format('H');
            //Obteniendo la hora de la solicitud mas 1 para incluir horas diferentes entre una hora solicitud y la hora actual en el else
            $hora_mas = $hora + 1;
            //Si la hora de la solicitud coincide con la hora actual
            if($hora == Carbon::parse(Carbon::now())->format('H'))
            {
                //Obtenemmos el minuto de la solicitud
                $minutos_solicitud = Carbon::parse(ServiceRepSolicitud::find($idsolicitud)->created_at)->format('i');
                //Obtenemos el minuto actual
                $minutos_actual = Carbon::parse(Carbon::now())->format('i');
                //Calculamos la diferencia
                $diferenca = $minutos_actual - $minutos_solicitud;
                //Actualizamos la variable $minutos por los minutos de diferencia si la solicitud fue hace 1 hora antes que la hora actual
                if($diferenca <= 60)
                {
                    $minutos = $diferenca;
                }
            }
            else
            {
                //Ejemplo: Si la hora de la solicitud es 14:59 y la hora actual es 15:01
                //Usamos la variable $hora_mas para comparar con la hora actual, esto para obtener solo a las solicituds que sean una hora antes que la hora actual
                if($hora_mas == Carbon::parse(Carbon::now())->format('H'))
                {
                    //Obtenemmos el minuto de la solicitud con una hora antes que la hora actual
                    $minutos_solicitud = Carbon::parse(ServiceRepSolicitud::find($idsolicitud)->created_at)->format('i');
                    //Obtenemos el minuto actual
                    $minutos_actual = Carbon::parse(Carbon::now())->format('i');
                    //Restamos el minuto de la solicitud con el minuto actual y despues le restamos 60 minutos por la hora antes añadida ($hora_mas)
                    $mv = (($minutos_solicitud - $minutos_actual) - 60) * -1;
                    //Actualizamos la variable $minutos por los minutos de diferencia si la solicitud fue hace 1 hora antes que la hora actual
                    if($mv <= 60)
                    {
                        $minutos = $mv;
                    }
                }
            }
        }

        
        return $minutos;
    }
    //Escucha los eventos javascript de la vista
    protected $listeners = [
        'aceptarsolicitud' => 'aceptar_solicitud'
    ];
    //Pasa el estado de un detalle de una solicitud de PENDIENTE a ACEPTADO
    public function aceptar_solicitud($iddetalle, $codigo)
    {

        $detalle_solicitud = ServiceRepDetalleSolicitud::find($iddetalle);
        foreach($detalle_solicitud->estado_solicitud as $estado)
        {
            $estado->update([
                'status' => 'INACTIVO'
            ]);
        }
        ServiceRepEstadoSolicitud::create([
            'detalle_solicitud_id' => $detalle_solicitud->id,
            'user_id' => Auth()->user()->id,
            'estado' => 'ACEPTADO'
        ]);

        //Salida Registrada de productos aceptados 
        try
        {
            $operacion = SalidaProductos::create([
                'destino' => $detalle_solicitud->destino_id,
                'user_id'=> Auth()->user()->id,
                'concepto'=>'SALIDA',
                'observacion'=>'Producto para servicio'
            ]);
    
            $auxi = DetalleSalidaProductos::create([
                'product_id'=>$detalle_solicitud->product_id,
                'cantidad'=> $detalle_solicitud->cantidad,
                'id_salida'=>$operacion->id
            ]);

            $lot = Lote::where('product_id',$detalle_solicitud->product_id)->where('status','Activo')->get();

            //obtener la cantidad del detalle de la venta 
            $this->qq = $detalle_solicitud->cantidad;
            foreach ($lot as $val) { 
            $this->lotecantidad = $val->existencia;
          
            if($this->qq>0){
         
               if ($this->qq > $this->lotecantidad) {
                   $ss=SalidaLote::create([
                       'salida_detalle_id'=>$auxi->id,
                       'lote_id'=>$val->id,
                       'cantidad'=>$val->existencia
                       
                   ]);
                   $val->update([
                       'existencia'=>0,
                       'status'=>'Inactivo'                       
                    ]);
                    $val->save();
                    $this->qq=$this->qq-$this->lotecantidad;
                    
               }
               else{
               
                $ss=SalidaLote::create([
                   'salida_detalle_id'=>$auxi->id,
                   'lote_id'=>$val->id,
                   'cantidad'=>$this->qq
                   
               ]);

                   $val->update([ 
                       'existencia'=>$this->lotecantidad-$this->qq
                   ]);
                   $val->save();
                   $this->qq=0;
               
                }
                }
    
             }

             
             $q=ProductosDestino::where('product_id',$detalle_solicitud->product_id)
             ->where('destino_id',$detalle_solicitud->destino_id)->value('stock');

             ProductosDestino::updateOrCreate(['product_id' => $detalle_solicitud->product_id, 'destino_id'=>$detalle_solicitud->destino_id],['stock'=>$q-$detalle_solicitud->cantidad]); 


             SalidaServicio::create([
                'salida_id'=>$operacion->id,
                'service_id'=>$detalle_solicitud->service_id, 
                'estado'=>'Activo'
            ]);
    
        

            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollback();
            dd($e->getMessage());
        }

        $this->message = "¡Solicitud de la Orden de Servicio: " . $codigo . " Aceptada!";

        $this->emit("mensaje-ok");

    }
    //Listar las Carteras disponibles en su corte de caja
    public function listarcarteras()
    {
        $carteras = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
        ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
        ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
        ->where('cajas.estado', 'Abierto')
        ->where('mov.user_id', Auth()->user()->id)
        ->where('mov.status', 'ACTIVO')
        ->where('mov.type', 'APERTURA')
        ->where('cajas.sucursal_id', $this->idsucursal())
        ->select('car.id as idcartera', 'car.nombre as nombrecartera', 'car.descripcion as dc','car.tipo as tipo')
        ->get();
        return $carteras;
    }
    //Listar las carteras generales
    public function listarcarterasg()
    {
        $carteras = Caja::join('carteras as car', 'cajas.id', 'car.caja_id')
        ->where('cajas.id', 1)
        ->select('car.id as idcartera', 'car.nombre as nombrecartera', 'car.descripcion as dc','car.tipo as tipo')
        ->get();
        return $carteras;
    }
    //Muestra un mensaje para los productos pendientes de compra
    public function solicitar_orden_compra()
    {
        $this->message = "Para realizar la compra de este producto por favor haga click en 'Generar Orden de Compra'";
        $this->emit("mensaje-info");
    }
    //Elimina un item en la orden de compra
    public function EliminarItem($idproducto)
    {
        //Buscamos el elemento en la colección
        $result = $this->lista_productos->where('product_id', $idproducto);
        //Eliminando la fila del elemento en coleccion
        $this->lista_productos->pull($result->keys()->first());




        $bs = 0;

        foreach($this->lista_productos as $l)
        {
            $bs = ($l['cost'] * $l['quantity']) + $bs;
        }

        $this->total_bs = $bs;
        
    }
}
