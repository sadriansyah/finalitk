<?php

namespace App\Imports;

use App\KeketatanSoshum;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class KeketatanSoshumImport implements ToModel, WithStartRow
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
        return 3;
    }
    public function model(array $row)
    {
        return new KeketatanSoshum([
          'kode' => $row[1],
          'ptn' => $row[2],
          'pil1' => $row[3],
          'pil2' => $row[4],
          'pil3' => $row[5],
          'jumlah' => $row[6],
          'terima' => $row[7],
          'keketatan' => $row[8],
          'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
