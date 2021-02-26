<?php

namespace App\Imports;

use App\BiodataTerima;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class BiodataTerimaImport implements ToModel, WithStartRow
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
        return new BiodataTerima([
          'kode_peserta' => $row[1],
          'nama_peserta' => $row[2],
          'jk' => $row[3],
          'bidikmisi' => $row[4],
          'kode_prodi_terima' => $row[5],
          'nama_prodi_terima' => $row[6],
          'pil_prodi_terima' => $row[7],
          'alamat' => $row[8],
          'telepon' => $row[9],
          'agama' => $row[10],
          'nama_ayah' => $row[11],
          'pendidikan_ayah' => $row[12],
          'pekerjaan_ayah' => $row[13],
          'penghasilan_ayah' => $row[14],
          'nama_ibu' => $row[15],
          'pendidikan_ibu' => $row[16],
          'pekerjaan_ibu' => $row[17],
          'penghasilan_ibu' => $row[18],
          'jumlah_kakak' => $row[19],
          'jumlah_adik' => $row[20],
          'pil1' => $row[21],
          'pil2' => $row[22],
          'tempat_lahir' => $row[23],
          'tgl_lahir' => $row[24],
          'kode_slta' => $row[25],
          'nama_slta' => $row[26],
          'kabupaten' => $row[27],
          'provinsi' => $row[28],
          'tahun_lulus' => $row[29],
          'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
