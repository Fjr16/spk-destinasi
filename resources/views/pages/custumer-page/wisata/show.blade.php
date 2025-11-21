@extends('layouts.guest.landing-page')


@push('page-css')
<style>
  body {
    background: url('/assets/img/bg-new.jpeg') no-repeat center center fixed;
    background-size: cover;
    color: white;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.65);
    z-index: -1;
  }

  .card {
    background-color: rgba(255, 255, 255, 0.95);
    border: none;
    border-radius: 1rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    margin-bottom: 2rem;
    overflow: hidden;
  }

  .card-header {
    background-color: transparent;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #ddd;
    text-align: center;
  }

  .card-header h2 {
    color: #333;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0;
  }

  .detail-section {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    padding: 2rem;
  }

  .detail-image {
    flex: 1 1 40%;
    max-width: 500px;
  }

  .detail-image img {
    border-radius: 1rem;
    width: 100%;
    height: auto;
    object-fit: cover;
  }

  .detail-info {
    flex: 1 1 55%;
  }

  .detail-info table {
    width: 100%;
  }

  .detail-info td {
    padding: 0.6rem;
    color: #333;
    font-size: 1rem;
  }

  .detail-info td:first-child {
    font-weight: 600;
    width: 150px;
    white-space: nowrap;
  }

  .card-footer {
    background-color: rgba(255,255,255,0.95);
    border-top: 1px solid #eee;
    padding: 1.5rem 2rem;
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
  }

  .fst-italic {
    font-style: italic;
  }

  .text-dark {
    color: #333 !important;
  }

  #map {
    width: 100%;
    height: 350px;
    border-radius: 1rem;
    border: 1px solid #ccc;
    margin-top: 1.5rem;
  }

  @media (max-width: 768px) {
    .detail-section {
      flex-direction: column;
      padding: 1rem;
    }
  }
</style>
@endpush



@section('content')
<div class="container content-wrapper">
    <div class="card">
    <div class="card-header">
        <h2>{{ $item->name ?? 'Unknown' }}</h2>
    </div>
    <div class="detail-section">
        <div class="detail-image">
            <a href="{{ Storage::url($item->foto ?? '') }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="{{ $item->name }}">
            </a>
        </div>
        <div class="detail-info">
        <table class="table table-borderless">
            <tr><td>Waktu Operasional</td><td>: {{ $item->waktu_operasional ?? '-' }}</td></tr>
            <tr><td>Kategori Wisata</td><td>: {{ $item->travelCategory->name ?? '-' }}</td></tr>
            <tr><td>Harga / Tarif</td><td>: Rp. {{ number_format($item->harga ?? 0) }}</td></tr>
            <tr><td>Fasilitas</td><td>: {{ $item->fasilitas ?? '-' }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $item->alamat ?? '-' }}</td></tr>
            <tr><td>Aksesibilitas</td><td>: {{ $item->aksesibilitas ?? '-' }}</td></tr>
        </table>
        </div>
    </div>

    <div class="px-4 pb-4">
        <input type="hidden" id="maps-lokasi" value="{{ $item->maps_lokasi ?? '' }}"/>
        <div id="map"></div>
    </div>

    <div class="card-footer">
        <span class="fw-bold fst-italic">{{ $item->name ?? '-' }}</span><br>
        <span class="text-dark">{{ $item->deskripsi ?? '-' }}</span>
    </div>
    </div>
</div>
@endsection
