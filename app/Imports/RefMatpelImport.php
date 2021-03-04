<?php

namespace App\Imports;

use App\RefMatpel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class RefMatpelImport implements ToModel, WithHeadingRow
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
        return new RefMatpel([
          'kode_mata_pelajaran' => $row['kode_mata_pelajaran'],
          'nama_mata_pelajaran' => $row['nama_mata_pelajaran'],
          'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
