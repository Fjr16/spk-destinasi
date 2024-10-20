@extends('layouts.auth-v1.main')
@section('content')

    <div class="accordion mb-2" id="accordionExample">
        <div class="card accordion-item active p-2">
            <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne" role="tabpanel">
                    <i class="bx bx-plus"></i> Penilaian
                </button>
            </h2>
        
            <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body px-5 py-2">
                    <form action="{{ route('spk/destinasi/penilaian.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <label for="alternatif-wisata" class="col-md-2 col-form-label">Alternatif Wisata</label>
                            <div class="col-md-10">
                                <select class="form-select" id="alternatif-wisata" name="alternative_id" aria-label="Default select example" required>
                                    <option selected disabled>Pilih Wisata</option>
                                    @foreach ($alts as $alt)
                                        <option value="{{ $alt->id }}">{{ $alt->name ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- input nilai kriteria --}}
                        @foreach ($criterias as $index => $criteria)
                        <div class="mb-3 row">
                            <input type="hidden" name="penilaian[{{ $index }}][criteria_id]" value="{{ $criteria->id }}" required>
                            <label for="{{ ($criteria->name ?? 'unknown') . $loop->iteration }}" class="col-md-2 col-form-label">{{ $criteria->name ?? 'unknown' }}</label>
                            <div class="col-md-10">
                                <select class="form-select" name="penilaian[{{ $index }}][sub_criteria_id]" id="{{ ($criteria->name ?? 'unknown') . $loop->iteration }}" aria-label="Default select example" required>
                                    <option selected disabled>Pilih Nilai</option>
                                    @foreach ($criteria->subCriterias as $sub)
                                        <option value="{{ $sub->id ?? 0 }}">{{ $sub->name ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach
                        <div class="my-4 row border-top pt-2">
                                <button type="submit" class="btn btn-md btn-outline-success"><i class="bx bx-file"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header mb-0">
            <h4 class="mb-1">Data Penilaian</h4>
            <div class="small">
                Data Peniliaian Alternatif Wisata Berdasarkan Kriteria.
                @if ($isJarakInclude)
                    Terkecuali untuk kriteria jarak, karena jarak dihitung berdasarkan lokasi pengguna dan lokasi wisata.
                @endif
            </div>
        </div>
        <div class="card-body bg-label-dark pt-2 p-2">
            <div class="nav-align-top">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Un(Normalisasi)</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">Normalisasi</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Wisata</th>
                                        @foreach ($criterias->sortBy('id') as $cri)      
                                            <th>{{ $cri->name ?? 'unknown' }}</th>
                                        @endforeach
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name ?? '-' }}</td>
                                            @if ($item->performanceRatings->isNotEmpty())         
                                                @foreach ($item->performanceRatings->sortBy('criteria_id') as $r)
                                                    <td>{{ $r->subCriteria->bobot ?? $r->nilai }}</td>
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $criterias->count(); $i++)
                                                    <td>-</td>
                                                @endfor
                                            @endif
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('spk/destinasi/penilaian.edit', encrypt($item->id)) }}" class="btn btn-icon btn-outline-warning mx-2"><i class="bx bx-edit"></i></a>
                                                    <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('spk/destinasi/penilaian.destroy', encrypt($item->id)) }}" onclick="showModalDelete(this)">
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
                    <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Wisata</th>
                                        @foreach ($criterias->sortBy('id') as $cri)      
                                            <th>{{ $cri->name ?? 'unknown' }}</th>
                                        @endforeach
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name ?? '-' }}</td>
                                            @if ($item->performanceRatings->isNotEmpty())         
                                                @foreach ($item->performanceRatings->sortBy('criteria_id') as $r)
                                                    <td>{{ $r->normalisasi ?? '0'  }}</td>
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $criterias->count(); $i++)
                                                    <td>-</td>
                                                @endfor
                                            @endif
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('spk/destinasi/penilaian.edit', encrypt($item->id)) }}" class="btn btn-icon btn-outline-warning mx-2"><i class="bx bx-edit"></i></a>
                                                    <button class="btn btn-icon btn-outline-danger" type="button" data-url="{{ route('spk/destinasi/penilaian.destroy', encrypt($item->id)) }}" onclick="showModalDelete(this)">
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
            </div>
        </div>
    </div>

    <x-modal-confirm-delete>
        Apakah anda yakin ingin menghapus data Penilaian ini ?
    </x-modal-confirm-delete>
@endsection