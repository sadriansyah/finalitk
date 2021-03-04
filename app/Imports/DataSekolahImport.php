<?php

namespace App\Imports;

use App\DataSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class DataSekolahImport implements ToModel, WithHeadingRow
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
        return new DataSekolah([
            'npsn' => $row['npsn'],

            'nama_sekolah' => $row['nama_sekolah'],
            'jenis_sekolah' => $row['jenis_sekolah'],
            'kode_kabupaten' => $row['kode_kabupaten'],
            'nama_kabupaten' => $row['nama_kabupaten'],
            'kode_provinsi' => $row['kode_provinsi'],
            'nama_provinsi' => $row['nama_provinsi'],
            'akreditasi_sekolah' => $row['akreditsi_sekolah'],
            'tanggal_kadaluarsa' => $row['tanggal_kadaluarsa'],
            'nilai_akreditasi' => $row['nilai_akreditasi'],
            'kepemilikan' => $row['kepemilikan'],
            'tanggal_mulai_akreditasi' => $row['tanggal_mulai_akreditasi'],
            'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
