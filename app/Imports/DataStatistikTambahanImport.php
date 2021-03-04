<?php

namespace App\Imports;

use App\DataStatistikTambahan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class DataStatistikTambahanImport implements ToModel, WithHeadingRow
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
        return new DataStatistikTambahan([

            'nomor_pendaftaran' => $row['nomor_pendaftaran'],

            'tingkat' => $row['tingkat'],
            'semester' => $row['semester'],
            'status_tambahan' => $row['status_tambahan'],
            'id_jurusan' => $row['id_jurusan'],
            'npsn_sekolah' => $row['npsn_sekolah'],
          
            'nisn_siswa' => $row['nisn_siswa'],
            'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
