<?php

foreach($cek as $c){
  $total = 0;
  foreach ($rataNilai as $key ) {
    if($c->nomor_pendaftaran== $key->nomor_pendaftaran){
      if($key->kode_mata_pelajaran=='MAT'){
        $nilai = $key->total*$bobotX3/100;
        $total +=$nilai;
        $fil['MAT'] = $key->total;

      }
      elseif ($key->kode_mata_pelajaran=="IND") {
        $nilai = $key->total*$bobotX1/100;
        $total +=$nilai;
        $fil['IND'] = $key->total;
      }
      elseif ($key->kode_mata_pelajaran=="ING") {
        $nilai = $key->total*$bobotX2/100;
        $total +=$nilai;
        $fil['ING'] = $key->total;
      }
    }
  }
  $fil['total'] = $total;
  $fil['nomor_pendaftaran'] = $c->nomor_pendaftaran;
  $fil['nik'] = $c->nik;
  $fil['kip_kks'] = $c->kip_kks;
  $fil['nama_provinsi'] = $c->nama_provinsi;
  $fil['nisn'] = $c->nisn;
  $fil['npsn'] = $c->npsn_sekolah;
  $fil['nama_sekolah'] = $c->nama_sekolah;
  $fil['kota_sekolah'] = $c->nama_kabupaten;
  $fil['kode_jurusan'] = $c->kode_jurusan;
  $fil['nama_siswa'] = $c->nama_siswa;
  $fil['urutan_ptn'] = $c->urutan_ptn;
  $fil['kode_program_studi']=$c->kode_program_studi;
  $fil['urutan_program_studi'] = $c->urutan_program_studi;
  $fil['program_studi'] = $c->program_studi;
  array_push($arr,$fil);
}

<th >No</th>
<th >Opsi</th>
<th >Nomor Pendaftaran</th>
<th >Nama</th>
<th >Pilihan 1</th>
<th >Pilihan 2</th>
<th >Jurusan</th>
<th >Nama Sekolah</th>
<th >Kabupaten</th>
<th >Provinsi</th>
<th >Kip KKS</th>
<th >MAT</th>
<th >IND</th>
<th >ING</th>
<th >Total Nilai</th>
<th >pilihan prodi</th>
<th >pilihan ptn</th>
<th >Status</th>




 ?>
