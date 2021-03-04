<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefMatpel extends Model
{
  protected $table = 'ref_mata_pelajaran';
  protected $fillable = [
    'kode_tahun_akademik', 'kode_mata_pelajaran', 'nama_mata_pelajaran',
  ];
}
