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
    public $col,$entrada,$salida,$empleado;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    //
    public function collection(Collection $rows)
    {
        /*$unique = $rows->unique(function ($item) {
            return $item['id_de_usuario'].$item['nombre'];
        });
        dump($unique);*/
        //dd($rows);
        //separamos entra y salida en otros collection  
        $this->empleado=collect([]);
        foreach ($rows as $row){
            if($row['estado_de_trabajo'] == "Entrada" )
            {
                //agregamos los datos
                $this->empleado->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => substr($row['tiempo'],0,10), 'entrada' =>substr( $row['tiempo'], 11, 9), 'salida' => null]);
                
            }

            
            if($row['estado_de_trabajo']=="Salida")
            {
                $this->empleado->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => substr($row['tiempo'],0,10), 'entrada' => null, 'salida' =>substr( $row['tiempo'], 11, 9)]);
            }
        }
        //dd($this->empleado);

        $this->entrada=collect([]);
        //nuevo registro donde si tengo una entrada busco si tiene una salida y si no marco no tiene salida
        //si no tiene una entrar y solo salida la dejo como no tiene entrada
        //si tengo una persona que tiene 2 entradas y salidas por dia guardarlas juntos
        foreach ($this->empleado as $row){
            
            $sal=$this->empleado->where('fecha',$row['fecha'] and 'salida','==',null)->first();
            dd($sal);

            if($row['estado_de_trabajo'] == "Entrada" )
            {
                $sal=$rows->where(substr('tiempo',0,10),substr($row['tiempo'],0,10) && 'estado_de_trabajo','==','Salida')->first();
                $sal->all();
                dd($sal);
                //agregamos los datos
                $this->entrada->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => substr($row['tiempo'],0,10), 'entrada' =>substr( $row['tiempo'], 11, 9), 'salida' => 'null']);
                
            }

            
            if($row['estado_de_trabajo']=="Salida")
            {
                $this->entrada->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => substr($row['tiempo'],0,10), 'entrada' => 'null', 'salida' =>substr( $row['tiempo'], 11, 9)]);
            }
        }
        dd($this->entrada);
        //$unique = $this->entrada->unique('id');
        $unique = $this->entrada->unique(function ($item) {
            return $item['id'].$item['fecha'];
        });
         
        $unique->values()->all(); 
        //dump($unique);
        //dd($this->entrada);
 
// [2 => 'a', 4 => 'b']
        
        $this->salida=collect([]);
        foreach ($rows as $row){
            
            if($row['estado_de_trabajo'] == "Salida")
            {
                $this->salida->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' =>substr($row['tiempo'],0,10), 'salida' =>substr($row['tiempo'],11,9)]);
                
            }
        }

        $unique2 = $this->salida->unique(function ($item) {
            return $item['id'].$item['fecha'];
        });
         
        $unique2->values()->all(); 
        dump($unique2);
        dd($this->salida);
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
