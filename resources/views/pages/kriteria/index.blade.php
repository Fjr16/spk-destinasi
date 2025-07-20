@extends('layouts.auth-v1.main')

@section('content')
    <div class="card">
        <div class="card-header border-bottom mb-4 d-flex justify-content-between align-items-center">
            <h4 class="m-0 p-0">Data Kriteria</h4>
            @can('admin')
            <a href="{{ route('spk/destinasi/kriteria.create') }}" class="btn btn-sm btn-primary">Tambah Kriteria</a>
            @endcan
        </div>
        <div class="card-body">
            @foreach ($data as $item)      
                <div class="card p-5 mb-5 shadow-none {{ $item->is_include == true  ? 'bg-label-secondary' : 'bg-label-danger' }}">
                    <div class="card-header p-0 border-bottom pb-2">
                        <div class="row justify-content-between">
                            <div class="col-8">
                                <h5 class="mb-1">Kriteria : {{ $item->name ?? '-' }} (<span class="text-uppercase">{{ $item->kode ?? '-' }}</span>) <span class="badge bg-{{ $item->tipe == 'cost' ? 'primary' : 'info' }}">{{ $item->tipe ?? '-' }}</span></h5>
                                <span class="badge bg-{{ $item->jenis == 'kuantitatif' ? 'danger' : 'warning' }} fw-bold">{{ $item->jenis ?? '' }}</span>
                            </div>
                            @can('admin')     
                            <div class="col-4 d-flex justify-content-end">
                                <a href="{{ route('spk/destinasi/kriteria.edit', encrypt($item->id)) }}" class="btn btn-icon btn-outline-warning me-2"><i class="bx bx-edit"></i></a>
                                @if ($item->atribut == 'dinamis')
                                    <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('spk/destinasi/kriteria.destroy', encrypt($item->id)) }}" onclick="showModalDelete(this)">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                @else
                                    <form action="{{ route('spk/destinasi/kriteria.activated', encrypt($item->id)) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-icon {{ $item->is_include == true ? 'btn-outline-danger' : 'btn-outline-primary' }}" type="submit"><i class="{{ $item->is_include == true ? 'bx bx-x-circle' : 'bx bx-check-circle' }}"></i></button>
                                    </form>
                                @endif
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @can('admin')     
                            <div class="row my-3">
                                <div class="text-start">
                                    <a href="{{ route('spk/destinasi/sub/kriteria.create', encrypt($item->id)) }}" class="btn btn-sm btn-outline-primary">+ Sub Kriteria</a>
                                </div>
                            </div>
                        @endcan
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Label Sub Kriteria</th>
                                        <th>Nilai Minimum</th>
                                        <th>Nilai Maksimum</th>
                                        <th>Bobot</th>
                                        <th>Bobot Normalisasi</th>
                                        @can('admin')
                                        <th>Aksi</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totBobotSub = $item->subCriterias->sum('bobot');
                                    @endphp
                                    @foreach ($item->subCriterias as $sub)       
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-wrap">{{ $sub->label ?? '-' }}</td>
                                            <td>{{ $sub->formatted_min_value ?? '-' }}</td>
                                            <td>{{ $sub->formatted_max_value ?? '-' }}</td>
                                            <td>{{ $sub->bobot ?? 0 }}</td>
                                            <td>{{ ($sub->bobot ?? 0)/($totBobotSub ?? 0) }}</td>
                                            @can('admin')      
                                            <td class="d-flex">
                                                <a href="{{ route('spk/destinasi/sub/kriteria.edit', encrypt($sub->id)) }}" class="btn btn-icon btn-outline-warning me-2"><i class="bx bx-edit"></i></a>
                                                <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('spk/destinasi/sub/kriteria.destroy', encrypt($sub->id)) }}" onclick="showModalDelete(this)">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-modal-confirm-delete>
        Apakah anda yakin ingin menghapus data ini ?
    </x-modal-confirm-delete>
@endsection