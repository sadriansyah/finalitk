@extends('template/master')

@section('cssscript')

    <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
    </style>
@endsection

@section('prodi')
<li>
    <a href="javascript:void(0);" class="menu-toggle">
        <i class="material-icons">import_export</i>
        <span>Import Data</span>
    </a>
    <ul class="ml-menu">
  <li>
    <a href="{{url('/testcsv')}}">
        <i class="material-icons">text_fields</i>
        <span>Test import</span>
    </a>
  </li>
  <li>
    <a href="{{url('/data_jurusan')}}">
        <i class="material-icons">layers</i>
        <span>Data Jurusan</span>
    </a>
  </li>
  <li>
    <a href="{{url('/data_karya_portofolio')}}">
        <i class="material-icons">layers</i>
        <span>Data Karya Portofolio</span>
    </a>
  </li>
  <li>
    <a href="{{url('/data_kelas')}}">
        <i class="material-icons">layers</i>
        <span>Data Kelas</span>
    </a>
  </li>
  <li>
    <a href="{{url('/data_kelas_siswa')}}">
        <i class="material-icons">layers</i>
        <span>Data Kelas Siswa</span>
    </a>
  </li>
  <li>
    <a href="{{url('/data_ketunaan_pendaftar')}}">
        <i class="material-icons">layers</i>
        <span>Data Ketunaan Pendaftar</span>
    </a>
  </li>
<li>
    <a href="{{url('/data_nilai')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai</span>
    </a>
</li>
<li>
    <a href="{{url('/data_nilai_skala_4_sma')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai UN Skala 4 SMA</span>
    </a>
</li>
<li>
<li>
    <a href="{{url('/data_nilai_skala_100_sma')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai UN Skala 100 SMA</span>
    </a>
</li>
<li>
<li>
    <a href="{{url('/data_nilai_skala_4_smk')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai UN Skala 4 SMK</span>
    </a>
</li>
<li>
<li>
    <a href="{{url('/data_nilai_skala_100_smk')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai UN Skala 100 SMK</span>
    </a>
</li>
<li>
    <a href="{{url('/data_nilai_status_tambahan')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai Status Tambahan</span>
    </a>
</li>
<li>
    <a href="{{url('/data_nilai_tidak_ada')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai Tidak Ada</span>
    </a>
</li>
<li>
    <a href="{{url('/data_perubahan_npsn')}}">
        <i class="material-icons">layers</i>
        <span>Data Perubahan NPSN</span>
    </a>
</li>
<li>
    <a href="{{url('/data_pilihan')}}">
        <i class="material-icons">layers</i>
        <span>Data Pilihan</span>
    </a>
</li>
<li>
    <a href="{{url('/data_portofolio')}}">
        <i class="material-icons">layers</i>
        <span>Data Portofolio</span>
    </a>
</li>
<li>
    <a href="{{url('/data_prestasi')}}">
        <i class="material-icons">layers</i>
        <span>Data Prestasi</span>
    </a>
</li>
<li>
    <a href="{{url('/data_sekolah')}}">
        <i class="material-icons">layers</i>
        <span>Data Sekolah</span>
    </a>
</li>
<li>
    <a href="{{url('/data_siswa')}}">
        <i class="material-icons">layers</i>
        <span>Data Siswa</span>
    </a>
</li>
<li>
    <a href="{{url('/data_statistik_penghasilan')}}">
        <i class="material-icons">layers</i>
        <span>Data Statistik Penghasilan Ayah</span>
    </a>
</li>
<li>
    <a href="{{url('/data_statistik_penghasilan_ibu')}}">
        <i class="material-icons">layers</i>
        <span>Data Statistik Penghasilan Ibu</span>
    </a>
</li>
<li>
    <a href="{{url('/data_status_tambahan')}}">
        <i class="material-icons">layers</i>
        <span>Data Status Tambahan</span>
    </a>
</li>
<li>
    <a href="{{url('/ranking_akumulasi')}}">
        <i class="material-icons">layers</i>
        <span>Ranking Akumulasi</span>
    </a>
</li>
<li>
    <a href="{{url('/ranking_semester')}}">
        <i class="material-icons">layers</i>
        <span>Ranking Semester</span>
    </a>
</li>
    </ul>
</li>
<li>
    <a href="javascript:void(0);" class="menu-toggle">
      <i class="material-icons">dashboard</i>
      <span>Data Hasil</span>
    </a>
  <ul class="ml-menu">
    @foreach($listprodi as $list)
      <li>
          <a href="javascript:void(0);" class="menu-toggle">
              <i class="material-icons">layers</i>
              <span>{{$list->nama_prodi}}</span>
          </a>
          <ul class="ml-menu">
              @foreach($tahun as $t)
              <li>
                  <a href="{{url('/coba/'.$list->kode_prodi.'/'.$t->kode_tahun_akademik)}}">
                      <span>{{$t->tahun_akademik}}</span>
                  </a>
              </li>
              @endforeach
          </ul>
      </li>
    @endforeach
  </ul>
</li>

@endsection

@section('content')
<div class="container-fluid">

            <!-- Widgets -->
            <div class="row clearfix">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                    <div class="block-header">
                        <h2>File Prestasi</h2>
                    </div>

                        <!-- Button trigger modal -->
                        <form method="post" action="{{url('/addedfileprestasi')}}" enctype="multipart/form-data">
                          @csrf
                        <table class="table">
                          <tr>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tahun</label>
                              {{Form::select('kode_tahun_akademik',$tahun_akademik,null,['class' => 'form-control show-tick']) }}
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Import File (.zip)</label>
                                <input type="file" class="form-control" name="file" required>

                            </div>
                          </tr>

                          <tr>
                            <td>
                              <div class="form-group">
                                <button type="submit" class="btn btn-success float-right" >
                                  Submit
                                </button>
                              </div>
                              </td>
                          </tr>
                        </table>
                      </form>
                                <div class="card-body">

                                  @if(session('sukses'))
                                  <div class="alert alert-success" role="alert">
                                        {{session('sukses')}}
                                  </div>
                                  @endif
                                </div>
                        </div>
                        <div class="body">
                          <div class="progress">
                              <div class="bar"></div >
                              <div class="percent">0%</div >
                          </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->

</div>
@endsection

@section('jsscript')
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript">

    function validate(formData, jqForm, options){
      var form = jqForm[0];
      if(!form.file.value){
        alert('file not found');
        return false;
      }
    }

    (function(){
      var bar = $('.bar');

    var percent = $('.percent');

    var status = $('#status');



    $('form').ajaxForm({

        beforeSubmit: validate,

        beforeSend: function() {

            status.empty();

            var percentVal = '0%';

            var posterValue = $('input[name=file]').fieldValue();

            bar.width(percentVal)

            percent.html(percentVal);

        },

        uploadProgress: function(event, position, total, percentComplete) {

            var percentVal = percentComplete + '%';

            bar.width(percentVal)

            percent.html(percentVal);

        },

        success: function() {

            var percentVal = 'Wait, Saving';

            bar.width(percentVal)

            percent.html(percentVal);

        },

        complete: function(xhr) {

            status.html(xhr.responseText);

            alert('Uploaded Successfully');

            window.location.href = "/fileprestasi";

        }

    });


  })();

</script>


@endsection
