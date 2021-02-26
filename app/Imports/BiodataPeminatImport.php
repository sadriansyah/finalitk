<?php

namespace App\Imports;

use App\BiodataPeminat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class BiodataPeminatImport implements ToModel, WithStartRow
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
        return new BiodataPeminat([
          'nik' => $row[1],
          'nisn' => $row[2],

          'kode_peserta' => $row[3],
          'nama_peserta' => $row[4],
          'jk' => $row[5],
          'bidikmisi' => $row[6],
          'kode_ptn_terima' => $row[7],
          'nama_ptn_terima' => $row[8],

          'kode_prodi_terima' => $row[9],
          'nama_prodi_terima' => $row[10],

          'pil_terima' => $row[11],
          'nilai_terima' => $row[12],

          'alamat' => $row[13],
          'telepon' => $row[14],
          'email' => $row[15],
          'agama' => $row[16],
          'nama_ayah' => $row[17],
          'pendidikan_ayah' => $row[18],
          'pekerjaan_ayah' => $row[19],
          'penghasilan_ayah' => $row[20],
          'nama_ibu' => $row[21],
          'pendidikan_ibu' => $row[22],
          'pekerjaan_ibu' => $row[23],
          'penghasilan_ibu' => $row[24],
          'jumlah_kakak' => $row[25],
          'jumlah_adik' => $row[26],

          'kode_ptn_pil1' => $row[27],
          'nama_ptn_pil1' => $row[28],
          'kode_prodi_pil1' => $row[29],
          'nama_prodi_pil1' => $row[30],
          'nilai1' => $row[31],
          'kode_ptn_pil2' => $row[32],
          'nama_ptn_pil2' => $row[33],
          'kode_prodi_pil2' => $row[34],
          'nama_prodi_pil2' => $row[35],
          'nilai2' => $row[36],
          'tempat_lahir' => $row[37],
          'tgl_lahir' => $row[38],
          'npsn' => $row[39],
          'nama_slta' => $row[40],
          'kabupaten' => $row[41],
          'provinsi' => $row[42],
          'tahun_lulus' => $row[43],

          'jurusan_slta' => $row[44],
          'nilai_saintek_kimia_pil1' => $row[45],
          'nilai_saintek_matematika_saintek_pil1' => $row[46],
          'nilai_soshum_ekonomi_pil1' => $row[47],
          'nilai_soshum_geografi_pil1' => $row[48],
          'nilai_soshum_matematika_soshum_pil1' => $row[49],
          'nilai_soshum_sejarah_pil1' => $row[50],
          'nilai_soshum_sosiologi_pil1' => $row[51],
          'nilai_tps_kemampuan_kuantitatif_pil2' => $row[52],
          'nilai_tps_kemampuan_memahami_bacaan_dan_menulis_pil2' => $row[53],
          'nilai_tps_kemampuan_penalaran_umum_pil2' => $row[54],
          'nilai_tps_pengetahuan_dan_pemahaman_umum_pil2' => $row[55],
          'nilai_saintek_biologi_pil2' => $row[56],
          'nilai_saintek_fisika_pil2' => $row[57],
          'nilai_saintek_kimia_pil2' => $row[58],
          'nilai_saintek_matematika_saintek_pil2' => $row[59],
          'nilai_soshum_ekonomi_pil2' => $row[60],
          'nilai_soshum_geografi_pil2' => $row[61],
          'nilai_soshum_matematika_soshum_pil2' => $row[62],
          'nilai_soshum_sejarah_pil2' => $row[63],
          'nilai_soshum_sosiologi_pil2' => $row[64],

          'kode_tahun_akademik' => $this->kode_tahun_akademik,
        ]);
    }
}
