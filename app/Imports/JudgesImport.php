<?php

namespace App\Imports;

use App\Models\Judge;
use Maatwebsite\Excel\Concerns\ToModel;

class JudgesImport implements ToModel
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

        return new Judge([
            'name' => $row[1], // Nome
            'school_id' => $row[2],
            'tatami_id' => $row[3],
            'is_substitute' => $row[4],
            'email' => $row[5],
            'password' => $row[6],
        ]);
    }
}

