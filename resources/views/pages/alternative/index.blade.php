@extends('layouts.auth-v1.main')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between border-bottom mb-4">
            <h4 class="m-0 p-0">Data Alternatif Wisata</h4>
            <a href="{{ route('spk/destinasi/alternative.create') }}" class="btn btn-sm btn-primary">Tambah Alternatif</a>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Name</th>
                            {{-- <th>Deskripsi</th> --}}
                            <th>Alamat</th>
                            <th>Harga</th>
                            <th>Lokasi</th>
                            <th>Kategori</th>
                            {{-- <th>Rating</th> --}}
                            {{-- <th>Jumlah Fasilitas</th> --}}
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ Storage::url($item->foto ?? '') }}" target="_blank">
                                        <img src="{{ Storage::url($item->foto ?? '') }}" alt="{{ $item->foto ?? 'unknown' }}" class="img-fluid" width="180" height="180">
                                    </a>
                                </td>
                                <td>{{ $item->name ?? '-' }}</td>
                                {{-- <td>{{ $item->deskripsi ?? '-' }}</td> --}}
                                <td>{{ $item->alamat ?? '-' }}</td>
                                <td>{{ $item->harga ?? '-' }}</td>
                                <td>{{ $item->maps_lokasi ?? '-' }}</td>
                                <td>{{ $item->travelCategory->name ?? '-' }}</td>
                                {{-- <td>{{ $item->rating ?? '-' }}</td> --}}
                                {{-- <td>{{ $item->jumlah_fasilitas ?? '-' }}</td> --}}
                                <td>{{ $item->status ?? '-' }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('spk/destinasi/alternative.show', encrypt($item->id)) }}" class="btn btn-icon btn-outline-info"><i class="bx bx-detail"></i></a>
                                        <a href="{{ route('spk/destinasi/alternative.edit', encrypt($item->id)) }}" class="btn btn-icon btn-outline-warning mx-2"><i class="bx bx-edit"></i></a>
                                        <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('spk/destinasi/alternative.destroy', encrypt($item->id)) }}" onclick="showModalDelete(this)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal-confirm-delete>
        Apakah anda yakin ingin menghapus data alternatif wisata ini ?
    </x-modal-confirm-delete>
@endsection

