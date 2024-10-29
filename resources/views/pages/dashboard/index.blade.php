@extends('layouts.auth-v1.main')

@section('content')
  <div class="row">
      <div class="col-lg-12 mb-1 order-0">
        <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->name ?? '-' }} ({{ auth()->user()->role ?? '-' }})! 🎉</h5>
                <p class="mb-0">
                  Profesional, Berintegritas, Responsif, User Friendly, dan Fokus Pada Kenyamanan Pengguna.
                </p>
              </div>
        </div>
      </div>
  </div>
  <div class="row">
    <div class="col-md">
      <div class="card text-white bg-primary">
        <div class="card-body">
          <h4 class="text-white">Total Alternatif</h4>
          <hr>
          <h1 class="text-white">{{ $alt->count() ?? 'unknown' }}</h1>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-white bg-secondary">
        <div class="card-body">
          <h4 class="text-white">Total Kriteria</h4>
          <hr>
          <h1 class="text-white">{{ $cri->count() ?? 'unknown' }}</h1>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card text-white bg-dark">
        <div class="card-body">
          <h4 class="text-white">Total Pengguna</h4>
          <hr>
          <h1 class="text-white">{{ $user->count() ?? 'unknown' }}</h1>
        </div>
      </div>
    </div>
  </div>

    <div class="nav-align-top mt-4">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-align-home">Alternatif</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-align-profile">Kriteria</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-align-messages">Pengguna</button>
        </li>
      </ul>
      <div class="tab-content border">
        <div class="tab-pane fade show active" id="navs-left-align-home">
         <div class="table-responsive">
          <table class="table table-sm text-nowrap">
            <thead class="table-secondary">
              <tr>
                <th>Nama Wisata</th>
                <th>Alamat</th>
                <th>Harga</th>
                <th>Rating</th>
                <th>Fasilitas</th>
                <th>Foto</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($alt->take(5) as $a)                  
                <tr>
                  <td>{{ $a->name ?? '-' }}</td>
                  <td class="text-wrap">{{ $a->alamat ?? '-' }}</td>
                  <td>{{ number_format($a->harga ?? 0) }}</td>
                  <td>{{ $a->rating ?? 0 }}</td>
                  <td class="text-wrap">{{ $a->fasilitas ?? '-' }}</td>
                  <td>
                    <a href="{{ Storage::url($a->foto ?? '-') }}">
                      <img src="{{ Storage::url($a->foto ?? '-') }}" class="img-fluid" width="100" height="100" alt="">
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="table-footer">
            <a href="{{ route('spk/destinasi/alternative.index') }}" class="btn btn-sm btn-outline-primary">Lihat Selengkapnya ..</a>
          </div>
         </div>
        </div>

        <div class="tab-pane fade" id="navs-left-align-profile">
          <div class="table-responsive">
            <table class="table" id="dataTable">
              <thead class="table-secondary">
                <tr>
                  <th>Kode Kriteria</th>
                  <th>Nama Kriteria</th>
                  <th>Tipe</th>
                  <th>Bobot</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($cri->take(5) as $r)                    
                  <tr>
                    <td>{{ $r->kode ?? '-' }}</td>
                    <td>{{ $r->name ?? '-' }}</td>
                    <td>{{ $r->tipe ?? '-' }}</td>
                    <td>{{ $r->bobot ?? '-' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="table-footer">
              <a href="{{ route('spk/destinasi/kriteria.index') }}" class="btn btn-sm btn-outline-primary">Lihat Selengkapnya ..</a>
            </div>
           </div>
        </div>
        <div class="tab-pane fade" id="navs-left-align-messages">
          <div class="table-responsive">
            <table class="table" id="dataTable">
              <thead class="table-secondary">
                <tr>
                  <th>Nama Pengguna</th>
                  <th>Email</th>
                  <th>Username</th>
                  <th>Role</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($user as $usr)
                    
                @endforeach
                <tr>
                  <td>{{ $usr->name ?? '-' }}</td>
                  <td>{{ $usr->email ?? '-' }}</td>
                  <td>{{ $usr->username ?? '-' }}</td>
                  <td>{{ $usr->role ?? '-' }}</td>
                </tr>
              </tbody>
            </table>
            <div class="table-footer">
              <a href="{{ route('spk/destinasi/user.index') }}" class="btn btn-sm btn-outline-primary">Lihat Selengkapnya ..</a>
            </div>
           </div>
        </div>
      </div>
    </div>
@endsection
