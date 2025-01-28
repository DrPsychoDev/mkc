<?php

namespace App\Imports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;

class ParticipantsImport implements ToModel
{
    /**
     * Mapeia cada linha do Excel para o modelo.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Ignore o cabeçalho se for a primeira linha (ajustar conforme necessidade)
        if ($row[0] === 'ID' || $row[1] === 'Nome'|| $row[0] === 'id' || $row[1] === 'name') {
            return null;
        }

        return new Participant([
            'name' => $row[1], // Nome
            'birthday' => $row[2],
            'school_id' => $row[3],
            'division_id' => $row[4],
        ]);
    }
}

