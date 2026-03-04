<?php

namespace App\Imports;

use App\Komponen;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KomponenImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Komponen([
            'kode'              => $row[1],
            'komponen'          => $row[2],
            'tipe'              => $row[3],
            'tipe_penghitungan' => $row[4],
            'nilai'             => $row[5],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
