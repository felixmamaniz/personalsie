<?php

namespace App\Imports;

use App\Models\TipoContrato;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TipoContratoImport implements ToModel, WithHeadingRow, WithValidation
{
    private $numRows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        ++$this->numRows;
            return new TipoContrato([
                'name' => $row['name'],
                'image' => $row['image']
            ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:45',
            'image' => 'required|image'
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
