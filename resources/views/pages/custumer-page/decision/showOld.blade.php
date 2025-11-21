{{-- @extends('layouts.auth-v2.main') --}}
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
        padding-bottom: 30px;
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

        .card.overlay-card {
            /* background-color: rgba(255, 255, 255, 0.15); transparan putih */
            background-color: rgba(75, 75, 75, 0.4);
            backdrop-filter: blur(10px);                /* blur latar belakang */
            -webkit-backdrop-filter: blur(10px);        /* support Safari */
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .overlay-card label,
        .overlay-card h5,
        .overlay-card .form-control,
        .overlay-card .form-control::placeholder,
        .overlay-card select {
            color: white;
        }
        .overlay-card .form-control,
        .overlay-card .form-select {
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }
    </style>
@endpush

@section('content')
<div class="container content-wrapper">
    <div class="page-title">TOP 5 Destinasi Hasil Rekomendasi</div>
    <div class="card overlay-card">
        <div class="card-body p-5">
            <div class="card position-relative p-4" style="background-color: rgba(255, 255, 255, 0.1)">
                <h5>A. Matriks Perbandingan AHP (Converted Skala Saaty)</h5>
                <div class="ms-4">
                    <span class="badge bg-primary">Sumber: Data Preferensi Pengguna</span>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive text-nowrap mb-4">
                        <table class="table table-hover table-striped table-borderless align-middle text-center rounded-3 overflow-hidden shadow-sm">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th>Kriteria</th>
                                    @foreach ($kriterias as $row)
                                    <th>{{ $row ?? '-' }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($kriterias as $row)
                                    <tr>
                                        <th class="bg-light">{{ $row }}</th>
                                        @foreach ($kriterias as $col)
                                            <td>{{ $matriks[$row][$col] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <tr class="fw-bold">
                                    <td class="text-danger">Total</td>
                                    @foreach ($kriterias as $col)
                                        <td class="text-danger">{{ $criteriaTotals[$col]->total ?? 0 }}</td>
                                    @endforeach
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <h5>B. Matriks Perbandingan AHP (Normalized)</h5>
                <div class="ms-4">
                    <span class="badge bg-primary">Sumber: normalisasi[row-n][col-n] = nilai[row-n][col-n] / total[col-n]</span>
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap mb-4">
                        <table class="table table-hover table-striped table-borderless align-middle text-center rounded-3 overflow-hidden shadow-sm">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th>Kriteria</th>
                                    @foreach ($kriterias as $row)
                                    <th>{{ $row ?? '-' }}</th>
                                    @endforeach
                                    <th>Rata-rata (Bobot)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($kriterias as $row)
                                    <tr>
                                        <th class="bg-light">{{ $row }}</th>
                                        @foreach ($kriterias as $col)
                                            <td>{{ $matriksNormalisasi[$row][$col] }}</td>
                                        @endforeach
                                        <td class="fw-bold text-danger">{{ $criteriaTotals[$row]->bobot ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <h5>C. Nilai Alternatif Wisata Terhadap Kriteria (Normalized)</h5>
                <div class="ms-4">
                    <span class="badge bg-primary">Sumber: Bobot real dari nilai kriteria yang dinormalisasi</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap mb-4">
                        <table class="table table-hover table-striped table-borderless align-middle text-center rounded-3 overflow-hidden shadow-sm">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th>Nama Wisata</th>
                                    @foreach (array_keys($mappedAlternatif->first()) as $key)
                                    @if ($key !== 'Nama Alternatif')
                                    <th>{{ $key }}</th>
                                    @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($mappedAlternatif as $row)
                                    <tr>
                                        <td class="fw-semibold text-capitalize">{{ $row['Nama Alternatif'] }}</td>
                                        @foreach ($row as $key => $value)
                                            @if ($key !== 'Nama Alternatif')
                                                <td>{{ $value ?? 0 }}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <h5>Hasil Akhir AHP</h5>
                <div class="ms-4">
                    <span class="badge bg-primary">Sumber: &sum;(bobot kriteria x nilai alternatif)</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap mb-4">
                        <table class="table table-hover table-striped table-borderless align-middle text-center rounded-3 overflow-hidden shadow-sm">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 35%">Nama Wisata</th>
                                    <th style="width: 20%">Skor Akhir</th>
                                    <th style="width: 15%">Peringkat</th>
                                    <th style="width: 25%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $item['wisata']->name ?? '-' }}</td>
                                        <td>{{ $item['skor_akhir'] }}</td>
                                        <td>
                                            <span class="badge {{ $item['ranking'] == 1 ? 'bg-warning text-dark' : 'bg-primary' }} rounded-pill px-3 py-2 fs-6">{{ $item['ranking'] }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('spk/destinasi/wisata.show', encrypt($item['wisata']->id)) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="bx bx-show me-1"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-0">
                        <h5 class="bg-label-dark p-4">
                            Berdasarkan hasil penilaian dari beberapa objek wisata sesuai preferensi yang telah diberikan, maka direkomendasikan objek wisata 
                            <span class="text-warning fw-bold text-uppercase">{{ $data[0]['wisata']->name }}</span>
 
                            dengan skor AHP sebesar 
                            <span class="text-warning fw-semibold">{{ $data[0]['skor_akhir'] }}</span>
                        </h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection