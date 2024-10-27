@extends('layouts.auth-v2.main')

@section('content')
<div class="card">
    <div class="card-header border-bottom mb-4">
        <h4 class="mb-1">Hasil Penilaian</h4>
        <div class="small">
            Alternatif Wisata Yang direkomendasikan Berdasarkan Kriteria yang ada adalah:
        </div>
    </div>
    <div class="card-body">
        <h5>A. Alternatif</h5>
        <div class="nav-align-top mb-4">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->historyAlternatifValues->groupBy('alternative_id') as $histories)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @foreach ($histories as $detail)
                                        @if ($loop->first)
                                        <td>{{ $detail->alternative->name ?? '-' }}</td>
                                        @endif
                                        <td>{{ $detail->nilai_awal ?? '-' }}</td>
                                        @endforeach
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->historyAlternatifValues->groupBy('alternative_id') as $histories)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @foreach ($histories as $detail)
                                    @if ($loop->first)
                                    <td>{{ $detail->alternative->name ?? '-' }}</td>
                                    @endif
                                    <td>{{ $detail->nilai_normalisasi ?? '-' }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <h5>B. Preferensi</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap mb-4">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Wisata</th>
                            @foreach ($criterias->sortBy('id') as $cri)      
                                <th>{{ $cri->name ?? 'unknown' }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $arrPre = [];
                        @endphp
                        @foreach ($item->historyAlternatifValues->groupBy('alternative_id') as $key => $histories)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @foreach ($histories as $detail)
                                @if ($loop->first)
                                <td>{{ $detail->alternative->name ?? '-' }}</td>
                                @php
                                    $arrPre[$key]['alternative_id'] = $detail->alternative->id ?? '-';
                                    $arrPre[$key]['alternative_name'] = $detail->alternative->name ?? '-';
                                @endphp
                                @endif
                                <td>{{ $detail->nilai_preferensi ?? '-' }}</td>
                                @endforeach
                                <td>{{ $histories->sum('nilai_preferensi') }}</td>
                                @php
                                    $arrPre[$key]['preferensi'] = $histories->sum('nilai_preferensi');
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <h5>C. Peringkat</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap mb-4">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nama Wisata</th>
                            <th>Total</th>
                            <th>Peringkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            usort($arrPre, function($a, $b) {
                                return $b['preferensi'] <=> $a['preferensi'];
                            });
    
                            // print_r($arrPre);
                        @endphp
                        @foreach ($arrPre as $index => $pre)
                            @if (in_array($pre['alternative_id'], $alts->pluck('id')->toArray()))
                            <tr>
                                <td>{{ $pre['alternative_name'] ?? '-' }}</td>
                                <td>{{ $pre['preferensi'] ?? '-' }}</td>
                                <td>{{ $loop->iteration }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <h5 class="bg-label-dark p-4">Berdasarkan hasil penilaian dari beberapa objek wisata sesuai kriteria yang telah diberikan, 
                    maka direkomendasikan objek wisata dengan nama <span class="text-primary text-uppercase">{{ $arrPre[0]['alternative_name'] }}</span> dengan skor penilaian <span class="text-primary text-uppercase">{{ $arrPre[0]['preferensi'] }}</span></h5>
            </div>
        </div>
    </div>
</div>
@endsection