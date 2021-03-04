<?php

namespace App\Imports;

use App\DataNilaiUNSMA;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataNilaiUNSMAImport implements ToModel, WithHeadingRow
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
        return new DataNilaiUNSMA([
          'nomor_pendaftaran' => $row['nomor_pendaftaran'],
          'semester' => $row['semester'],
          'kode_mata_pelajaran' => $row['kode_mata_pelajaran'],
          'tingkat' => $row['tingkat'],
          'nilai_skala_4' => $row['nilai_skala_4'],
          'nilai_skala_100' => $row['nilai_skala_100'],
          'tahun_kur' => $row['tahun_kur'],
          'basis' => $row['basis'],
          'unit' => $row['unit'],
          'kkm' => $row['kkm'],
          'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
