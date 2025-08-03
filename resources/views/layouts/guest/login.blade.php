<!doctype html>
<html lang="en">
  <head>
  	<title>SPK | Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


	</head>
	<body class="img row" style="background-image: url(assets/img/bg.jpg);">
        <div class="col-md-5 img body" style="background: overlay;">
            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-md-12 text-start mb-4">
                            <h2 class="heading-section mb-4">Padang Eksplorasi, <br> Temukan Tempat Wisata Terbaik</h2>
                            <p class="text-white">Masuk dengan data yang anda masukkan saat pendaftaran.</p>
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-md-6 col-lg-12">
                            <div class="login-wrap p-0">
                                <form action="{{ route('login') }}" class="signin-form" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" required>
                                    </div>
                                    <div class="form-group">
                                    <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ route('register') }}" style="color: white; text-decoration:underline;">
                                            Don't have an account ? register here
                                        </a>
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
                duration: 2000,
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

