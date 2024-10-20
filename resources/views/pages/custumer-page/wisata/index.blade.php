@extends('layouts.auth-v2.main')

@section('content')
    <div class="card">
        <div class="card-header border-bottom mb-4">
            <h4>
                Daftar Objek Wisata
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="datatable">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-light">#</th>
                            <th class="text-light">nama Wisata</th>
                            <th class="text-light">alamat</th>
                            <th class="text-light">Biaya</th>
                            <th class="text-light">Rating (1-10)</th>
                            <th class="text-light">Jumlah Fasilitas</th>
                            <th class="text-light">Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)                            
                            <tr class="table-primary">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name ?? 'unknonw' }}</td>
                                <td class="text-wrap">{{ $item->alamat ?? 'unknown' }}</td>
                                <td>{{ number_format($item->harga ?? 0) }}</td>
                                <td>{{ $item->rating ?? 'undefined' }}</td>
                                <td>{{ $item->jumlah_fasilitas ?? 'undefined' }}</td>
                                <td>
                                    <a href="{{ Storage::url($item->foto) }}" target="_blank">
                                        <img class="img-fluid" src="{{ Storage::url($item->foto ?? '') }}" alt="{{ $item->foto ?? '' }}" width="200" height="200"></td>
                                    </a>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection