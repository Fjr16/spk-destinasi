<!doctype html>
<html lang="en">
  <head>
  	<title>SPK | {{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

	
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .body {
            margin: auto;
        }
        .container { 
            width:90%;
            border-radius:20px;
            backdrop-filter:blur(10px);
            text-align:center;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            max-width: 450px;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .container p {
            font-size: 14px;
            margin-bottom: 30px;
        }
    </style>


	</head>
	<body class="img row" style="background-image: url(assets/img/bg.jpg);">
        <div class="col-md-6 img" style="background: overlay; margin:auto;">
            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-md-12 text-start mb-4">
                            <h2 class="heading-section mb-4 text-uppercase">Registrasi Akun</h2>
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-md-6 col-lg-12">
                            <div class="login-wrap p-0">
                                <form action="{{ route('register') }}" class="signin-form" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Nama Lengkap" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" placeholder="Email Pengguna" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required>
                                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary submit px-3">Sign Up</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <script src="{{ asset('assets/guest/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/guest/js/popper.js') }}"></script>
        <script src="{{ asset('assets/guest/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/guest/js/main.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script>
            const notif = new Notyf({
                duration: 0,
                dismissible:true,
                position: {
                    x:'right',
                    y:'top'
                }
            }) ;

            @if (session('error'))
                notif.error("{{ session('error') ?? 'Terjadi Kesalahan Sistem' }}")
            @endif
            @if (session('success'))
                notif.success("{{ session('success') ?? 'Berhasil Simpan Data' }}")
            @endif
        </script>

	</body>
</html>

