<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\BobotNilai;
use App\DataPilihan;
use App\DayaTampung;
use App\ProdiITK;
class NASController extends Controller
{

    public function pilih(){
      if(!auth()->user()){
        return redirect('/');
      }
      $jurusan = DB::select("SELECT DISTINCT program_studi, kode_program_studi from data_pilihan");
      $tahun = DB::select("SELECT * from tahun_akademik");
      return view('layouts.pilihdatahasil',['jurusan' => $jurusan, 'tahun' => $tahun]);
    }

    function finalexport($kode_program_studi,$tahun){
      if(!auth()->user()){
        return redirect('/');
      }
      $data = DB::select("SELECT*FROM siswa_final WHERE kode_program_studi='$kode_program_studi' AND tahun_akademik='$tahun'");
      $prodi = ProdiITK::where('kode_prodi',$kode_program_studi)->first();
      $namaprodi = $prodi->nama_prodi;
      return view('hasil.exporthasil',['data' => $data, 'prodi' => $namaprodi]);
    }

    public function pilihfilter(Request $req){
      $programstudi = $req->program_studi;
      $urutan_ptn = $req->urutan_ptn;
      $urutan_program_studi = $req->urutan_program_studi;
      $tahun = $req->tahun_akademik;

      return redirect("/hasil/$programstudi/$urutan_ptn/$urutan_program_studi/$tahun");
    }
    function autohasil($kodeprodi,$tahun){
      $tempdata = DB::select("SELECT*FROM data_siswa,data_pilihan WHERE data_siswa.nomor_pendaftaran = data_pilihan.nomor_pendaftaran AND data_pilihan.kode_program_studi='$kodeprodi'");
      foreach($tempdata as $tempdata){
        $querycek = DB::select("SELECT*FROM siswa_final WHERE nomor_pendaftaran ='$tempdata->nomor_pendaftaran'");
        $cek = count($querycek);
        if($cek == 0){
          $insert =DB::select("INSERT INTO siswa_final VALUES('$tempdata->nomor_pendaftaran','$tempdata->kode_program_studi','$tempdata->kode_tahun_akademik',NOW(),NOW())");
        }
      }

    }
    public function coba($kodeprodi,  $tahun){
      $programstudi = $kodeprodi;
      $tahun = $tahun;

      $siswafinal = DB::select("SELECT*FROM siswa_final");

      $rataNilai = DB::select("SELECT nomor_pendaftaran,kode_mata_pelajaran, sum(nilai_skala_100)/5 AS total FROM data_nilai WHERE kode_mata_pelajaran='MAT' OR kode_mata_pelajaran='IND' OR kode_mata_pelajaran='ING' GROUP BY nomor_pendaftaran, kode_mata_pelajaran ");

      $kriteria = DB::select("SELECT DISTINCT data_siswa.nomor_pendaftaran, data_jurusan.nilai_akreditasi, ranking_akumulasi.percentile from data_siswa,data_jurusan,ranking_akumulasi WHERE data_siswa.id_jurusan = data_jurusan.id_jurusan AND data_siswa.nomor_pendaftaran = ranking_akumulasi.nomor_pendaftaran");
      $prestasi = DB::select("SELECT*FROM data_prestasi WHERE kode_tahun_akademik='$tahun'");
      $jurusan = DB::select("SELECT DISTINCT program_studi from data_pilihan WHERE kode_tahun_akademik='$tahun'");


      $cek = DB::select("SELECT DISTINCT data_siswa.nomor_pendaftaran,nama_siswa,data_pilihan.kode_program_studi,urutan_ptn,urutan_program_studi,program_studi, data_siswa.kode_tahun_akademik from data_siswa,data_pilihan WHERE data_siswa.nomor_pendaftaran = data_pilihan.nomor_pendaftaran AND data_siswa.kode_tahun_akademik LIKE '%$tahun%'");
      $arr=array();
      //bobotnilai
      $nilaikriteria = DB::select("SELECT*FROM kriteria_nilai WHERE tahun_akademik='$tahun'");
      foreach($nilaikriteria as $bobotnilai){
        if($bobotnilai->kriteria == "X1"){
          $bobotX1 = $bobotnilai->bobot;
        }elseif($bobotnilai->kriteria == "X2"){
          $bobotX2 = $bobotnilai->bobot;
        }
        elseif($bobotnilai->kriteria == "X3"){
          $bobotX3 = $bobotnilai->bobot;
        }
        elseif($bobotnilai->kriteria == "X6"){
          $bobotX6 = $bobotnilai->bobot;
        }
        elseif($bobotnilai->kriteria == "X9"){
          $bobotX9 = $bobotnilai->bobot;
        }
        elseif($bobotnilai->kriteria == "X11"){
          $bobotX11 = $bobotnilai->bobot;
        }
      }


      foreach($cek as $c){
        $total = 0;
        foreach ($rataNilai as $key ) {
          if($c->nomor_pendaftaran== $key->nomor_pendaftaran){
            if($key->kode_mata_pelajaran=='MAT'){
              $nilai = $key->total*$bobotX3/100;
              $total +=$nilai;
            }
            elseif ($key->kode_mata_pelajaran=="IND") {
              $nilai = $key->total*$bobotX1/100;
              $total +=$nilai;
            }
            elseif ($key->kode_mata_pelajaran=="ING") {
              $nilai = $key->total*$bobotX2/100;
              $total +=$nilai;
            }
          }
        }
        $fil['total'] = $total;
        $fil['nomor_pendaftaran'] = $c->nomor_pendaftaran;
        $fil['nama_siswa'] = $c->nama_siswa;
        $fil['urutan_ptn'] = $c->urutan_ptn;
        $fil['kode_program_studi']=$c->kode_program_studi;
        $fil['urutan_program_studi'] = $c->urutan_program_studi;
        $fil['program_studi'] = $c->program_studi;
        array_push($arr,$fil);
      }

      $akhir = array();
      foreach($kriteria as $kri){
        foreach($arr as $r){
          if($kri->nomor_pendaftaran == $r['nomor_pendaftaran']){
            if($kri->nilai_akreditasi=='-' || $kri->nilai_akreditasi==""){
              $akre = 50;
            }else {
              $akre = $kri->nilai_akreditasi;
            }
            $akumulasi = $akre*$kri->percentile*$bobotX11/100;
            $total = $r['total']+$akumulasi;
            $isi['nomor_pendaftaran']=$kri->nomor_pendaftaran;
            $isi['nama_siswa'] = $r['nama_siswa'];
            $isi['urutan_ptn'] = $r['urutan_ptn'];
            $isi['kode_program_studi']=$r['kode_program_studi'];
            $isi['urutan_program_studi'] = $r['urutan_program_studi'];
            $isi['program_studi'] = $r['program_studi'];
            $isi['total'] = $total;
            array_push($akhir,$isi);
          }
        }
      }
      $final = array();
      $nilai=0;
      foreach($akhir as $a){
        foreach($prestasi as $p){
          if($a['nomor_pendaftaran']==$p->nomor_pendaftaran){
            if($p->jenjang_prestasi == "Sekolah"){
              if($p->juara == 1){
                $nilai = 10;
              }elseif ($p->juara == 2) {
                $nilai = 5;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }

            }elseif ($p->jenjang_prestasi == "Kabupaten/Kodya") {
              if($p->juara == 1){
                $nilai = 25;
              }elseif ($p->juara == 2) {
                $nilai = 20;
              }elseif ($p->juara == 3) {
                $nilai = 15;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }

            }elseif ($p->jenjang_prestasi == "Propinsi") {
              if($p->juara == 1){
                $nilai = 50;
              }elseif ($p->juara == 2) {
                $nilai = 40;
              }elseif ($p->juara == 3) {
                $nilai = 30;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }
            }elseif ($p->jenjang_prestasi == "Nasional") {
              if($p->juara == 1){
                $nilai = 75;
              }elseif ($p->juara == 2) {
                $nilai = 65;
              }elseif ($p->juara == 3) {
                $nilai = 55;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }

            }elseif ($p->jenjang_prestasi == "Internasional") {
              if($p->juara == 1){
                $nilai = 100;
              }elseif ($p->juara == 2) {
                $nilai = 90;
              }elseif ($p->juara == 3) {
                $nilai = 80;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }
            }else {
              $nilai = 0;
            }
          }
          $total = $a['total'] + ($nilai*$bobotX6/100);

        }
        $isi['total'] = $total;
        $isi['nomor_pendaftaran'] = $a['nomor_pendaftaran'];
        $isi['nama_siswa'] = $a['nama_siswa'];
        $isi['urutan_ptn'] = $a['urutan_ptn'];
        $isi['kode_program_studi']=$a['kode_program_studi'];
        $isi['urutan_program_studi'] = $a['urutan_program_studi'];
        $isi['program_studi'] = $a['program_studi'];
        array_push($final,$isi);
      }
      //echo json_encode($final);

      $keys = array_column($final, 'total');
      array_multisort($keys, SORT_DESC, $final);



      // echo "<table>";
      // echo "<thead><th>NoPendaftaran</th><th>Total Nilai</th><th>Pilihan Prodi</th> <th> Pilihan PTN</th> </thead>";
      // echo "</tbody>";
      // foreach ($final as $f){
      //   echo "<tr><td>$f[nomor_pendaftaran]</td> <td>$f[total]</td> <td>$f[urutan_program_studi] </td> <td>$f[urutan_ptn] </td></tr>";
      // }
      // echo "</tbody></table>";

      $resetdata = DB::select("SELECT*FROM data_reset WHERE tahun_akademik='$tahun'");
      $cekreset = count($resetdata);
      if($cekreset == 0){
        //sorting pilihan ptn 1 prodi urutan 1
        foreach($final as $fin){
          $nopen = $fin['nomor_pendaftaran'];
          $kodprodi = $fin['kode_program_studi'];
          $urutan_ptn = $fin['urutan_ptn'];
          $urutan_program_studi = $fin['urutan_program_studi'];
          $dayatampungprodi = DB::select("SELECT*FROM daya_tampung WHERE kode_prodi ='$kodprodi'");
          foreach($dayatampungprodi as $dy){
            $kuotatampung = $dy->kapasitas;
          }

          $siswaterisi = DB::select("SELECT*FROM siswa_final WHERE kode_program_studi = '$kodprodi'");
          $totalterisi = count($siswaterisi);
          if($totalterisi < $kuotatampung){
            if($urutan_ptn == 1 && $urutan_program_studi == 1){
              $querycek = DB::select("SELECT*FROM siswa_final WHERE nomor_pendaftaran ='$nopen'");
              $cek = count($querycek);
              if($cek == 0){
                $insert =DB::select("INSERT INTO siswa_final VALUES('$nopen','$kodprodi','$tahun',NOW(),NOW())");
              }
            }
          }
        }
        //sorting pilihan ptn 1 prodi urutan 2
        foreach($final as $fin){
          $nopen = $fin['nomor_pendaftaran'];
          $kodprodi = $fin['kode_program_studi'];
          $urutan_ptn = $fin['urutan_ptn'];
          $urutan_program_studi = $fin['urutan_program_studi'];
          $dayatampungprodi = DB::select("SELECT*FROM daya_tampung WHERE kode_prodi ='$kodprodi'");
          foreach($dayatampungprodi as $dy){
            $kuotatampung = $dy->kapasitas;
          }
          $siswaterisi = DB::select("SELECT*FROM siswa_final WHERE kode_program_studi = '$kodprodi'");
          $totalterisi = count($siswaterisi);
          if($totalterisi < $kuotatampung){
            if($urutan_ptn == 1 && $urutan_program_studi == 2){
              $querycek = DB::select("SELECT*FROM siswa_final WHERE nomor_pendaftaran ='$nopen'");
              $cek = count($querycek);
              if($cek == 0){
                $insert =DB::select("INSERT INTO siswa_final VALUES('$nopen','$kodprodi','$tahun',NOW(),NOW())");
              }
            }
          }
        }

        //sorting pilihan ptn 2 prodi urutan 1
        foreach($final as $fin){
          $nopen = $fin['nomor_pendaftaran'];
          $kodprodi = $fin['kode_program_studi'];
          $urutan_ptn = $fin['urutan_ptn'];
          $urutan_program_studi = $fin['urutan_program_studi'];
          $dayatampungprodi = DB::select("SELECT*FROM daya_tampung WHERE kode_prodi ='$kodprodi'");
          foreach($dayatampungprodi as $dy){
            $kuotatampung = $dy->kapasitas;
          }
          $siswaterisi = DB::select("SELECT*FROM siswa_final WHERE kode_program_studi = '$kodprodi'");
          $totalterisi = count($siswaterisi);
          if($totalterisi < $kuotatampung){
            if($urutan_ptn == 2 && $urutan_program_studi == 1){
              $querycek = DB::select("SELECT*FROM siswa_final WHERE nomor_pendaftaran ='$nopen'");
              $cek = count($querycek);
              if($cek == 0){
                $insert =DB::select("INSERT INTO siswa_final VALUES('$nopen','$kodprodi','$tahun',NOW(),NOW())");
              }
            }
          }
        }

        $isiresetdata = DB::select("INSERT INTO data_reset VALUES('$tahun',NOW(),NOW())");
      }


      return redirect("/hasil/$kodeprodi/$tahun");

    //return view('hasil.datahasil',['data' => $final,'program_studi' => $kodeprodi,'kuotaprodi' => $kuotaprodi, 'tahun' => $tahun, 'siswafinal' => $siswafinal]);

    }






