<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Movimiento;
use App\Models\ServiceRepDetalleSolicitud;
use App\Models\ServiceRepEstadoSolicitud;
use App\Models\ServOrdenCompra;
use App\Models\ServOrdenDetalle;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrdenCompraController extends Component
{
    //Almacena todos los productos a comprar
    public $lista_productos, $cartera_id, $monto_bs_cambio, $message, $id_orden_compra;
    //Guarda el detalle con el cual se generará el ingreso en caso de que exista un monto cambio
    public $detalleingreso;

    public function mount()
    {
        $this->lista_productos = collect([]);

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
        ->select("serv_orden_compras.id as codigo","serv_orden_compras.idcomprador as idcomprador",
        "serv_orden_compras.estado as estado",
        "u.name as nombreusuario", DB::raw('0 as detalles'), DB::raw('0 as nombrecomprador'))
        ->orderBy("serv_orden_compras.created_at","desc")
        ->get();


        foreach($lista_ordenes as $l)
        {
            $l->detalles = $this->obtener_detalles($l->codigo);
            $l->nombrecomprador = $this->obtener_comprador($l->idcomprador);
        }


        return view('livewire.ordencompra.ordencompra', [
            'lista_ordenes' => $lista_ordenes,
            'lista_carteras' => $this->listarcarteras(),
            'lista_cartera_general' => $this->listarcarterasg(),
            'listasucursales' => Sucursal::all(),
        ])
            ->extends('layouts.theme.app')
            ->section('content');



    }
    //Obtiene detalles de una orden de compra
    public function obtener_detalles($idcompra)
    {
        $detalles = ServOrdenDetalle::join("products as p", "p.id","serv_orden_detalles.product_id")
        ->select("serv_orden_detalles.detalle_solicitud_id as detalle_id","p.id as product_id","p.nombre as nombreproducto", "serv_orden_detalles.cantidad as cantidad","p.costo as costoproducto"
        ,"p.precio_venta as precioproducto")
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
    //Recibe y finaliza una orden de compra
    public function finalizar_compra()
    {
        //Si no escribio un monto de cambio
        if(strlen($this->monto_bs_cambio) == 0)
        {
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



            }
        }
        else
        {
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



            }
        }
        $orden_compra = ServOrdenCompra::find($this->id_orden_compra);

        $orden_compra->update([
            'estado' => 'COMPRADO'
        ]);




        //Creando el movimiento con el monto dado como cambio
        $movimiento = Movimiento::create([
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
            'movimiento_id' => $movimiento->id,
        ]);

        $nombrecartera = Cartera::find($this->cartera_id)->nombre;

        $this->message = "Se guardo la compra y se creó el ingreso de: " . $this->monto_bs_cambio . " Bs por concepto de cambio en la cartera " . $nombrecartera;

        $this->emit("modalrecibircompra-hide");

    }
    //Elimina un item en la orden de compra
    public function EliminarItem($idproducto)
    {
        //Buscamos el elemento en la colección
        $result = $this->lista_productos->where('product_id', $idproducto);
        //Eliminando la fila del elemento en coleccion
        $this->lista_productos->pull($result->keys()->first());
        
    }
}
