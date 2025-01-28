<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionsExport implements FromCollection, WithHeadings
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return Question::all($this->fields);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Identificação',
            'Questão',
            'Memoria descritiva',
            'Escalao_id',
            'Tatami_id',
        ];
    }
}
