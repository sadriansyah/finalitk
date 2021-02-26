<html>
<head>
    <title> Aplikasi SNMPTN & SBMPTN ITK </title>
    <link rel="stylesheet" type="text/css" href="{{asset('halaman_depan/style.css')}}">
</head>
    <body>
    <div class="login-box">
    <img src="{{asset('halaman_depan/avatar.png')}}" class="avatar">
        <h1>Login Sistem</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
          @if(session('gagal'))
          <div class="alert alert-danger" role="alert">
                {{session('gagal')}}
          </div>
          @endif
        </div>
            <form action="{{url('/postlogin')}}" method="post">
            @csrf

            <p>Username</p>
            <input type="text" name="username" placeholder="Enter Username">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <button type="submit" class="btn">Login</button>
            <a href="#">Forget Password</a>
            </form>


        </div>

    </body>
</html>
