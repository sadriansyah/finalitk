<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataNilaiUNSMK extends Model
{
  protected $table = 'data_nilai_un_smk';
  protected $fillable = [
      'nomor_pendaftaran', 'semester', 'kode_mata_pelajaran', 'nilai_skala_4', 'nilai_skala_100', 'tahun_kur', 'basis', 'unit', 'kkm','kode_tahun_akademik', 'tingkat',
  ];
}
