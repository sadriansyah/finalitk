<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiodataPeminat extends Model
{
    protected $table = 'biodata_peminat';
    protected $fillable = [
      'nik', 'nisn', 'kode_peserta', 'nama_peserta', 'jk', 'bidikmisi', 'kode_ptn_terima', 'nama_ptn_terima', 'kode_prodi_terima', 'nama_prodi_terima', 'pil_terima', 'nilai_terima', 'alamat', 'telepon', 'email' ,'agama', 'nama_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'nama_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'jumlah_kakak', 'jumlah_adik', 'kode_ptn_pil1','nama_ptn_pil1','kode_prodi_pil1','nama_prodi_pil1','nilai1', 'kode_ptn_pil2','nama_ptn_pil2','kode_prodi_pil2','nama_prodi_pil2','nilai2', 'tempat_lahir', 'nama_slta', 'kabupaten', 'provinsi', 'tahun_lulus', 'kode_tahun_akademik','tgl_lahir', 'npsn','jurusan_slta', 'nilai_saintek_kimia_pil1', 'nilai_saintek_matematika_saintek_pil1', 'nilai_soshum_ekonomi_pil1', 'nilai_soshum_geografi_pil1', 'nilai_soshum_matematika_soshum_pil1', 'nilai_soshum_sejarah_pil1', 'nilai_soshum_sosiologi_pil1', 'nilai_tps_kemampuan_kuantitatif_pil2', 'nilai_tps_kemampuan_memahami_bacaan_dan_menulis_pil2', 'nilai_tps_kemampuan_penalaran_umum_pil2', 'nilai_tps_pengetahuan_dan_pemahaman_umum_pil2', 'nilai_saintek_biologi_pil2', 'nilai_saintek_fisika_pil2', 'nilai_saintek_kimia_pil2', 'nilai_saintek_matematika_saintek_pil2', 'nilai_soshum_ekonomi_pil2', 'nilai_soshum_geografi_pil2', 'nilai_soshum_matematika_soshum_pil2', 'nilai_soshum_sejarah_pil2', 'nilai_soshum_sosiologi_pil2',
    ];
}
