<?php

namespace App\Imports;

use App\DataPrestasi;
use Maatwebsite\Excel\Concerns\ToModel;

class DataPrestasiImport implements ToModel
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
    public function model(array $row)
    {
        return new DataPrestasi([
            'nomor_pendaftaran' => $row[0],
            'no_prestasi' => $row[1],
            'jenis_prestasi' => $row[2],
            'jenjang_prestasi' => $row[3],
            'file_sertifikat' => $row[4],
            'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
