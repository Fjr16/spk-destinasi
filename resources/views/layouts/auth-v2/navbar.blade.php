<nav class="navbar navbar-expand-xl navbar-dark bg-primary">
  <div class="container-fluid">
   <a class="navbar-brand" href="{{ route('spk/destinasi/home.index') }}">SPK Destinasi</a>
   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-7">
   <span class="navbar-toggler-icon"></span>
   </button>

   <div class="collapse navbar-collapse" id="navbar-ex-7">
   <div class="navbar-nav me-auto">
      <a class="nav-item nav-link {{ $title == 'Home' ? 'active' : '' }}" href="{{ route('spk/destinasi/home.index') }}">Home</a>
      <a class="nav-item nav-link {{ $title == 'Rekomendasi' ? 'active' : '' }}" href="{{ route('spk/destinasi/rekomendasi.create') }}">Temukan Rekomendasi</a>
   </div>
   <ul class="navbar-nav ms-lg-auto">
      {{-- <li class="nav-item">
         <a class="nav-link" href="javascript:void(0)"><i class="tf-icons navbar-icon bx bx-user"></i> Profile</a>
      </li> --}}
      <li class="nav-item">
         <a class="nav-link" href="javascript:void(0)"><i class="tf-icons navbar-icon bx bx-lock-open-alt"></i> Logout</a>
      </li>
   </ul>
   </div>
  </div>
</nav>