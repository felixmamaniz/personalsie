<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;          // para trabajar con colecciones y obtener la data
use Maatwebsite\Excel\Concerns\WithHeadings;          //para definir los titulos de encabezado
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;       //para interactuar con el libro
use Maatwebsite\Excel\Concerns\WithCustomStartCell;     //para definir la celda donde inicia el reporte
use Maatwebsite\Excel\Concerns\WithTitle;               //para colocar el nombre a las hojas del libro
use Maatwebsite\Excel\Concerns\WithStyles;              //para dar formato a las celdas
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;              //para que funcionen los eventos enviados
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;    // el ancho de celdas
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;  //todos los eventos
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class TechnicalExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles, WithDefaultStyles, WithEvents, WithColumnWidths, WithDrawings, WithHeadingRow
{
    use  Exportable, RegistersEventListeners;
    protected $userId, $dateFrom, $dateTo, $reportType;
    public $cell;
    public $data2;
    
    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
    }


    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('assets/img/logo.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B1');

        return $drawing;
    }
    public function collection()
    {
        $data = [];
        //validar el tipo de reporte
        if($this->reportType == 1)
        {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        } else {
             //fecha de ahora 
             $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
             $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        }

        //validar si seleccionamos algun usuario
        if($this-> userId == 0){
            //consulta
            $data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha', 'e.name', 'attendances.entrada', 'attendances.salida')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->get();
        } else {
            $data = Attendance::join('employees as e','e.id','attendances.employee_id')
            ->select('attendances.fecha', 'e.name', 'attendances.entrada', 'attendances.salida')
            ->whereBetween('attendances.fecha', [$from,$to])
            ->where('employee_id', $this->userId)
            ->get();
        }
        //empleados
        $data2 = Employee::join('area_trabajos as at', 'at.id', 'employees.area_trabajo_id')
        ->select('employees.id', 'employees.name', 'at.name as area')
        ->where('at.id',2)
        ->get();
        //dd($data2);
        //dd($data);
        //retornar datos para el exel
        return $data2;
    }

    //CABECERAS DEL REPORTE
    public function headings(): array
    {
        
        
           

            return [
                 ["SOLUCIONES INFORMATICAS EMANUEL"],
                 ["PLANILLA DE SUELDOS Y SALARIOS PERSONAL TECNICO"],
                 ["MES DE AGOSTO"], //AGREGAR MES DE EMEISION
                 [""],
                 [""],
                ["N", "NOMBRE", "CARGO", "HORAS TRABAJADAS", "TOTAL GANADO", "DIAS TRABAJADOS", "TOTAL GANADO", "COMISIONES", "ADELANTOS", "DESCUENTO POR FALTAS Y LICENCIAS", "DESCUENTOS VARIOS", "TOTAL PAGADO"],
                
                20 => ["Total"]
            ];
        

        
    }
    public function headingRow(): int
    {
        return 3;
    }
    //el ancho de una cell
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 10,
            'D' => 10,
            'E' => 12,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'L' => 10,          
        ];
    }
    
    
    //Definiendo en que cel se imprimira el reporte
    public function startCell(): string
    {
        return 'A3';
    }

    //Estilos para el excel
    public function styles(Worksheet $sheet)
    {
        return [
            /*'A2' => ['font' => ['bold' => true, 'size' => 15,'color' => array('rgb' => 'blue')],
            /*'background' => [
                'color'=>  array('rgb' => 'red')
            ]
            ],*/
            3    => ['font' => ['bold' => true],
                    'size' => 12,],
            
        ];
        
    }

    //Titulo del Excel
    public function title(): string
    {
        return 'Reporte de Salarios Tecnico';
    }
    

    public function defaultStyles(Style $defaultStyle)
    {
        
    
        
    }
    
    public static function beforeSheet(BeforeSheet $event){
        $event->sheet->appendRows(array(
            array('test1', 'test2'),
            array('test3', 'test4'),
            //....
        ), $event);
    }

    public static function afterSheet(AfterSheet $event){
        $event->sheet->appendRows(array(
            array('test1', 'test2'),
            array('test3', 'test4'),
            //....
        ), $event);
    }
    //PINTAR CELDAS AL COLOR QUE QUERAMOS
    public function registerEvents(): array
    {
        
        
        //contar los resultados existentes para el bordeado del excel
        $Allemployee = Employee::join('area_trabajos as at', 'at.id', 'employees.area_trabajo_id')
        ->select('employees.id', 'employees.name', 'at.name as area')
        ->where('at.id',2)
        ->get()
        ->count();
           // dd($Allemployee);

            //dd($Allemployee);
            //estilos para el excel para todos
            $i=8;
            $this->cell='A'.$i.':L'.($Allemployee+8);
            $this->B='B8:B'.($Allemployee+8);
            $this->C='C8:C'.($Allemployee+8);
            $this->D='D8:D'.($Allemployee+8);
            $this->E='E8:E'.($Allemployee+8);
            $this->F='F8:F'.($Allemployee+8);
            //dd($this->B);
            //dd($cell);
            return [ 
                
                AfterSheet::class    => function(AfterSheet $event) {
                    Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                        $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                    });
                    $event->sheet->appendRows(array(
                        array('Total'),
                        
                        //....
                    ), $event);
                    /*$event->sheet->appendRows(1, array(
                        'prepended', 'prepended'
                    ));*/
                    //alto de las columnas
                    $event->sheet->getDelegate()->getRowDimension('8')->setRowHeight(40);
                    /*$event->sheet->setHeight(array(
                        1     =>  50
                    ));*/
                    //ajustar el texto al tamaño de la columna
                    //$event->sheet->getStyle('A6:B' . $event->sheet->getHighestRow())->getAlignment()->setWrapText(true);
                    $event->sheet->getStyle('A8:L8')->getAlignment()->setWrapText(true);
                     //centrear A3 hasta l3
                     $event->sheet->mergeCells('A3:l3');
                     $event->sheet->getDelegate()->getStyle('A3:l3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            //centrear A3 hasta l3
                     $event->sheet->mergeCells('A4:l4');
                     $event->sheet->getDelegate()->getStyle('A4:l4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            //centrear A3 hasta l3
                     $event->sheet->mergeCells('A5:l5');
                     $event->sheet->getDelegate()->getStyle('A5:l5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    
                            $event->sheet->getDelegate()->getStyle('A8:l8')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    //para el color de fondo de una celda o varias ejm:('A:C')
                    //PARA LAS FILAS PRINCIPALES DEL ENCABEZADO
                    
                  
                            
                            $event->sheet->styleCells(
                                $this->cell,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->B,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->D,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                $this->F,
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                            $event->sheet->styleCells(
                                'A8:l8',
                                [
                                    'borders' => [
                                        'outline' => [
                                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM
                                        ],
                                    ]
                                ]
                            );
                
                            $event->sheet->styleCells(
                                'A8:l8',
                                [
                                    'font' => [
                                        'name'      =>  'Calibri',
                                        'size'      =>  8,
                                        'bold'      =>  true,
                                        'color' => ['rgb' => 'black'],
                                    ],
                                ]
                            );
                            
    
                                
                    
                },
    
            ];
        
        
        

       
            
        
       
    }
}
