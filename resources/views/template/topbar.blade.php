<!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="{{url('/beranda')}}">Aplikasi SNMPTN dan SBPMTN ITK</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="{{url('/logout')}}" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
                            <i class="material-icons">exit_to_app</i>
                        </a>
                    </li>
                  
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
