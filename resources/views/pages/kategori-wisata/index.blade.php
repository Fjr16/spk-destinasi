@extends('layouts.auth-v1.main')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between border-bottom mb-4">
            <h4 class="m-0 p-0">Data Kategori Wisata</h4>
            <a href="{{ route('spk/destinasi/kategori/wisata.create') }}" class="btn btn-sm btn-primary">Tambah Kategori</a>
        </div>
        <div class="card-body">
            <div class="table-responsive text-wrap">
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name ?? '-' }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('spk/destinasi/kategori/wisata.edit', encrypt($item->id)) }}" class="btn btn-icon btn-outline-warning mx-2"><i class="bx bx-edit"></i></a>
                                        <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('spk/destinasi/kategori/wisata.destroy', encrypt($item->id)) }}" onclick="showModalDelete(this)">
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
        Apakah anda yakin ingin menghapus data Kategori wisata ini ?
    </x-modal-confirm-delete>
@endsection

