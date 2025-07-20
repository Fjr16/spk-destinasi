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
                            <th>Nama Destinasi</th>
                            <th>Waktu Operasional</th>
                            <th>Alamat</th>
                            <th>Harga</th>
                            <th>Lokasi</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            @can('admin')
                            <th>Konfirmasi</th>
                            <th>Action</th>
                            @endcan
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
                                <td>{{ $item->waktu_operasional ?? '-' }}</td>
                                <td>{{ $item->alamat ?? '-' }}</td>
                                <td class="text-nowrap">{{ 'Rp. ' . number_format($item->harga ?? 0) }}</td>
                                <td>{{ $item->maps_lokasi ?? '-' }}</td>
                                <td>{{ $item->travelCategory->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status == 'accepted' ? 'success' : ($item->status == 'denied' ? 'danger' : 'warning') }}">{{ $item->status ?? '-' }}</span>
                                </td>
                                @can('admin')     
                                <td>
                                    <div class="d-flex">
                                        <form action="{{ route('spk/destinasi/alternative.confirm', encrypt($item->id)) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                            @if ($item->status == 'waiting')
                                                <button class="btn btn-icon btn-outline-success" type="submit" name="status" value="accepted"><i class="bx bx-check"></i></button>
                                                <button class="btn btn-icon btn-outline-danger" type="submit" name="status" value="denied"><i class="bx bx-x"></i></button>
                                            @elseif($item->status == 'accepted')
                                                <button class="btn btn-icon btn-outline-danger" type="submit" name="status" value="denied"><i class="bx bx-x"></i></button>
                                            @else
                                                <button class="btn btn-icon btn-outline-success" type="submit" name="status" value="accepted"><i class="bx bx-check"></i></button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('spk/destinasi/alternative.edit', encrypt($item->id)) }}" class="btn btn-icon btn-outline-warning me-1"><i class="bx bx-edit"></i></a>
                                            
                                        <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('spk/destinasi/alternative.destroy', encrypt($item->id)) }}" onclick="showModalDelete(this)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                @endcan
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

