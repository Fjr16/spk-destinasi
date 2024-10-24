@extends('layouts.auth-v1.main')

@section('content')
  <div class="row">
      <div class="col-lg-12 mb-1 order-0">
        <div class="card mb-4">
          {{-- <div class="d-flex align-items-end row"> --}}
            {{-- <div class="col-sm-7"> --}}
              <div class="card-body">
                <h5 class="card-title text-warning">Selamat Datang {{ auth()->user()->name ?? '-' }} ({{ auth()->user()->role ?? '-' }})! 🎉</h5>
                <p class="mb-4">
                  Profesional, Berintegritas, Responsif, dan Fokus Pada Keselamatan Pasien.
                </p>

              </div>
            {{-- </div> --}}
            {{-- <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="../assets/img/illustrations/medical-illustration-doctor.png"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/medical-illustration-doctor.png"
                  data-app-light-img="illustrations/medical-illustration-doctor.png"
                />
              </div>
            </div>
          </div> --}}
        </div>
      </div>
  </div>
@endsection
