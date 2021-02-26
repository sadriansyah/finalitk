<?php

namespace App\Imports;

use App\KeketatanProdi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class KeketatanProdiImport implements ToModel, WithStartRow
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
        return new KeketatanProdi([
          'kode_prodi' => $row[1],
          'nama_prodi' => $row[2],
          'peminat' => $row[3],
          'terima' => $row[4],
          'keketatan' => $row[5],
          'peminat1' => $row[6],
          'persen_peminat1' => $row[7],
          'terima1' => $row[8],
          'persen_terima1' => $row[9],
          'peminat2' => $row[10],
          'persen_peminat2' => $row[11],
          'terima2' => $row[12],
          'persen_terima2' => $row[13],
          'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
