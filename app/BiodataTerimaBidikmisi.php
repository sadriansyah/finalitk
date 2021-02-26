<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiodataTerimaBidikmisi extends Model
{
    protected $table = 'biodata_terima_bidikmisi';
    protected $fillable = [
      'kode_peserta', 'nama_peserta', 'jk', 'bidikmisi', 'kode_prodi_terima', 'nama_prodi_terima', 'pil_prodi_terima', 'alamat', 'telepon', 'agama', 'nama_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'nama_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'jumlah_kakak', 'jumlah_adik',
      'pil1', 'pil2', 'tempat_lahir', 'kode_slta', 'nama_slta', 'kabupaten', 'kabupaten', 'provinsi', 'tahun_lulus', 'kode_tahun_akademik','tgl_lahir',
      ];
}
