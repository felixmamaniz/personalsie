<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\ServOrdenCompra;
use App\Models\ServOrdenDetalle;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrdenCompraController extends Component
{
    //Almacena todos los productos a comprar
    public $lista_productos, $cartera_id, $monto_bs_cambio;

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

        $lista_ordenes = ServOrdenCompra::join("users as u","u.id","serv_orden_compras.user_id")
        ->select("serv_orden_compras.id as codigo","serv_orden_compras.idcomprador as idcomprador",
        "u.name as nombreusuario", DB::raw('0 as detalles'), DB::raw('0 as nombrecomprador'))
        ->get();


        foreach($lista_ordenes as $l)
        {
            $l->detalles = $this->obtener_detalles($l->codigo);
            $l->nombrecomprador = $this->obtener_comprador($l->idcomprador);
        }


        return view('livewire.ordencompra.ordencompra', [
            'lista_ordenes' => $lista_ordenes,
            'lista_carteras' => $this->listarcarteras(),
            'lista_cartera_general' => $this->listarcarterasg()
        ])
            ->extends('layouts.theme.app')
            ->section('content');



    }
    //Obtiene detalles de una orden de compra
    public function obtener_detalles($idcompra)
    {
        $detalles = ServOrdenDetalle::join("products as p", "p.id","serv_orden_detalles.product_id")
        ->select("p.nombre as nombreproducto", "serv_orden_detalles.cantidad as cantidad","p.costo as costoproducto"
        ,"p.precio_venta as precioproducto")
        ->where("serv_orden_detalles.orden_compra_id", $idcompra)
        ->get();
        return $detalles;
    }
    //Obtiene 
    public function obtener_comprador($idcomprador)
    {
        return User::find($idcomprador)->name;
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

    public function modalrecibircompra($idordencompra)
    {
        $this->lista_productos = collect([]);
        $productos = $this->productos_orden_compra($idordencompra);

        foreach($productos as $p)
        {
            $this->lista_productos->push([
                'product_id' => $p->product_id,
                'product_name' => $p->nombreproducto,
                'price'=> $p->precio,
                'cost' => $p->costo,
                'quantity' => $p->cantidad
            ]);
        }

        $this->emit("modalrecibircompra-show");

    }
    //Devuelve todos los productos de una solicitud
    public function productos_orden_compra($idordencompra)
    {
        $productos = ServOrdenDetalle::join("service_rep_detalle_solicituds as d", "d.id", "serv_orden_detalles.detalle_solicitud_id")
        ->join("products as p", "p.id", "serv_orden_detalles.product_id")
        ->select("p.id as product_id","p.nombre as nombreproducto","p.precio_venta as precio", "p.costo as costo", "serv_orden_detalles.cantidad as cantidad")
        ->where("serv_orden_detalles.orden_compra_id", $idordencompra)
        // ->groupBy("p.id")
        ->get();
        return $productos;
    }

    public function finalizar_compra()
    {
        dd();
    }
}
