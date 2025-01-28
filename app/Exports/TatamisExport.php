<?php

namespace App\Exports;

use App\Models\Tatami;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TatamisExport implements FromCollection, WithHeadings
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return Tatami::all($this->fields);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Descrição'
        ];
    }
}
