@extends('layouts.auth-v1.main')

@section('content')
    <div class="card">
        <div class="card-header border-bottom mb-4 d-flex justify-content-between align-items-center">
            <h4 class="m-0 p-0">Data Kriteria</h4>
            <a href="{{ route('spk/destinasi/kriteria.create') }}" class="btn btn-sm btn-primary">Tambah Kriteria</a>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Kriteria</th>
                            <th>Nama Kriteria</th>
                            <th>Tipe Kriteria</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)       
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-uppercase">{{ $item->kode ?? '-' }}</td>
                                <td>{{ $item->name ?? '-' }}</td>
                                <td>{{ $item->tipe ?? '-' }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('spk/destinasi/kriteria.edit', encrypt($item->id)) }}" class="btn btn-sm btn-warning me-2"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('spk/destinasi/kriteria.destroy', encrypt($item->id)) }}">
                                        <button class="btn btn-sm btn-danger" type="submit"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection