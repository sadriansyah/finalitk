@extends('template/master')
@section('prodi')
<li>
    <a href="javascript:void(0);" class="menu-toggle">
        <i class="material-icons">import_export</i>
        <span>Import Data</span>
    </a>
    <ul class="ml-menu">


<li>
    <a href="{{url('/data_nilai')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai</span>
    </a>
</li>
<li>
    <a href="{{url('/data_nilai_un_sma')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai UN SMA</span>
    </a>
</li>
<li>
    <a href="{{url('/data_nilai_un_smk')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai UN SMK</span>
    </a>
</li>
<li>
    <a href="{{url('/data_nilai_status_tambahan')}}">
        <i class="material-icons">layers</i>
        <span>Data Nilai Status Tambahan</span>
    </a>
</li>

<li>
    <a href="{{url('/data_pilihan')}}">
        <i class="material-icons">layers</i>
        <span>Data Pilihan</span>
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
    <a href="{{url('/data_status_tambahan')}}">
        <i class="material-icons">layers</i>
        <span>Data Status Tambahan</span>
    </a>
</li>

<li>
    <a href="{{url('/ref_jurusan')}}">
        <i class="material-icons">layers</i>
        <span>Ref Jurusan</span>
    </a>
</li>
<li>
    <a href="{{url('/ref_matpel')}}">
        <i class="material-icons">layers</i>
        <span>Ref Mata Pelajaran</span>
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
                                    <h2>Data Sekolah</h2>
                                </div>
                        <form action="{{url('/data_sekolah')}}" method="get">
                          @csrf
                        <table class="table table-bordered table-striped table-hover">
                          <tr>
                            <td>Tahun Akademik</td>
                            <td>{{ Form::select('tahun_akademik',$tahun_akademik,$tahun_akademik_pilihan,['class' => 'form-control show-tick']) }}</td>
                            <tr>
                          <tr>
                            <td></td>
                            <td>
                              <button type="submit" class="btn btn-primary">Tampilkan</button>
                              <!-- Button trigger modal -->
                            </td>
                          </tr>
                        </table>
                        </form>
                <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success float-right mt-2 mb-2" data-toggle="modal" data-target="#exampleModal4">
                            Import Data
                        </button>
                        <div class="card-body">
                          @if(session('sukses'))
                          <div class="alert alert-success" role="alert">
                                {{session('sukses')}}
                          </div>
                          @endif
                        </div>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>NPSN</th>

                                        <th>Nama Sekolah</th>
                                        <th>Jenis Sekolah</th>
                                        <th>Kode Kabupaten</th>
                                        <th>Nama Kabupaten</th>
                                        <th>Kode Provinsi</th>
                                        <th>Nama Provinsi</th>
                                        <th>Akreditasi Sekolah</th>
                                        <th>Nilai Akreditasi</th>

                                        <th>Tanggal Kadaluarsa</th>
                                        <th>Kepemilikan</th>
                                        <th>Tanggal Mulai Akreditasi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    ?>
                                @foreach($sekolah as $d)
                                    <tr>
                                        <th>{{$i}}</th>
                                        <td>{{$d->npsn}}</td>

                                        <td>{{$d->nama_sekolah}}</td>
                                        <td>{{$d->jenis_sekolah}}</td>
                                        <td>{{$d->kode_kabupaten}}</td>
                                        <td>{{$d->nama_kabupaten}}</td>
                                        <td>{{$d->kode_provinsi}}</td>
                                        <td>{{$d->nama_provinsi}}</td>
                                        <td>{{$d->akreditasi_sekolah}}</td>
                                        <td>{{$d->nilai_akreditasi}}</td>

                                        <td>{{$d->tanggal_kadaluarsa}}</td>
                                        <td>{{$d->kepemilikan}}</td>
                                        <td>{{$d->tanggal_mulai_akreditasi}}</td>

                                    </tr>
                                    <?php
                                    $i++
                                    ?>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->

</div>
@endsection
<!-- Modal -->
<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel5">
                  <div class="custom-title-wrap bar-warning">
                      <div class="custom-title">Form Import Data Sekolah</div>
                  </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="modal-body">
              <form action="{{url('/importDataSekolah')}}" method="post" enctype="multipart/form-data">
                  @csrf
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Tahun</label>
                {{Form::select('kode_tahun_akademik',$tahun_akademik,null,['class' => 'form-control show-tick']) }}
              </div>
              <div class="form-group">
                  <label for="message-text" class="col-form-label">Import File (.csv)</label>
                  <input type="file" class="form-control" name="file" required>

              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                {{Form::submit('Simpan Data',['class' => 'btn btn-primary']) }}
            </div>
            </form>
        </div>
    </div>
</div>
