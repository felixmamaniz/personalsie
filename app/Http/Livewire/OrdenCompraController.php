<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Destino;
use App\Models\DetalleSalidaProductos;
use App\Models\Lote;
use App\Models\Movimiento;
use App\Models\MovimientoCompra;
use App\Models\ProductosDestino;
use App\Models\Provider;
use App\Models\SalidaLote;
use App\Models\SalidaProductos;
use App\Models\SalidaServicio;
use App\Models\ServiceRepDetalleSolicitud;
use App\Models\ServiceRepEstadoSolicitud;
use App\Models\ServOrdenCompra;
use App\Models\ServOrdenDetalle;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrdenCompraController extends Component
{
    //Almacena todos los productos a comprar
    public $lista_productos, $cartera_id, $monto_bs_cambio, $message, $id_orden_compra;
    //Guarda el detalle con el cual se generará el ingreso en caso de que exista un monto cambio
    public $detalleingreso;
    


    //VARIABLES PARA LAS COMPRAS

    //Para guardar el total Bs de una compra
    public $total_compra_bs;
    //Guarda el tipo de Documento que se usa en una compra
    public $tipo_documento;
    //Guarda el numero de documento en una compra
    public $numero_documento;
    //Guarda el id de un proiveedor
    public $proveedor_id;
    //Guarda el id destino donde se registrará la compra
    public $destino_id;

    //Varibles para editar una orden de compra
    public $orden_compra_id;
    public $editar_usuario_comprador_id, $editar_monto_bs_compra, $editar_cartera_id;



    public function mount()
    {
        $this->lista_productos = collect([]);
        $this->tipo_documento = "NINGUNO";

        $destino = Destino::where("destinos.nombre","DEPOSITO")->where("destinos.sucursal_id", $this->idsucursal())->get();
        if($destino->count() > 0)
        {
            $this->destino_id = $destino->first()->id;
        }



        $proveedor = Provider::where("providers.nombre_prov","cancha")->get();
        if($proveedor->count() > 0)
        {
            $this->proveedor_id = $proveedor->first()->id;
        }


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

        //Detalle de ingreso en caso de que exista algun monto como cambio
        if(strlen($this->monto_bs_cambio) > 0)
        {
            $nombre_comprador = ServOrdenCompra::join("users as u", "u.id", "serv_orden_compras.idcomprador")
            ->select("u.name as nombrecomprador")
            ->where("serv_orden_compras.id",$this->id_orden_compra)
            ->get()
            ->first()->nombrecomprador;


            $this->detalleingreso = "Por el cambio recibido de: " .$nombre_comprador . " en la compra de repuestos para servicios";
        }

        //Listando todas las ordenes de compra
        $lista_ordenes = ServOrdenCompra::join("users as u","u.id","serv_orden_compras.user_id")
        ->join("movimientos as m", "m.id", "serv_orden_compras.movimiento_id")
        ->join("cartera_movs as cm", "cm.movimiento_id", "m.id")
        ->join("carteras as c", "c.id", "cm.cartera_id")
        ->select("serv_orden_compras.id as codigo","serv_orden_compras.idcomprador as idcomprador",
        "serv_orden_compras.estado as estado","m.import as monto_bs_compra","c.nombre as nombrecartera",
        "u.name as nombreusuario", DB::raw('0 as detalles'), DB::raw('0 as nombrecomprador'))
        ->orderBy("serv_orden_compras.created_at","desc")
        ->get();


        foreach($lista_ordenes as $l)
        {
            $l->detalles = $this->obtener_detalles($l->codigo);
            $l->nombrecomprador = $this->obtener_comprador($l->idcomprador);
        }



        //Lista todos los proveedores activos
        $providers = Provider::where('status','ACTIVO')->get();
        //Lista todos los destinos y su sucursal
        $destinos= Sucursal::join('destinos as d','sucursals.id','d.sucursal_id')
        ->select('d.nombre as nombredestino','d.id as destinoid','sucursals.name as nombresucursal')
        ->get();


        $lista_usuarios = User::select("users.*")
        ->where("users.status","ACTIVE")
        ->get();

        return view('livewire.ordencompra.ordencompra', [
            'lista_ordenes' => $lista_ordenes,
            'lista_carteras' => $this->listarcarteras(),
            'lista_cartera_general' => $this->listarcarterasg(),
            'listasucursales' => Sucursal::all(),
            'providers' => $providers,
            'destinos' => $destinos,
            'lista_usuarios' => $lista_usuarios,
        ])
            ->extends('layouts.theme.app')
            ->section('content');



    }
    //Obtiene detalles de una orden de compra
    public function obtener_detalles($idcompra)
    {
        $detalles = ServOrdenDetalle::join("products as p", "p.id","serv_orden_detalles.product_id")
        ->select("serv_orden_detalles.detalle_solicitud_id as detalle_id","p.id as product_id","p.nombre as nombreproducto",
        "serv_orden_detalles.cantidad as cantidad","p.costo as costoproducto",
        "p.precio_venta as precioproducto")
        ->where("serv_orden_detalles.orden_compra_id", $idcompra)
        ->get();
        return $detalles;
    }
    //Obtiene el nombre del comprador asignado
    public function obtener_comprador($idcomprador)
    {
        return User::find($idcomprador)->name;
    }
    //Listar las carteras disponibles en su corte de caja
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
    //Muestra el modal recibir compra
    public function modalrecibircompra($idordencompra)
    {
        $this->id_orden_compra = $idordencompra;
        //Vaciando la la coleccion (lista_productos)
        $this->lista_productos = collect([]);

        
        $productos = $this->obtener_detalles($idordencompra);

        foreach($productos as $p)
        {
            $this->lista_productos->push([
                'detail_id' => $p->detalle_id,
                'product_id' => $p->product_id,
                'product_name' => $p->nombreproducto,
                'price'=> $p->precioproducto,
                'cost' => $p->costoproducto,
                'quantity' => $p->cantidad
            ]);
        }

        $this->emit("modalrecibircompra-show");

    }
    //Recibe y finaliza una orden de compra - realiza una compra
    public function finalizar_compra()
    {
        $rules = [
            'cartera_id'=>'required|not_in:Elegir',
            'destino_id'=>'required|not_in:Elegir',
        ];
        $messages = [
            'cartera_id.required' => 'La cartera es requerido',
            'cartera_id.not_in' => 'Seleccione una Cartera',

            'destino_id.required' => 'La cartera es requerido',
            'destino_id.not_in' => 'Seleccione un Destino',
        ];
        $this->validate($rules, $messages);



        DB::beginTransaction();
        try
        {
            //Si escribio un monto de cambio
            if(strlen($this->monto_bs_cambio) > 0)
            {
                //Creando el movimiento con el monto dado como cambio
                $m = Movimiento::create([
                    'type' => 'TERMINADO',
                    'status' => 'ACTIVO',
                    'import' => $this->monto_bs_cambio,
                    'user_id' => Auth()->user()->id,
                ]);
                //Creando el egreso de cartera movimiento 
                CarteraMov::create([
                    'type' => 'INGRESO',
                    'tipoDeMovimiento' => 'EGRESO/INGRESO',
                    'comentario' => $this->detalleingreso,
                    'cartera_id' => $this->cartera_id,
                    'movimiento_id' => $m->id,
                ]);
                $nombrecartera = Cartera::find($this->cartera_id)->nombre;
                $this->message = "Se guardo la compra y se creó el ingreso de: " . $this->monto_bs_cambio . " Bs por concepto de cambio en la cartera " . $nombrecartera;
            }





            $total_bs = 0;
            //Actualizando y creando los estados de la orden de compra, detalle solicitud y detalle de la compra
            foreach($this->lista_productos as $l)
            {
                //Buscando el detalle de la solicitud
                $detalle = ServiceRepDetalleSolicitud::find($l['detail_id']);
                //Buscando los estados COMPRANDO del detalle de la solicitud
                foreach($detalle->estado_solicitud as $e)
                {
                    if($e->estado == 'COMPRANDO' && $e->status == 'ACTIVO')
                    {
                        //Actualizando los estados pendientes ACTIVO a iNACTIVO
                        $e->update([
                            'status' => 'INACTIVO'
                        ]);
                        //Creando nuevo estado ACTIVO para cada detalle solicitud
                        ServiceRepEstadoSolicitud::create([
                            'detalle_solicitud_id' => $l['detail_id'],
                            'user_id' => Auth()->user()->id,
                            'estado' => 'COMPRADO',
                            'status' => 'ACTIVO',
                        ]);
                    }
                }
                $total_bs = $total_bs + $l['cost'];
            }
            //Creando la Compra
            $compra = Compra::create([
                'importe_total' => $total_bs,
                'descuento' => 0,
                'fecha_compra' => Carbon::parse(Carbon::now()),
                'transaccion' => "Contado",
                'saldo' => "0.00",
                'tipo_doc' => $this->tipo_documento,
                'nro_documento' => $this->numero_documento,
                'observacion'=> "",
                'proveedor_id' => $this->proveedor_id,
                'estado_compra'=> "finalizada",
                'status' => "ACTIVO",
                'destino_id' => $this->destino_id,
                'user_id'=> Auth()->user()->id,
                'lote_compra'=> "",
            ]);
            //Creando el movimiento
            $movimiento = Movimiento::create([
                'type' => "COMPRAS",
                'status' => "ACTIVO",
                'saldo' => 0,
                'on_account' => 0,
                'import' => $total_bs,
                'user_id' => Auth()->user()->id
            ]);
            //Creando movimiento compra
            MovimientoCompra::create([
                'compra_id'=>$compra->id,
                'movimiento_id' => $movimiento->id
            ]);

            //Creando el detalle de la compra y el incremento del stock del producto
            foreach ($this->lista_productos as $p)
            {
                $lote = Lote::create([
                    'existencia' => $p['quantity'],
                    'costo' => $p['cost'],
                    'status' => 'Activo',
                    'product_id' => $p['product_id'],
                    'pv_lote' => $p['price']
                ]);

                CompraDetalle::create([
                    'precio' => $p['price'],
                    'cantidad' => $p['quantity'],
                    'product_id' => $p['product_id'],
                    'compra_id' => $compra->id,
                    'lote_compra'=>$lote->id
                ]);
                
                $q = ProductosDestino::where('product_id', $p['product_id'])
                ->where('destino_id', $this->destino_id)->value('stock');

                ProductosDestino::updateOrCreate([
                    'product_id' => $p['product_id'],
                    'destino_id' => $this->destino_id],
                    ['stock'=> $q + $p['quantity']]);


                //Creando la salida del producto (decrementando el Stock)

                $salida = SalidaProductos::create([
                    'destino' => $this->destino_id,
                    'user_id'=> Auth()->user()->id,
                    'concepto'=>'SALIDA',
                    'observacion'=>'Producto para servicio'
                ]);
        
                $detalle_salida = DetalleSalidaProductos::create([
                    'product_id' => $p['product_id'],
                    'cantidad' => $p['quantity'],
                    'id_salida' => $salida->id
                ]);
                //Listamos todos los lotes que tenga el producto
                $lotes_producto = Lote::where('product_id', $p['product_id'])->where('status','Activo')->get();
                //Obteniendo la cantidad de la salida de producto
                $cantidad_salida = ServiceRepDetalleSolicitud::find($p['detail_id'])->cantidad;
                //Decrementando los lotes del producto
                foreach ($lotes_producto as $lp)
                {
                    //Obteniendo la cantidad del lote
                    $cantidad_lote = $lp->existencia;
                    //Si la cantidad de salida es mayor que 0
                    if($cantidad_salida > 0)
                    {
                        //Si la cantidad de salida es mayor que la cantidad que hay en el lote
                        if($cantidad_salida > $cantidad_lote)
                        {
                            SalidaLote::create([
                            'salida_detalle_id' => $detalle_salida->id,
                            'lote_id' => $lp->id,
                            'cantidad' => $lp->existencia
                            ]);
                            $lp->update([
                                'existencia' => 0,
                                'status' => 'Inactivo'                       
                            ]);
                            $lp->save();
                            $cantidad_salida = $cantidad_salida - $cantidad_lote;
                        }
                        else
                        {
                            SalidaLote::create([
                                'salida_detalle_id' => $detalle_salida->id,
                                'lote_id' => $lp->id,
                                'cantidad' => $cantidad_salida
                            ]);
                            $lp->update([ 
                                'existencia' => $cantidad_lote - $cantidad_salida
                            ]);
                            $lp->save();
                            $cantidad_salida = 0;
                        }
                    }
                }

             
                $stock_producto = ProductosDestino::where('product_id', $p['product_id'])
                ->where('destino_id', $this->destino_id)->value('stock');

                
                $stock_actualizado = $stock_producto - ServiceRepDetalleSolicitud::find($p['detail_id'])->cantidad;

                ProductosDestino::updateOrCreate([
                    'product_id' => $p['product_id'],
                    'destino_id' => $this->destino_id],
                    ['stock' => $stock_actualizado]);

                SalidaServicio::create([
                    'salida_id' => $salida->id,
                    'service_id' => ServiceRepDetalleSolicitud::find($p['detail_id'])->service_id, 
                    'estado' => 'Activo'
                ]);
            }

        
            $orden_compra = ServOrdenCompra::find($this->id_orden_compra);
            $orden_compra->update([
                'estado' => 'COMPRADO'
            ]);

            $this->emit("modalrecibircompra-hide");
            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollback();
            $this->mensaje_toast = ": ".$e->getMessage();
            $this->emit('sale-error');
        }
    }
    //Elimina un item en la orden de compra
    public function EliminarItem($idproducto)
    {
        //Buscamos el elemento en la colección
        $result = $this->lista_productos->where('product_id', $idproducto);
        //Eliminando la fila del elemento en coleccion
        $this->lista_productos->pull($result->keys()->first());
        
    }
    //Muestra el modal editar orden de compra
    public function modaleditar($idorden)
    {
        $this->orden_compra_id = $idorden;
        $ordencompra = ServOrdenCompra::join("movimientos as m", "m.id", "serv_orden_compras.movimiento_id")
        ->join("cartera_movs as cm", "cm.movimiento_id", "m.id")
        ->join("users as u", "u.id", "serv_orden_compras.idcomprador")
        ->select("u.id as idcomprador", "m.import as monto_bs_compra","cm.cartera_id as carteraid")
        ->where("serv_orden_compras.id", $idorden)
        ->get()
        ->first();

        $this->editar_usuario_comprador_id = $ordencompra->idcomprador;
        $this->editar_monto_bs_compra = $ordencompra->monto_bs_compra;
        $this->editar_cartera_id = $ordencompra->carteraid;




        $this->emit("modaleditar-show");
    }
    //Actualiza una orden de compra
    public function actulizarordencompra()
    {
        dd($this->orden_compra_id);
    }
}
