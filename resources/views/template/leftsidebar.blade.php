 <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{asset('download.png')}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::guard('web')->user()->nama}}</div>
                    <div class="email">{{Auth::guard('web')->user()->role}}</div>

                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="{{url('/beranda')}}">
                            <i class="material-icons">home</i>
                            <span>Back To Dashboard</span>
                        </a>
                    </li>
                	@if(auth()->user()->role != "koorprodi" && auth()->user()->role != "kajur")
                    <li>
                      <a href="{{url('/fileprestasi')}}">
                          <i class="material-icons">layers</i>
                          <span>File Prestasi</span>
                      </a>
                    </li>
                @endif
                    @yield('prodi')
                    @yield('sbmptn')
                  </ul>



            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2021 <a href="javascript:void(0);">Dimas Saputra - Sadriansyah</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
