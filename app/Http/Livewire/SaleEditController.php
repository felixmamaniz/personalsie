<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Facade\FlareClient\Http\Client;
use Livewire\Component;

class SaleEditController extends Component
{
    public $clienteanonimo;

    public $factura;

    public $cartera_id;

    public $total_items;

    public $total_bs;

    public $buscarproducto;

    public $nombrecliente;

    public $denominations;

    public $descuento_recargo;

    public $observacion;


    //Carrito de Ventas

    public $carrito_venta;

    public function mount()
    {
        //Actualiza el total items del carrito de ventas
        $this->total_items = 12;



        //Obteniendo el id de la venta por la variable de sesión
        $ventaid = session('venta_id');
        $venta = Sale::join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm","cm.movimiento_id","m.id")
        ->select("cm.cliente_id as idcliente","sales.factura as factura","sales.cartera_id as cartera_id",
        "sales.observacion as observacion")
        ->where("sales.id",$ventaid)
        ->get()
        ->first();
        $idcliente = $venta->idcliente;
        $cliente = Cliente::where("clientes.id", $idcliente)
        ->where("clientes.nombre", "Cliente Anónimo")
        ->get();



        if($cliente->count() > 0)
        {
            $this->clienteanonimo = true;
        }

        if($venta->factura == "Si")
        {
            $this->factura = true;
        }
        else
        {
            $this->factura = false;
        }
        $this->cartera_id = $venta->cartera_id;
        $this->observacion = $venta->observacion;

        $this->carrito_venta = collect([]);

        $detalle = SaleDetail::join("products as p","p.id", "sale_details.product_id")
        ->where("sale_details.sale_id", $ventaid)
        ->select("p.nombre as name_product","sale_details.price as price","sale_details.quantity as quantity","sale_details.product_id as product_id")
        ->get();


        $cont = 1;

        foreach($detalle as $d)
        {
            //Llenando la coleccion con los productos de la venta
            $this->carrito_venta->push([
                'order' => $cont,
                'name' => $d->name_product,
                'price' => $d->price,
                'quantity'=> $d->quantity,
                'id' => $d->product_id,
            ]);

            $cont++;
        }

        

        //dd($this->carrito_venta);




    }


    public function render()
    {
        $asd = "asd";

        return view('livewire.sales.saleedit', [
            'listaventas' => $asd,
            'carteras' => $this->listarcarteras(),
            'carterasg' => $this->listarcarterasg(),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
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
}
