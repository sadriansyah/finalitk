<?php

namespace App\Imports;

use App\TerimaPTN;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class TerimaPTNImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct($d)
    {
        $this->kode_tahun_akademik= $d;
        //dd($this->kode_tahun_akademik);
    }
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
            return new TerimaPTN([
                'kode_prodi' => $row[1],
                'nama_prodi' => $row[2],
                'kode_peserta' => $row[3],
                'nama_peserta' => $row[4],
                'bidikmisi' => $row[5],
                'kode_tahun_akademik' => $this->kode_tahun_akademik,
            ]);

    }
}
