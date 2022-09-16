<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Exports\TechnicalExport;
use App\Imports\AttendancesImport;
use App\Models\Employee;
use App\Models\Attendance;
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
    //exportar en excel del area tecnica
    public function reporteExcelTecnico($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        $reportName = 'Reporte de Ventas_' . uniqid() . '.xlsx';
        return Excel::download(new TechnicalExport($userId, $reportType, $dateFrom, $dateTo),$reportName );
    }
    

    //mandar el archivo para importar desde un excel
    public function store(Request $request)
    {
        //en el $file tenemos el archivo excel para agregar todos los datos dentro del excel
        $file = $request->file('import_file');
        //redirecciona a import para agregar los datos
       $aux= Excel::import(new AttendancesImport, $file);
       //dd($aux);
        //retorna a la vista attendances con el back
        return redirect()->back();
                
    }
}
