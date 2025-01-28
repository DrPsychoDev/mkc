<?php

namespace App\Imports;

use App\Models\Tatami;
use Maatwebsite\Excel\Concerns\ToModel;

class TatamisImport implements ToModel
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

        return new Tatami([
            'name' => $row[1], // Nome
            'description' => $row[2], // Nome
        ]);
    }
}

