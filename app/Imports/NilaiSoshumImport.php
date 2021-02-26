<?php

namespace App\Imports;

use App\NilaiSOSHUM;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class NilaiSoshumImport implements ToModel, WithStartRow
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
        return new NilaiSOSHUM([
          'nama_ptn' => $row[1],
          'jumlah' => $row[2],
          'rataan' => $row[3],
          's_baku' => $row[4],
          'cov' => $row[5],
          'min' => $row[6],
          'max' => $row[7],
          'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
