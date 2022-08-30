<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use Illuminate\Http\Request;

//importar para el excel
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //exportar en excel
    public function reporteExcel($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        $reportName = 'Reporte de Ventas_' . uniqid() . '.xlsx';
        return Excel::download(new AttendancesExport($userId, $reportType, $dateFrom, $dateTo),$reportName );
    }
}