    public function filterhasil($kodeprodi,  $tahun){
      $programstudi = $kodeprodi;
      $tahun = $tahun;
      $dayatampungprodi = DB::select("SELECT*FROM daya_tampung WHERE kode_prodi ='$kodeprodi'");
      foreach($dayatampungprodi as $dy){
        $kuotatampung = $dy->kapasitas;
        $kuotaprodi = $dy->kapasitas;
      }

      // $siswafinal = DB::select("SELECT*FROM siswa_final");
      // $rataNilai = DB::select("SELECT nomor_pendaftaran,kode_mata_pelajaran, sum(nilai_skala_100)/5 AS total FROM data_nilai WHERE kode_mata_pelajaran='MAT' OR kode_mata_pelajaran='IND' OR kode_mata_pelajaran='ING' GROUP BY nomor_pendaftaran, kode_mata_pelajaran ");
      //
      // $kriteria = DB::select("SELECT DISTINCT data_siswa.nomor_pendaftaran, data_jurusan.nilai_akreditasi, ranking_akumulasi.percentile from data_siswa,data_jurusan,ranking_akumulasi,data_pilihan WHERE data_siswa.id_jurusan = data_jurusan.id_jurusan AND data_siswa.nomor_pendaftaran = ranking_akumulasi.nomor_pendaftaran AND data_siswa.kode_tahun_akademik= '$tahun'");
      //
      //
      // $prestasi = DB::select("SELECT*FROM data_prestasi WHERE data_prestasi.kode_tahun_akademik = '$tahun' ");
      // $jurusan = DB::select("SELECT DISTINCT program_studi from data_pilihan WHERE data_pilihan.kode_tahun_akademik='$tahun'");
       $listprodi = DB::select("SELECT*FROM prodi");
       $tahun_sidebar = DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");
      //
      // $cek = DB::select("SELECT DISTINCT data_siswa.nomor_pendaftaran,nama_siswa,data_pilihan.kode_program_studi,urutan_ptn,urutan_program_studi,program_studi, data_siswa.kode_tahun_akademik from data_siswa,data_pilihan WHERE data_siswa.nomor_pendaftaran = data_pilihan.nomor_pendaftaran AND data_pilihan.kode_program_studi= '$kodeprodi' AND data_siswa.kode_tahun_akademik = '$tahun' AND data_pilihan.urutan_program_studi='1'");
      // $arr=array();
      // //bobotnilai
      // $nilaikriteria = DB::select("SELECT*FROM kriteria_nilai WHERE tahun_akademik='$tahun'");
      // foreach($nilaikriteria as $bobotnilai){
      //   if($bobotnilai->kriteria == "X1"){
      //     $bobotX1 = $bobotnilai->bobot;
      //   }elseif($bobotnilai->kriteria == "X2"){
      //     $bobotX2 = $bobotnilai->bobot;
      //   }
      //   elseif($bobotnilai->kriteria == "X3"){
      //     $bobotX3 = $bobotnilai->bobot;
      //   }
      //   elseif($bobotnilai->kriteria == "X6"){
      //     $bobotX6 = $bobotnilai->bobot;
      //   }
      //   elseif($bobotnilai->kriteria == "X9"){
      //     $bobotX9 = $bobotnilai->bobot;
      //   }
      //   elseif($bobotnilai->kriteria == "X11"){
      //     $bobotX11 = $bobotnilai->bobot;
      //   }
      // }
      //
      //
      // foreach($cek as $c){
      //   $total = 0;
      //   foreach ($rataNilai as $key ) {
      //     if($c->nomor_pendaftaran== $key->nomor_pendaftaran){
      //       if($key->kode_mata_pelajaran=='MAT'){
      //         $nilai = $key->total*$bobotX3/100;
      //         $total +=$nilai;
      //       }
      //       elseif ($key->kode_mata_pelajaran=="IND") {
      //         $nilai = $key->total*$bobotX1/100;
      //         $total +=$nilai;
      //       }
      //       elseif ($key->kode_mata_pelajaran=="ING") {
      //         $nilai = $key->total*$bobotX2/100;
      //         $total +=$nilai;
      //       }
      //     }
      //   }
      //   $fil['total'] = $total;
      //   $fil['nomor_pendaftaran'] = $c->nomor_pendaftaran;
      //   $fil['nama_siswa'] = $c->nama_siswa;
      //   $fil['urutan_ptn'] = $c->urutan_ptn;
      //   $fil['kode_program_studi']=$c->kode_program_studi;
      //   $fil['urutan_program_studi'] = $c->urutan_program_studi;
      //   $fil['program_studi'] = $c->program_studi;
      //   array_push($arr,$fil);
      // }
      //
      // $akhir = array();
      // foreach($kriteria as $kri){
      // foreach($arr as $r){
      //     if($r['nomor_pendaftaran'] == $kri->nomor_pendaftaran ){
      //       if($kri->nilai_akreditasi=='-' || $kri->nilai_akreditasi==""){
      //         $akre = 50;
      //       }else {
      //         $akre = $kri->nilai_akreditasi;
      //       }
      //       $akumulasi = $akre*$kri->percentile*$bobotX11/100;
      //       $total = $r['total']+$akumulasi;
      //       $isi['nomor_pendaftaran']=$kri->nomor_pendaftaran;
      //       $isi['nama_siswa'] = $r['nama_siswa'];
      //       $isi['urutan_ptn'] = $r['urutan_ptn'];
      //       $isi['kode_program_studi']=$r['kode_program_studi'];
      //       $isi['urutan_program_studi'] = $r['urutan_program_studi'];
      //       $isi['program_studi'] = $r['program_studi'];
      //       $isi['total'] = $total;
      //       array_push($akhir,$isi);
      //     }
      //   }
      // }
      // $final = array();
      // $nilai =0;
      // foreach($akhir as $a){
      //   foreach($prestasi as $p){
      //     if($a['nomor_pendaftaran']==$p->nomor_pendaftaran){
      //       if($p->jenjang_prestasi == "Sekolah"){
      //         if($p->juara == 1){
      //           $nilai = 10;
      //         }elseif ($p->juara == 2) {
      //           $nilai = 5;
      //         }elseif ($p->juara == "") {
      //           $nilai = 0;
      //         }
      //       }elseif ($p->jenjang_prestasi == "Kabupaten/Kodya") {
      //         if($p->juara == 1){
      //           $nilai = 25;
      //         }elseif ($p->juara == 2) {
      //           $nilai = 20;
      //         }elseif ($p->juara == 3) {
      //           $nilai = 15;
      //         }elseif ($p->juara == "") {
      //           $nilai = 0;
      //         }
      //       }elseif ($p->jenjang_prestasi == "Propinsi") {
      //         if($p->juara == 1){
      //           $nilai = 50;
      //         }elseif ($p->juara == 2) {
      //           $nilai = 40;
      //         }elseif ($p->juara == 3) {
      //           $nilai = 30;
      //         }elseif ($p->juara == "") {
      //           $nilai = 0;
      //         }
      //       }elseif ($p->jenjang_prestasi == "Nasional") {
      //         if($p->juara == 1){
      //           $nilai = 75;
      //         }elseif ($p->juara == 2) {
      //           $nilai = 65;
      //         }elseif ($p->juara == 3) {
      //           $nilai = 55;
      //         }elseif ($p->juara == "") {
      //           $nilai = 0;
      //         }
      //
      //       }elseif ($p->jenjang_prestasi == "Internasional") {
      //         if($p->juara == 1){
      //           $nilai = 100;
      //         }elseif ($p->juara == 2) {
      //           $nilai = 90;
      //         }elseif ($p->juara == 3) {
      //           $nilai = 80;
      //         }elseif ($p->juara == "") {
      //           $nilai = 0;
      //         }
      //       }else {
      //         $nilai = 0;
      //       }
      //     }
      //     $total = $a['total'] + ($nilai*$bobotX6/100);
      //   }
      //   $isi['total'] = $total;
      //   $isi['nomor_pendaftaran'] = $a['nomor_pendaftaran'];
      //   $isi['nama_siswa'] = $a['nama_siswa'];
      //   $isi['urutan_ptn'] = $a['urutan_ptn'];
      //   $isi['kode_program_studi']=$a['kode_program_studi'];
      //   $isi['urutan_program_studi'] = $a['urutan_program_studi'];
      //   $isi['program_studi'] = $a['program_studi'];
      //   array_push($final,$isi);
      // }
      // //echo json_encode($final);
      // $urutan = array_column($final,'urutan_program_studi');
      // array_multisort($urutan,SORT_ASC,$final);
      // $keys = array_column($final, 'total');
      // array_multisort($keys, SORT_DESC, $final);



      $progrmstudi = DB::select("SELECT*FROM data_pilihan WHERE kode_program_studi='$kodeprodi'");
      $prodiditerima = DB::select("SELECT*FROM prodi");
      foreach($progrmstudi as $prg){
        $pstudi = $prg->program_studi;
      }

    return view('hasil.datahasil',['program_studi' => $kodeprodi,'pstudi' => $pstudi,'kuotaprodi' => $kuotaprodi, 'tahun' => $tahun, 'prodiditerima' => $prodiditerima,'listprodi' => $listprodi, 'tahun_sidebar' => $tahun_sidebar]);

    }

