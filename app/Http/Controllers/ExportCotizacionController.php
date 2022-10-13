<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\Cartera;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Company;
use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExportCotizacionController extends Controller
{
    public function crear()
    {
        //Variables para la tbody
        //$totalesIngresosV = session('totalIngresosV');

        $asd = "asd";
        

        $pdf = PDF::loadView('livewire.pdf.serviciocotizacion',
        compact('asd'));



        return $pdf->stream('Cotizacion.pdf'); 
    }
}
