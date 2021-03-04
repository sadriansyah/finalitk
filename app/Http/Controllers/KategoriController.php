<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunAkademik;
use App\TahunSBMPTN;
use App\FileSBMPTN;
use App\KategoriFileSBMPTN;
class KategoriController extends Controller
{
    public function index()
    {
      if(!auth()->user()){
        return redirect('/');
      }
      if(auth()->user()->role == "koorprodi"){
       $namaprodi = auth()->user()->nama;
      	$data['listprodi'] = \DB::select("SELECT*FROM prodi WHERE nama_prodi LIKE '%$namaprodi%'");
      }elseif(auth()->user()->role == "kajur"){
        if(auth()->user()->nama == "JMTI"){
          $data['listprodi'] = \DB::select("SELECT*FROM prodi WHERE nama_prodi LIKE '%sistem informasi%' OR nama_prodi LIKE '%informatika%' OR nama_prodi LIKE '%matematika%' OR nama_prodi LIKE '%ilmu aktuaria%' OR nama_prodi LIKE '%statistika%'");
        }elseif(auth()->user()->nama == "JSTPK"){
          $data['listprodi'] = \DB::select("SELECT*FROM prodi WHERE nama_prodi LIKE '%fisika%' OR  nama_prodi LIKE '%teknik perkapalan%' OR  nama_prodi LIKE '%teknik kelautan%' OR  nama_prodi LIKE '%teknologi pangan%'");
        }elseif(auth()->user()->nama == "JTIP"){
         $data['listprodi'] = \DB::select("SELECT*FROM prodi WHERE nama_prodi LIKE '%teknik mesin%' OR nama_prodi LIKE '%teknik elektro%' OR nama_prodi LIKE '%teknik kimia%' OR nama_prodi LIKE '%teknik industri%' OR nama_prodi LIKE '%rekayasa keselamatan%'");
        }elseif(auth()->user()->nama == "JTSP"){
         $data['listprodi'] = \DB::select("SELECT*FROM prodi WHERE nama_prodi LIKE '%teknik sipil%' OR nama_prodi LIKE '%perencanaan wilayah dan kota%' OR nama_prodi LIKE '%arsitektur%'");
        }elseif(auth()->user()->nama == "JIKL"){
         $data['listprodi'] = \DB::select("SELECT*FROM prodi WHERE nama_prodi LIKE '%teknik lingkungan%' OR nama_prodi LIKE '%teknik material dan metalurgi%'");
        }
      }
    
    else{
       $data['listprodi'] = \DB::select("SELECT*FROM prodi");
      }
      
      $data['tahun'] = \DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");
      return view('itk/snmptn',$data);
    }
    public function index1(Request $request)
    {
      return view('itk/sbmptn');
    }
}
