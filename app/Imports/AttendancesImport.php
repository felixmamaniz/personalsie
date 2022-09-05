<?php

namespace App\Imports;

use App\Models\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendancesImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public $col,$entrada,$salida;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        //dd($rows);
        //separamos entra y salida en otros collection
        $this->entrada=collect([]);
        foreach ($rows as $row){
            
            if($row['estado_de_trabajo'] == "Entrada")
            {
                //$this->val=dupli($rows);
                $this->entrada->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => $row['tiempo'], 'entrada' =>substr( $row['tiempo'], 11, 9)]);
                /*if($row['nombre']=="Crismar")
                {dd($this->col);}*/
                
            }
        }

        //dd($this->entrada);
        $this->salida=collect([]);
        foreach ($rows as $row){
            
            if($row['estado_de_trabajo'] == "Salida")
            {
                $this->salida->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => $row['tiempo'], 'salida' =>substr($row['tiempo'],11,9)]);
                /*if($row['nombre']=="Crismar")
                {dd($this->col);}*/
                
            }
        }
        //dd($this->salida);
        //unir la entrada y salida en uno solo
        $this->empleado=collect([]);
        foreach ($this->entrada as $row){

                $sal=$this->salida->where('id',$row['id'])->first();
                if($sal==null)
                {
                    $aux=null;
                }
                else{
                    $aux=$sal['salida'];
                }
                
                //dd($aux);
                
                    $this->empleado->push(['id' => $row['id'], 'name' => $row['name'], 'fecha' => $row['fecha'], 'salida' =>$row['entrada'], 'entrada' =>$aux]);
                //dd($this->empleado);
                if($row['name'] == 'Gery' )
                {
                   // dd($this->empleado);
                }
                
                    /*if($row['nombre']=="Crismar")
                {dd($this->col);}*/
        }


        dd($this->empleado);

        
        //dd($salida);
        $entrada=[];
        $i=0;
        
        foreach ($rows as $row) 
        {

            Attendance::create([
                'id' =>$row['id'],
                'fecha' =>$row['fecha'],
                'entrada' =>$row['entrada'],
                'salida' =>$row['salida'],
                'employee_id' =>$row['idempleado'],
            ]);
        }
    }
    public function dupli($rows){
        return ;
    }
   /* public function model(array $row)
    {
        //dd($row);
        $this->col=collect([]);
        $this->col->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => $row['tiempo'], 'estado' => $row['estado_de_trabajo']]);
        
        
        //$this->col->push(['product_id'=> $id->id,'product-name'=>$id->nombre,'costo'=>$this->costo,'cantidad'=>$this->cantidad]);
        
        
        //dd($this->col);
        return $this->col;
        // return new Attendance([
        // //agregar atributos
        //     'id' =>$row['id'],
        //     'fecha' =>$row['fecha'],
        //     'entrada' =>$row['entrada'],
        //     'salida' =>$row['salida'],
        //     'employee_id' =>$row['idempleado'],
        // ]);
        //dd($row);
    }*/
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