    public function apisbmptn($kodeprodi, $tahun){
      $data = DB::select("SELECT*FROM  biodata_terima , biodata_peminat WHERE biodata_terima.kode_prodi_terima = biodata_peminat.kode_prodi_terima AND biodata_terima.kode_peserta = biodata_peminat.kode_peserta AND biodata_terima.kode_tahun_akademik = '$tahun' AND biodata_terima.kode_prodi_terima ='$kodeprodi'");

      return $data;


    }


    public function apihasil($kodeprodi,  $tahun){
      //set_time_limit(600);
      $programstudi = $kodeprodi;
      $tahun = $tahun;
      $dayatampung = DayaTampung::where('kode_prodi',$kodeprodi)->first();

      $prodiditerima = DB::select("SELECT*FROM prodi");
      $kuotaprodi = $dayatampung->kapasitas;
      $siswafinal = DB::select("SELECT*FROM siswa_final WHERE tahun_akademik='$tahun'");
      $rataNilai = DB::select("SELECT nomor_pendaftaran,kode_mata_pelajaran, sum(nilai_skala_100)/5 AS total FROM data_nilai WHERE kode_mata_pelajaran='MAT' OR kode_mata_pelajaran='IND' OR kode_mata_pelajaran='ING' GROUP BY nomor_pendaftaran, kode_mata_pelajaran ");

      $kriteria = DB::select("SELECT DISTINCT data_siswa.nomor_pendaftaran, data_jurusan.nilai_akreditasi, ranking_akumulasi.percentile from data_siswa,data_jurusan,ranking_akumulasi,data_pilihan WHERE data_siswa.id_jurusan = data_jurusan.id_jurusan AND data_siswa.nomor_pendaftaran = ranking_akumulasi.nomor_pendaftaran AND data_siswa.kode_tahun_akademik= '$tahun'");


      $prestasi = DB::select("SELECT*FROM data_prestasi WHERE data_prestasi.kode_tahun_akademik = '$tahun' ");
      $jurusan = DB::select("SELECT DISTINCT program_studi from data_pilihan WHERE data_pilihan.kode_tahun_akademik='$tahun'");
      $listprodi = DB::select("SELECT*FROM prodi");
      $tahun_sidebar = DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");

      $datapilihan = DB::select("SELECT*FROM data_pilihan WHERE kode_tahun_akademik='$tahun'");

      $cek = DB::select("SELECT DISTINCT data_siswa.nomor_pendaftaran,nama_siswa,data_pilihan.kode_program_studi,urutan_ptn,urutan_program_studi,program_studi, data_siswa.kode_tahun_akademik, data_siswa.nik, data_siswa.nisn, data_siswa.npsn_sekolah, data_sekolah.nama_sekolah, data_sekolah.nama_kabupaten, data_siswa.kip_kks, data_sekolah.nama_provinsi, data_jurusan.kode_jurusan from data_siswa,data_pilihan,data_sekolah,data_jurusan WHERE data_siswa.nomor_pendaftaran = data_pilihan.nomor_pendaftaran AND data_siswa.npsn_sekolah = data_sekolah.npsn  AND data_siswa.id_jurusan = data_jurusan.id_jurusan AND data_pilihan.kode_program_studi= '$kodeprodi' AND data_siswa.kode_tahun_akademik = '$tahun' ");
      $arr=array();
      //bobotnilai
      $nilaikriteria = DB::select("SELECT*FROM kriteria_nilai WHERE tahun_akademik='$tahun'");
      foreach($nilaikriteria as $bobotnilai){
        if($bobotnilai->kriteria == "X1"){
          $bobotX1 = $bobotnilai->bobot;
        }elseif($bobotnilai->kriteria == "X2"){
          $bobotX2 = $bobotnilai->bobot;
        }
        elseif($bobotnilai->kriteria == "X3"){
          $bobotX3 = $bobotnilai->bobot;
        }
        elseif($bobotnilai->kriteria == "X6"){
          $bobotX6 = $bobotnilai->bobot;
        }
        elseif($bobotnilai->kriteria == "X9"){
          $bobotX9 = $bobotnilai->bobot;
        }
        elseif($bobotnilai->kriteria == "X11"){
          $bobotX11 = $bobotnilai->bobot;
        }
      }


      foreach($cek as $c){
        $total = 0;
        foreach ($rataNilai as $key ) {
          if($c->nomor_pendaftaran== $key->nomor_pendaftaran){
            if($key->kode_mata_pelajaran=='MAT'){
              $nilai = $key->total*$bobotX3/100;
              $total +=$nilai;
              $fil['MAT'] = $key->total*1;

            }
            elseif ($key->kode_mata_pelajaran=="IND") {
              $nilai = $key->total*$bobotX1/100;
              $total +=$nilai;
              $fil['IND'] = $key->total*1;
            }
            elseif ($key->kode_mata_pelajaran=="ING") {
              $nilai = $key->total*$bobotX2/100;
              $total +=$nilai;
              $fil['ING'] = $key->total*1;
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

      $akhir = array();
      foreach($kriteria as $kri){
      foreach($arr as $r){
          if($r['nomor_pendaftaran'] == $kri->nomor_pendaftaran ){
            if($kri->nilai_akreditasi=='-' || $kri->nilai_akreditasi==""){
              $akre = 50;
            }else {
              $akre = $kri->nilai_akreditasi;
            }
            $akumulasi = $akre*$kri->percentile*$bobotX11/100;
            $total = $r['total']+$akumulasi;
            $isi['nomor_pendaftaran']=$kri->nomor_pendaftaran;
            $isi['nama_siswa'] = $r['nama_siswa'];
            $isi['nik'] = $r['nik'];
            $isi['kip_kks'] = $r['kip_kks'];
            $isi['nama_provinsi'] = $r['nama_provinsi'];
            $isi['nisn'] = $r['nisn'];
            $isi['npsn'] = $r['npsn'];
            $isi['nama_sekolah'] = $r['nama_sekolah'];
            $isi['kota_sekolah'] = $r['kota_sekolah'];
            $isi['kode_jurusan'] = $r['kode_jurusan'];
            $isi['urutan_ptn'] = $r['urutan_ptn'];
            $isi['kode_program_studi']=$r['kode_program_studi'];
            $isi['urutan_program_studi'] = $r['urutan_program_studi'];
            $isi['program_studi'] = $r['program_studi'];
            $isi['MAT'] = $r['MAT'];
            $isi['IND'] = $r['IND'];
            $isi['ING'] = $r['ING'];
            $isi['total'] = $total;
            array_push($akhir,$isi);
          }
        }
      }
      $final = array();
      $nilai =0;
      foreach($akhir as $a){
        foreach($prestasi as $p){
          if($a['nomor_pendaftaran']==$p->nomor_pendaftaran){
            if($p->jenjang_prestasi == "Sekolah"){
              if($p->juara == 1){
                $nilai = 10;
              }elseif ($p->juara == 2) {
                $nilai = 5;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }
            }elseif ($p->jenjang_prestasi == "Kabupaten/Kodya") {
              if($p->juara == 1){
                $nilai = 25;
              }elseif ($p->juara == 2) {
                $nilai = 20;
              }elseif ($p->juara == 3) {
                $nilai = 15;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }
            }elseif ($p->jenjang_prestasi == "Propinsi") {
              if($p->juara == 1){
                $nilai = 50;
              }elseif ($p->juara == 2) {
                $nilai = 40;
              }elseif ($p->juara == 3) {
                $nilai = 30;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }
            }elseif ($p->jenjang_prestasi == "Nasional") {
              if($p->juara == 1){
                $nilai = 75;
              }elseif ($p->juara == 2) {
                $nilai = 65;
              }elseif ($p->juara == 3) {
                $nilai = 55;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }

            }elseif ($p->jenjang_prestasi == "Internasional") {
              if($p->juara == 1){
                $nilai = 100;
              }elseif ($p->juara == 2) {
                $nilai = 90;
              }elseif ($p->juara == 3) {
                $nilai = 80;
              }elseif ($p->juara == "") {
                $nilai = 0;
              }
            }else {
              $nilai = 0;
            }
          }
          $total = $a['total'] + ($nilai*$bobotX6/100);
        }
        $isi['total'] = $total;
        $isi['MAT'] = $a['MAT'];
        $isi['IND'] = $a['IND'];
        $isi['ING'] = $a['ING'];
        $isi['nomor_pendaftaran'] = $a['nomor_pendaftaran'];
        $isi['nama_siswa'] = $a['nama_siswa'];
        $isi['nik'] = $a['nik'];
        $isi['kip_kks'] = $a['kip_kks'];
        $isi['nama_provinsi'] = $a['nama_provinsi'];
        $isi['nisn'] = $a['nisn'];
        $isi['npsn'] = $a['npsn'];
        $isi['nama_sekolah'] = $a['nama_sekolah'];
        $isi['kota_sekolah'] = $a['kota_sekolah'];
        $isi['kode_jurusan'] = $a['kode_jurusan'];
        $isi['urutan_ptn'] = $a['urutan_ptn'];
        $isi['kode_program_studi']=$a['kode_program_studi'];
        $isi['urutan_program_studi'] = $a['urutan_program_studi'];
        $isi['program_studi'] = $a['program_studi'];
        array_push($final,$isi);
      }
      //echo json_encode($final);





      $json = array();
      foreach($final as $f){

        $isi['total'] = $f['total'];
        $isi['MAT'] = $f['MAT'];
        $isi['IND'] = $f['IND'];
        $isi['ING'] = $f['ING'];
        $isi['nomor_pendaftaran'] = $f['nomor_pendaftaran'];
        $isi['nama_siswa'] = $f['nama_siswa'];
        $isi['nik'] = $f['nik'];
        $isi['kip_kks'] = $f['kip_kks'];
        $isi['nama_provinsi'] = $f['nama_provinsi'];
        $isi['nisn'] = $f['nisn'];
        $isi['npsn'] = $f['npsn'];
        $isi['nama_sekolah'] = $f['nama_sekolah'];
        $isi['kota_sekolah'] = $f['kota_sekolah'];
        $isi['kode_jurusan'] = $f['kode_jurusan'];
        $isi['urutan_ptn'] = $f['urutan_ptn'];
        $isi['kode_program_studi']=$f['kode_program_studi'];
        $isi['urutan_program_studi'] = $f['urutan_program_studi'];
        $isi['program_studi'] = $f['program_studi'];
        array_push($json,$isi);
      }

      $progrmstudi = DB::select("SELECT*FROM data_pilihan WHERE kode_program_studi='$kodeprodi'");
      $prodiditerima = DB::select("SELECT*FROM prodi");
      foreach($progrmstudi as $prg){
        $pstudi = $prg->program_studi;
      }

      $upjson = array();
      $pil2 = "";
      $tipe = "";
      $status ="";
      foreach($json as $js){
        $nomordaftar = $js['nomor_pendaftaran'];
        $kodecheck = $js['kode_program_studi'];
        $finalcheck = DB::select("SELECT*FROM siswa_final WHERE tahun_akademik='$tahun' AND nomor_pendaftaran='$nomordaftar'");
        $truecheck = count($finalcheck);
        if($truecheck>0){
          foreach($finalcheck as $true){
            if($true->kode_program_studi == $kodeprodi){
              $tipe = "checked";
            }else {
              $tipe = "disabled";
            }
            $prodi = $true->kode_program_studi;
          }
          $proditerima = DB::select("SELECT*FROM prodi WHERE kode_prodi='$prodi'");
          foreach($proditerima as $pr){
            $status = "<span class='text-success'>Diterima di $pr->nama_prodi</span>";
          }
        }else {
          $tipe = "";
          $status="Tidak Diterima";
        }
        // foreach($siswafinal as $s){
        //   if($s->nomor_pendaftaran == $js['nomor_pendaftaran']    AND $s->kode_program_studi == $js['kode_program_studi'] ){
        //     $tipe = "checked";
        //   }
        //   elseif($s->nomor_pendaftaran == $js['nomor_pendaftaran']    AND  $s->kode_program_studi != $js['kode_program_studi'] ){
        //     $tipe = "disabled";
        //   }
        //
        // }
        $isi['status'] = $status;
        $isi['tipe'] = $tipe;

        foreach($datapilihan as $dtpil){
          if($js['nomor_pendaftaran'] == $dtpil->nomor_pendaftaran){
            if($dtpil->urutan_program_studi == 1){
              $isi['pil1'] = $dtpil->program_studi;
            }elseif ($dtpil->urutan_program_studi == 2) {
              $pil2 = $dtpil->program_studi;
            }
            $isi['pil2'] = $pil2;
          }
        }
        $isi['total'] = $js['total'];
        $isi['MAT'] = $js['MAT'];
        $isi['IND'] = $js['IND'];
        $isi['ING'] = $js['ING'];
        $isi['nomor_pendaftaran'] = $js['nomor_pendaftaran'];
        $isi['nama_siswa'] = $js['nama_siswa'];
        $isi['nik'] = $js['nik'];
        $isi['kip_kks'] = $js['kip_kks'];
        $isi['nama_provinsi'] = $js['nama_provinsi'];
        $isi['nisn'] = $js['nisn'];
        $isi['npsn'] = $js['npsn'];
        $isi['nama_sekolah'] = $js['nama_sekolah'];
        $isi['kota_sekolah'] = $js['kota_sekolah'];
        $isi['kode_jurusan'] = $js['kode_jurusan'];
        $isi['urutan_ptn'] = $js['urutan_ptn'];
        $isi['kode_program_studi']=$js['kode_program_studi'];
        $isi['urutan_program_studi'] = $js['urutan_program_studi'];
        $isi['program_studi'] = $js['program_studi'];
        array_push($upjson,$isi);
      }




      $keys = array_column($upjson, 'total');
      array_multisort($keys, SORT_DESC, $upjson);
      $urutan = array_column($upjson,'urutan_program_studi');
      array_multisort($urutan,SORT_ASC,$upjson);





      //echo json_encode($json);
      //return $json;
      //echo count($json);
      return $upjson;
    }
    public function countfinal(){
      $tes = DB::select("SELECT*FROM siswa_final WHERE tahun_akademik='20201'  AND nomor_pendaftaran='4200477665'");

      return $tes;
    }



    function hapusdatareset(Request $req){
      $tahun = $req->tahun;
      $datareset = DB::select("DELETE FROM data_reset WHERE tahun_akademik='$tahun'");
      $siswa = DB::select("DELETE FROM siswa_final WHERE tahun_akademik = '$tahun'");
      return redirect('/datareset')->with('status','Data SNMPTN berhasil di RESET');
    }

    function datareset(){
      $data['listprodi'] = \DB::select("SELECT*FROM prodi");
      $data['tahun'] = \DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");
      $data['data_reset'] = DB::select("SELECT*FROM data_reset");
      return view('hasil.data_reset',$data);
    }
    function resetsnmptn(){
      $data['listprodi'] = \DB::select("SELECT*FROM prodi");
      $data['tahun'] = \DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");
      $data['data_reset'] = DB::select("SELECT*FROM tahun_akademik");
      return view('hasil.resetsnm',$data);
    }
    function resetsbmptn(){
      $data['tahun'] = \DB::select("SELECT*FROM tahun_sbmptn order by kode_tahun_akademik ASC");
      $data['data_reset'] = DB::select("SELECT*FROM tahun_sbmptn");
      return view('hasil.resetsbm',$data);
    }
    function snmptnimportreset(Request $request)
    {
      $tahun = $request->tahun;
      //dd($tahun);
      $siswa1 = DB::select("DELETE FROM data_jurusan WHERE kode_tahun_akademik = '$tahun'");
      $siswa2 = DB::select("DELETE FROM data_karya_portofolio WHERE kode_tahun_akademik = '$tahun'");
      $siswa3 = DB::select("DELETE FROM data_kelas WHERE kode_tahun_akademik = '$tahun'");
      $siswa4 = DB::select("DELETE FROM data_kelas_siswa WHERE kode_tahun_akademik = '$tahun'");
      $siswa5 = DB::select("DELETE FROM data_nilai WHERE kode_tahun_akademik = '$tahun'");
      $siswa6 = DB::select("DELETE FROM data_nilai_mapel_un_kolom_sma_skala4 WHERE kode_tahun_akademik = '$tahun'");
      $siswa7 = DB::select("DELETE FROM data_nilai_mapel_un_kolom_sma_skala100 WHERE kode_tahun_akademik = '$tahun'");
      $siswa8 = DB::select("DELETE FROM data_nilai_mapel_un_kolom_smk_skala4 WHERE kode_tahun_akademik = '$tahun'");
      $siswa9 = DB::select("DELETE FROM data_nilai_mapel_un_kolom_smk_skala100 WHERE kode_tahun_akademik = '$tahun'");
      $siswa10 = DB::select("DELETE FROM data_nilai_status_tambahan WHERE kode_tahun_akademik = '$tahun'");
      $siswa11 = DB::select("DELETE FROM data_nilai_tidak_ada WHERE kode_tahun_akademik = '$tahun'");
      $siswa12 = DB::select("DELETE FROM data_perubahan_npsn WHERE kode_tahun_akademik = '$tahun'");
      $siswa13 = DB::select("DELETE FROM data_pilihan WHERE kode_tahun_akademik = '$tahun'");
      $siswa14 = DB::select("DELETE FROM data_portofolio WHERE kode_tahun_akademik = '$tahun'");
      $siswa15 = DB::select("DELETE FROM data_prestasi WHERE kode_tahun_akademik = '$tahun'");
      $siswa16 = DB::select("DELETE FROM data_sekolah WHERE kode_tahun_akademik = '$tahun'");
      $siswa17 = DB::select("DELETE FROM data_siswa WHERE kode_tahun_akademik = '$tahun'");
      $siswa18 = DB::select("DELETE FROM data_statistik_penghasilan WHERE kode_tahun_akademik = '$tahun'");
      $siswa19 = DB::select("DELETE FROM data_status_tambahan WHERE kode_tahun_akademik = '$tahun'");
      $siswa20 = DB::select("DELETE FROM ranking_akumulasi WHERE kode_tahun_akademik = '$tahun'");
      $siswa21 = DB::select("DELETE FROM ranking_semester WHERE kode_tahun_akademik = '$tahun'");
      $siswa22 = DB::select("DELETE FROM kriteria_nilai WHERE tahun_akademik = '$tahun'");
      $siswa23 = DB::select("DELETE FROM tahun_akademik WHERE kode_tahun_akademik = '$tahun'");

      return redirect('/resetsnmptn')->with('status','Data Import SNMPTN berhasil di RESET');
    }
    function sbmptnimportreset(Request $request)
    {
      $tahun = $request->tahun;
      //dd($tahun);
      $siswa1 = DB::select("DELETE FROM terima_ptn WHERE kode_tahun_akademik = '$tahun'");
      $siswa2 = DB::select("DELETE FROM sebaran_provinsi WHERE kode_tahun_akademik = '$tahun'");
      $siswa3 = DB::select("DELETE FROM rataan_prodi WHERE kode_tahun_akademik = '$tahun'");
      $siswa4 = DB::select("DELETE FROM terima_saintek WHERE kode_tahun_akademik = '$tahun'");
      $siswa5 = DB::select("DELETE FROM terima_soshum WHERE kode_tahun_akademik = '$tahun'");
      $siswa6 = DB::select("DELETE FROM biodata_terima WHERE kode_tahun_akademik = '$tahun'");
      $siswa7 = DB::select("DELETE FROM biodata_peminat WHERE kode_tahun_akademik = '$tahun'");
      $siswa8 = DB::select("DELETE FROM biodata_terima_bidikmisi WHERE kode_tahun_akademik = '$tahun'");
      $siswa9 = DB::select("DELETE FROM keketatan_prodi WHERE kode_tahun_akademik = '$tahun'");
      $siswa10 = DB::select("DELETE FROM keketatan_soshum WHERE kode_tahun_akademik = '$tahun'");
      $siswa11 = DB::select("DELETE FROM keketatan_saintek WHERE kode_tahun_akademik = '$tahun'");
      $siswa23 = DB::select("DELETE FROM tahun_sbmptn WHERE kode_tahun_akademik = '$tahun'");

      return redirect('/resetsbmptn')->with('status','Data Import SBMPTN berhasil di RESET');
    }

    function tampilsiswa($program_studi,$tahun){
      $siswa = DB::select("SELECT siswa_final.nomor_pendaftaran,data_siswa.nama_siswa, data_pilihan.program_studi FROM siswa_final ,data_siswa,data_pilihan WHERE siswa_final.nomor_pendaftaran = data_siswa.nomor_pendaftaran AND siswa_final.kode_program_studi = data_pilihan.kode_program_studi AND siswa_final.nomor_pendaftaran = data_pilihan.nomor_pendaftaran AND siswa_final.tahun_akademik=$tahun AND siswa_final.kode_program_studi = $program_studi ");
      $result="";
      foreach($siswa as $r){
        $result .="<tr><td>$r->nomor_pendaftaran</td><td>$r->nama_siswa</td><td>$r->program_studi</td></tr>";
      }
      return $result;

    }
    function ambilkuota($program_studi,$tahun){
      $siswa = DB::select("SELECT*FROM siswa_final WHERE kode_program_studi='$program_studi' AND tahun_akademik='$tahun'");
      $hasil = count($siswa);
      return $hasil;
    }

    function simpansiswa(Request $req){
      $nomor_pendaftaran = $req->nomor_pendaftaran;
      $kode_program_studi = $req->kode_program_studi;
      $tahun = $req->tahun;

      $insert = DB::select("INSERT INTO siswa_final VALUES('$nomor_pendaftaran','$kode_program_studi','$tahun',NOW(),NOW())");
    }

    function deletesiswa(Request $req){
      $nomor_pendaftaran = $req->nomor_pendaftaran;
      $kode_program_studi = $req->kode_program_studi;
      $tahun = $req->tahun;

      $insert = DB::select("DELETE FROM siswa_final WHERE nomor_pendaftaran='$nomor_pendaftaran'");
    }



    public function nas1()
    {
      $rataNilai = DB::select("SELECT nomor_pendaftaran,kode_mata_pelajaran, sum(nilai_skala_100)/5 AS total FROM data_nilai WHERE kode_mata_pelajaran='MAT' OR kode_mata_pelajaran='IND' OR kode_mata_pelajaran='ING' GROUP BY nomor_pendaftaran, kode_mata_pelajaran ");
      $kriteria = DB::select("SELECT data_siswa.nomor_pendaftaran, data_jurusan.nilai_akreditasi, ranking_akumulasi.percentile from data_siswa,data_jurusan,ranking_akumulasi WHERE data_siswa.id_jurusan = data_jurusan.id_jurusan AND data_siswa.nomor_pendaftaran = ranking_akumulasi.nomor_pendaftaran");
      $prestasi = DB::select("SELECT*FROM data_prestasi");
      $jurusan = DB::select("SELECT DISTINCT program_studi from data_pilihan");


      $cek = DB::select("SELECT DISTINCT data_siswa.nomor_pendaftaran,nama_siswa,urutan_ptn,urutan_program_studi,program_studi from data_siswa,data_pilihan WHERE data_siswa.nomor_pendaftaran = data_pilihan.nomor_pendaftaran");
      $arr=array();
      foreach($cek as $c){
        $total = 0;
        foreach ($rataNilai as $key ) {
          if($c->nomor_pendaftaran== $key->nomor_pendaftaran){
            if($key->kode_mata_pelajaran=='MAT'){
              $nilai = $key->total*33/100;
              $total +=$nilai;
            }
            elseif ($key->kode_mata_pelajaran=="IND") {
              $nilai = $key->total*12/100;
              $total +=$nilai;
            }
            elseif ($key->kode_mata_pelajaran=="ING") {
              $nilai = $key->total*25/100;
              $total +=$nilai;
            }
          }
        }
        $fil['total'] = $total;
        $fil['nomor_pendaftaran'] = $c->nomor_pendaftaran;
        $fil['nama_siswa'] = $c->nama_siswa;
        $fil['urutan_ptn'] = $c->urutan_ptn;
        $fil['urutan_program_studi'] = $c->urutan_program_studi;
        $fil['program_studi'] = $c->program_studi;
        array_push($arr,$fil);
      }

      $akhir = array();
      foreach($kriteria as $kri){
        foreach($arr as $r){
          if($kri->nomor_pendaftaran == $r['nomor_pendaftaran']){
            if($kri->nilai_akreditasi=='-' || $kri->nilai_akreditasi==""){
              $akre = 50;
            }else {
              $akre = $kri->nilai_akreditasi;
            }
            $akumulasi = $akre*$kri->percentile*15/100;
            $total = $r['total']+$akumulasi;
            $isi['nomor_pendaftaran']=$kri->nomor_pendaftaran;
            $isi['nama_siswa'] = $r['nama_siswa'];
            $isi['urutan_ptn'] = $r['urutan_ptn'];
            $isi['urutan_program_studi'] = $r['urutan_program_studi'];
            $isi['program_studi'] = $r['program_studi'];
            $isi['total'] = $total;
            array_push($akhir,$isi);
          }
        }
      }
      $final = array();
      foreach($akhir as $a){
        foreach($prestasi as $p){
          if($a['nomor_pendaftaran']==$p->nomor_pendaftaran){
            if($p->jenjang_prestasi == "Sekolah"){
              $nilai = 10;
            }elseif ($p->jenjang_prestasi == "Kabupaten/Kodya") {
              $nilai = 25;
            }elseif ($p->jenjang_prestasi == "Propinsi") {
              $nilai = 50;
            }elseif ($p->jenjang_prestasi == "Nasional") {
              $nilai = 75;
            }elseif ($p->jenjang_prestasi == "Internasional") {
              $nilai = 100;
            }else {
              $nilai = 0;
            }
          }
          $total = $a['total'] + ($nilai*15/100);
        }
        $isi['total'] = $total;
        $isi['nomor_pendaftaran'] = $a['nomor_pendaftaran'];
        $isi['nama_siswa'] = $a['nama_siswa'];
        $isi['urutan_ptn'] = $a['urutan_ptn'];
        $isi['urutan_program_studi'] = $a['urutan_program_studi'];
        $isi['program_studi'] = $a['program_studi'];
        array_push($final,$isi);
      }
      $keys = array_column($final, 'total');
      array_multisort($keys, SORT_DESC, $final);
      //echo json_encode($final);
      return view('layouts.scoring',['data' => $final,'jurusan' => $jurusan]);
    }
}
