<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefJurusan extends Model
{
  protected $table = 'ref_jurusan';
  protected $fillable = [
    'kode_tahun_akademik', 'id_jurusan', 'nama_jurusan'
  ];
}
