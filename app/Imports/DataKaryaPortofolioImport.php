<?php

namespace App\Imports;

use App\DataKaryaPortofolio;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;

class DataKaryaPortofolioImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;
    public function __construct($d)
    {
        $this->kode_tahun_akademik= $d;
        //dd($this->kode_tahun_akademik);
    }
    public function model(array $row)
    {
        //dd($row);
        return new DataKaryaPortofolio([
            'nomor_pendaftaran' => $row['nomor_pendaftaran'],
            'id_portofolio' => $row['id_portofolio'],
            'id_karya_portofolio' => $row['id_karya_portofolio'],
            'file_karya' => $row['file_karya'],
            'judul_karya' => $row['judul_karya'],
            'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
