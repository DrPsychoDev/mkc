<?php

namespace App\Exports;

use App\Models\Participant;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ParticipantsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return Participant::all($this->fields);
    }

    public function headings(): array
    {
        return ['ID','Nome','Aniversario','Dojo_id','Escalao_id',
];
    }

    public function map($participant): array
    {
        return [
            $participant->id,
            $participant->name,
            $participant->birthday,
            $participant->school_id,
            $participant->division_id,
        ];
    }

//    public function drawings()
//    {
//        $judges = Judge::all();
//        $drawings = [];
//
//        foreach ($judges as $index => $judge) {
//            if ($judge->photo) {
//                $drawing = new Drawing();
//                $drawing->setName('Foto');
//                $drawing->setDescription('Foto do Participante');
////                $drawing->setPath('storage/' . public_path( $judge->photo));
//                $drawing->setPath(storage_path('app/public/' . $judge->photo)); // Caminho absoluto da imagem
//                $drawing->setHeight(50); // Define a altura da imagem
//                $drawing->setCoordinates('B' . ($index + 2)); // Define a célula onde a imagem será inserida
//                $drawings[] = $drawing;
//            }
//        }
//
//        return $drawings;
//    }
}
