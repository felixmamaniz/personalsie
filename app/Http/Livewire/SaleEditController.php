<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Destino;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Sucursal;
use App\Models\User;
use Facade\FlareClient\Http\Client;
use Livewire\Component;
use Livewire\WithPagination;

class SaleEditController extends Component
{
    //Guarda el id de la venta a editar
    public $venta_id;
    //Guarda true o false si dependiendo si se activa la venta con un cliente anónimo
    public $clienteanonimo;
    //Guarda true o false si dependiendo si se activa la venta con factura
    public $factura;
    //Guarda el id de la cartera que sera usada para la venta
    public $cartera_id;
    //Guarda el total de artículos para la venta
    public $total_items;
    //Guarda el total Bs de una venta
    public $total_bs;
    //Guarda las palabras usadas para buscar productos para la venta
    public $buscarproducto;
    //Guarda el nombre del cliente con el que se registrará la venta
    public $nombrecliente;
    //Guarda las monedas para ser usadas al finalizar la venta
    public $denominations;
    //Guarda el total descuento o recargo de la venta
    public $descuento_recargo;
    //Guarda la observacion que tendrá la venta
    public $observacion;
    //Guarda el mensaje que se quiera mandar en pantalla
    public $message;
    //Guarda el id de un producto
    public $producto_id;
    //Guarda el nombre de un producto
    public $nombreproducto;
    //Guarda el nombre de una sucursal
    public $nombresucursal;
    //Guarda true o false para dependiendo del resultado mostrar la venta modal finalizar venta
    public $stock_disponible;
    //Guarda todos los destinos disponibles y su stock de un determinado producto
    public $listadestinos;
    // Para guardar una lista de todas  las sucursales
    public $listasucursales;
    //Variable para Buscar por el Nombre a los Clientes
    public $buscarcliente;
    //Guarda el id de un cliente
    public $cliente_id;
    //Variables para crear un cliente
    public $cliente_ci, $cliente_celular;
    //Numero de filas que tendrá la lista de productos encontrados (paginacion)
    public $paginacion;
    //Carrito de Ventas
    public $carrito_venta;
    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        //Obteniendo el id de la venta por la variable de sesión
        $this->venta_id = session('venta_id');
        //Obteniendo detalles generales de la venta
        $venta = Sale::join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm","cm.movimiento_id","m.id")
        ->select("cm.cliente_id as idcliente","sales.factura as factura","sales.cartera_id as cartera_id",
        "sales.observacion as observacion","sales.total as totalbs")
        ->where("sales.id",$this->venta_id)
        ->get()
        ->first();
        //Verificando si la venta se hizo con un cliente anónimo
        $cliente = Cliente::where("clientes.id", $venta->idcliente)
        ->where("clientes.nombre", "Cliente Anónimo")
        ->get();
        //Si la venta se hizo con un cliente anónimo actualizamos la variable $this->clienteanonimo
        if($cliente->count() > 0)
        {
            $this->clienteanonimo = true;
        }
        else
        {
            $this->clienteanonimo = false;
        }
        //Obteniendo el nombre del cliente con el que se registro la venta
        $this->nombrecliente = Cliente::find($venta->idcliente)->nombre;
        //Si la venta se hizo con factura actualizamos la variable $this->factura
        if($venta->factura == "Si")
        {
            $this->factura = true;
        }
        else
        {
            $this->factura = false;
        }
        //Obteniendo el id de la cartera
        $this->cartera_id = $venta->cartera_id;
        //Obteniendo la observacion de la venta
        $this->observacion = $venta->observacion;
        //Creando el carrito de venta en una colección
        $this->carrito_venta = collect([]);
        //Obteniendo detalles de los productos de la venta
        $detalle = SaleDetail::join("products as p","p.id", "sale_details.product_id")
        ->where("sale_details.sale_id", $this->venta_id)
        ->select("p.nombre as name_product","sale_details.price as price","sale_details.quantity as quantity","sale_details.product_id as product_id")
        ->get();
        //Creando un contador que cumplira la función de ordenar los productos del carrito de ventas
        $cont = 1;
        foreach($detalle as $d)
        {
            //Llenando la coleccion con los productos de la venta
            $this->carrito_venta->push([
                'order' => $cont,
                'product_id' => $d->product_id,
                'name' => $d->name_product,
                'price' => $d->price,
                'quantity'=> $d->quantity,
                'id' => $d->product_id,
            ]);
            $cont++;
        }
        //Poniendo la variable a true por defecto
        $this->stock_disponible = true;
        $this->listasucursales = [];
        $this->paginacion = 10;
    }
    public function render()
    {
        //Variable para guardar todos los productos encontrados que contengan el nombre o código en $buscarproducto
        $listaproductos = [];
        if($this->buscarproducto != "")
        {
            $listaproductos = Product::join("productos_destinos as pd", "pd.product_id", "products.id")
            ->join('destinos as des', 'des.id', 'pd.destino_id')
            ->select("products.id as id","products.nombre as nombre", "products.image as image", "products.precio_venta as precio_venta",
            "pd.stock as stock", "products.codigo as barcode")
            ->where('products.nombre', 'like', '%' . $this->buscarproducto . '%')
            ->orWhere('products.codigo', 'like', '%' . $this->buscarproducto . '%')
            ->groupBy('products.id')
            ->paginate($this->paginacion);
        }




        //Lista a todos los clientes que tengan el nombre de la variable $this->buscarcliente
        $listaclientes = [];
        if(strlen($this->buscarcliente) > 0)
        {
            $listaclientes = Cliente::select("clientes.*")
            ->where('clientes.nombre', 'like', '%' . $this->buscarcliente . '%')
            ->orderBy("clientes.created_at","desc")
            ->get();
        }


        
        //Actualiza el total items del carrito de ventas
        $this->total_items = $this->totalarticulos();

        //Obteniendo el total Bs de una venta
        $this->total_bs = $this->totalbs();

        return view('livewire.sales_edit.saleedit', [
            'listaproductos' => $listaproductos,
            'carteras' => $this->listarcarteras(),
            'carterasg' => $this->listarcarterasg(),
            'listaclientes' => $listaclientes,
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
    //Obtiene el total artículos de la coleccion carrito de ventas
    public function totalarticulos()
    {
        $contador = 0;
        foreach($this->carrito_venta as $c)
        {
            $contador = $contador + $c['quantity'];
        }
        return $contador;
    }
    //Obtiene el total Bs de de la coleccion carrito de ventas
    public function totalbs()
    {
        $contador = 0;
        foreach($this->carrito_venta as $c)
        {
            $contador = $contador + ($c['quantity'] * $c['price']);
        }
        return $contador;  
    }
    //Decrementa en una unidad un producto del carrito de ventas
    public function decrease($idproducto)
    {
        //Buscando y guardando el elemento en la colección
        $p = $this->carrito_venta->where('product_id', $idproducto)->first();
        //Calculando la nueva cantidad del producto
        $cantidad_nueva = $p['quantity'] - 1;

        if($cantidad_nueva > 0)
        {
            //Buscamos el elemento en la colección
            $result = $this->carrito_venta->where('product_id', $idproducto);
            //Eliminando la fila del elemento en la coleccion
            $this->carrito_venta->pull($result->keys()->first());
            //Insertando otra vez el producto con la cantidad actualizada
            $this->carrito_venta->push([
                'order' => $p['order'],
                'product_id' => $p['product_id'],
                'name' => $p['name'],
                'price' => $p['price'],
                'quantity'=> $cantidad_nueva,
                'id' => $p['id'],
            ]);
            //Actualizando la variable $this->message
            $this->message = "Cantidad Decrementada";
        }
        else
        {
            //Buscamos el elemento en la colección
            $result = $this->carrito_venta->where('product_id', $idproducto);
            //Eliminando la fila del elemento en la coleccion
            $this->carrito_venta->pull($result->keys()->first());
            //Actualizando la variable $this->message
            $this->message = "Producto Eliminado por que la cantidad a vender llego a 0";
        }
        //Mostrando mensaje toast
        $this->emit("message-ok");
    }
    //Incrementa en una unidad un producto ya existente del carrito de ventas
    public function increase($idproducto)
    {
        //Buscando y guardando el elemento en la colección
        $p = $this->carrito_venta->where('product_id', $idproducto)->first();
        //Calculando la nueva cantidad del producto
        $cantidad_nueva = $p['quantity'] + 1;

        if($this->stocktienda($idproducto,$cantidad_nueva))
        {
            //Buscamos el elemento en la colección
            $result = $this->carrito_venta->where('product_id', $idproducto);
            //Eliminando la fila del elemento en la coleccion
            $this->carrito_venta->pull($result->keys()->first());
            //Insertando otra vez el producto con la cantidad actualizada
            $this->carrito_venta->push([
                'order' => $p['order'],
                'product_id' => $p['product_id'],
                'name' => $p['name'],
                'price' => $p['price'],
                'quantity'=> $cantidad_nueva,
                'id' => $p['id'],
            ]);
            //Actualizando la variable $this->message
            $this->message = "Cantidad Incrementada";
            //Mostrando mensaje toast
            $this->emit("message-ok");
        }
        else
        {
            $this->modalstockinsuficiente($idproducto);
        }

    }
    //Inserta un producto no existente en el carrito de ventas
    public function insert($idproducto)
    {
        //Buscando el producto en el carrito de ventas
        $p = $this->carrito_venta->where('product_id', $idproducto);

        if($p->count() > 0)
        {
            $this->increase($idproducto);
        }
        else
        {
            if($this->stocktienda($idproducto,1))
            {
                $producto = Product::find($idproducto);
                //Insertando el producto
                $this->carrito_venta->push([
                    'order' => 10,
                    'product_id' => $producto->id,
                    'name' => $producto->nombre,
                    'price' => $producto->precio_venta,
                    'quantity'=> 1,
                    'id' => $producto->id,
                ]);
                //Actualizando la variable $this->message
                $this->message = "¡Producto: " . $producto->nombre . " insertado exitósamente!";
                //Mostrando mensaje toast
                $this->emit("message-ok");
            }
            else
            {
                $this->modalstockinsuficiente($idproducto);
            }
        }
    }
    //Para verificar que quede stock disponible en la TIENDA para la venta
    public function stocktienda($idproducto, $cantidad)
    {
        //Buscando stock dispnible del producto en el destino TIENDA
        $producto = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
        ->join("products as p", "p.id", "pd.product_id")
        ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
        ->where("destinos.sucursal_id", $this->idsucursal())
        ->where('destinos.nombre', 'TIENDA')
        ->where('pd.product_id', $idproducto)
        ->where('p.status', 'ACTIVO')
        ->where('pd.stock','>=', $cantidad)
        ->get();


        if($producto->count() > 0)
        {
            //Variable donde se guardará el stock del producto del Carrito de Ventas
            $stock_cart = 0;
            //Para saber si el Producto ya esta en el carrrito
            $p = $this->carrito_venta->where('product_id', $idproducto);
            //Si el producto existe en el Carrito de Ventas actualizamos la variable $stock_cart
            if($p->count() > 0)
            {
                $stock_cart = $p->first()['quantity'];
            }
            //Restamos el stock de la tienda con el stock del Carrito de Ventas
            $stock = $producto->first()->stock - $stock_cart;
            if($stock > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        
    }
    //Método para mostrar una ventana modal cuando no hay stock en Tienda de un producto
    public function modalstockinsuficiente($idproducto)
    {
        //Actualizando la variable $this->producto_id
        $this->producto_id = $idproducto;
        //Cambiando la variable $this->stock_disponible a false para que no se pueda mostrar la ventana modal finalizar venta
        $this->stock_disponible = false;
        //Buscamos stock disponible del producto en toda la sucursal menos en el destino TIENDA
        //Y actualizando la variable $this->listadestinos para guardar todos los destinos
        //de la sucursal (Menos Tienda) en los que existan stocks disponibles
        $this->listadestinos = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
        ->join("products as p", "p.id", "pd.product_id")
        ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
        ->where("destinos.sucursal_id", $this->idsucursal())
        ->where('destinos.nombre', '<>' ,'TIENDA')
        ->where('pd.product_id', $this->producto_id)
        ->where('p.status', 'ACTIVO')
        ->get();

        //Guardando el nombre del producto con 0 stock en tienda
        $this->nombreproducto = Product::find($idproducto)->nombre;
        $this->nombresucursal = Sucursal::find($this->idsucursal())->name;

        
        // Lista todas las sucursales menos la sucursal en la que esta el usuario
        $this->listasucursales = Sucursal::select("sucursals.*")
        ->where('sucursals.id', '<>' , $this->idsucursal())
        ->get();

        //Mostrando la ventana modal
        $this->emit('show-stockinsuficiente');
    }
    //Devuelve nombredestino y stock de una sucursal
    public function buscarstocksucursal($idsucursal)
    {
        $destinos = Destino::join("productos_destinos as pd", "pd.destino_id", "destinos.id")
                ->join("products as p", "p.id", "pd.product_id")
                ->select("destinos.id as id","destinos.nombre as nombredestino","pd.product_id as idproducto","pd.stock as stock")
                ->where("destinos.sucursal_id", $idsucursal)
                ->where('pd.product_id', $this->producto_id)
                ->where('p.status', 'ACTIVO')
                ->where('pd.stock','>', 0)
                ->get();
        return $destinos;
    }
    //Cierra la ventana modal Buscar Cliente y Cambia el id de la variable $cliente_id
    public function seleccionarcliente($idcliente)
    {
        $this->cliente_id = $idcliente;
        $this->nombrecliente = Cliente::find($idcliente)->nombre;
        $this->buscarcliente = "";
        $this->message = "Se seleccionó al cliente: '" . ucwords(strtolower($this->nombrecliente)) . "' para esta venta";
        $this->emit('hide-buscarcliente');
    }
    //Cierra la ventana modal Buscar Cliente y Cambia el id de la variable $cliente_id con un cliente Creado
    public function crearcliente()
    {
        if($this->cliente_celular == null)
        {
            $newclient = Cliente::create([
                'nombre' => $this->buscarcliente,
                'cedula' => $this->cliente_ci,
                'celular' => 0,
                'procedencia_cliente_id' => 1,
            ]);
        }
        else
        {
            $newclient = Cliente::create([
                'nombre' => $this->buscarcliente,
                'cedula' => $this->cliente_ci,
                'celular' => $this->cliente_celular,
                'procedencia_cliente_id' => 1,
        ]);
        }
        
        $this->cliente_id = $newclient->id;
        $this->nombrecliente = $newclient->nombre;
        $this->message = "Se selecciono al cliente creado: '" . $newclient->nombre . "'";
        //Ocultando ventana modal
        $this->emit('hide-buscarcliente');
    }
    //Poner la variable $clienteanonimo en true o false dependiendo el caso
    public function clienteanonimo()
    {
        if($this->clienteanonimo)
        {
            $this->clienteanonimo = false;
            $this->message = "Por favor cree o seleccione a un cliente, si no lo hace, se usará a un cliente anónimo";
            $this->emit('clienteanonimo-false');
        }
        else
        {
            $this->clienteanonimo = true;
            $this->cliente_id = $this->clienteanonimo_id();
            $this->message = "Se usará a un Cliente Anónimo para esta venta";
            $this->emit('clienteanonimo-true');
        }
    }
    //Método para guardar SI o NO en la variable $invoice para saber si una venta es con factura
    public function facturasino()
    {
        if($this->factura)
        {
            $this->invoice = "No";
            $this->factura = false;
            $this->message = "Venta con factura desactivada";
            $this->emit('message-ok');
        }
        else
        {
            $this->invoice = "Si";
            $this->factura = true;
            $this->message = "Venta con factura activada";
            $this->emit('message-ok');
        }
    }
    //Escucha los eventos JavaScript de la vista (saleedit.blade.php)
    protected $listeners = [
        'scan-code' => 'ScanCode',
        'clear-Cart' => 'clearcart',
        'clear-product' => 'clearproduct',
        'save-sale' => 'savesale'
    ];
    //Eilimina un producto de la colección carrito de ventas
    public function clearproduct($idproducto)
    {
        //Buscamos el elemento en la colección
        $result = $this->carrito_venta->where('product_id', $idproducto);
        //Eliminando la fila del elemento en la coleccion
        $this->carrito_venta->pull($result->keys()->first());

        $nombre_producto = Product::find($idproducto)->nombre;

        //Actualizando la variable $this->message
        $this->message = "Eliminado: '" . $nombre_producto . "'";
        //Mostrando mensaje toast
        $this->emit("message-ok");

    }
    //Vaciar todos los Items en el Carrito
    public function clearcart()
    {
        $this->carrito_venta = collect([]);
        $this->emit('cart-clear');
    }
}
