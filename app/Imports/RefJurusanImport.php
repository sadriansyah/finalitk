<?php

namespace App\Imports;

use App\RefJurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class RefJurusanImport implements ToModel, WithHeadingRow
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
        return new RefJurusan([
          'id_jurusan' => $row['id_jurusan'],
          'nama_jurusan' => $row['nama_jurusan'],
          'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
