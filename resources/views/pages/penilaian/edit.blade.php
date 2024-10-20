@extends('layouts.auth-v1.main')
@section('content')
    <div class="card">
        <div class="card-header mb-4">
            <h4 class="mb-0">Edit Penilaian <span class="text-primary">{{ $item->name ?? '-' }}</span</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('spk/destinasi/penilaian.update', encrypt($item->id)) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- input nilai kriteria --}}
                @foreach ($criterias as $index => $criteria)
                <div class="mb-3 row">
                    <input type="hidden" name="penilaian[{{ $index }}][criteria_id]" value="{{ $criteria->id }}" required>
                    <label for="{{ ($criteria->name ?? 'unknown') . $loop->iteration }}" class="col-md-2 col-form-label">{{ $criteria->name ?? 'unknown' }}</label>
                    <div class="col-md-10">
                        <select class="form-select" name="penilaian[{{ $index }}][sub_criteria_id]" id="{{ ($criteria->name ?? 'unknown') . $loop->iteration }}" aria-label="Default select example" required>
                            <option selected disabled>Pilih Nilai</option>
                            @foreach ($criteria->subCriterias as $sub)
                                <option value="{{ $sub->id ?? 0 }}" {{ $item->performanceRatings->where('criteria_id', $criteria->id)->pluck('sub_criteria_id')->first() == $sub->id ? 'selected' : '' }}>{{ $sub->name ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endforeach
                <div class="my-4 col-12 border-top pt-4 d-flex justify-content-center">
                    <a href="{{ route('spk/destinasi/penilaian.index') }}" class="btn btn-md btn-outline-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                    <button type="submit" class="btn btn-md btn-outline-success"><i class="bx bx-file"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection