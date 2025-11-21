@extends('layouts.guest.landing-page')

@push('page-css')
    <style>
      body {
        background: url('/assets/img/bg-new.jpeg') no-repeat center center fixed;
        background-size: cover;
        color: white;
      }
      body::before {
          background-color: rgba(0, 0, 0, 0.6);
          content: "";
          position: fixed;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
      }

      .content-wrapper {
        /* padding-top: 120px; */
        position: relative;
        z-index: 1;
      }

      .card {
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
      }

      .card-title, .card-text {
        color: #333;
      }
      
      .page-title {
        color: #ffffff;
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
        letter-spacing: 1px;
        animation: fadeInDown 1s ease;
        position: relative;
      }

      .page-title::after {
        content: '';
        width: 80px;
        height: 4px;
        background-color: #ffffff;
        display: block;
        margin: 15px auto 0;
        border-radius: 10px;
      }

      @keyframes fadeInDown {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .card-img-top {
          height: 250px; /* atur sesuai kebutuhan, misal 250px */
          object-fit: cover;
          border-top-left-radius: 0.75rem;
          border-top-right-radius: 0.75rem;
      }
    </style>
@endpush

@section('content')
    <div class="container content-wrapper">
        <h2 class="page-title">Daftar Destinasi Wisata</h2>

        @if ($data->isNotEmpty())
            <div class="row g-4">
                @foreach ($data as $item)
                <div class="col-md-4">
                    <div class="card h-100">
                    <a href="{{ Storage::url($item->foto ?? '') }}">
                        <img src="{{ Storage::url($item->foto ?? '') }}" class="card-img-top" alt="{{ $item->foto ?? '' }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name ?? '-' }}</h5>
                        <p class="text-secondary small"><i class='bx bx-location-plus'></i>{{ $item->alamat ?? '' }}</p>
                        <p class="card-text">{{ Str::limit(($item->deskripsi ?? '-'), 100, '...') }}</p>
                    </div>
                    <div class="card-footer">
                      <a class="btn btn-sm btn-primary" href="{{ route('spk/destinasi/wisata.show', encrypt($item->id)) }}"><i class="bx bx-show"></i> Show more</a>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
        <div class="row">
        <div class="col-md">
            No Data Found
        </div>
        </div>
        @endif
    
    </div>
@endsection