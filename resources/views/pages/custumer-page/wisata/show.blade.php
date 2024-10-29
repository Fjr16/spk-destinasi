@extends('layouts.auth-v2.main')

@section('content')
    <div class="card border">
        <div class="card-header border-bottom py-3 pb-0 mb-0">
            <h2>
                {{ $item->name ?? 'Unknown' }}
            </h2>
        </div>
        <div class="card-body rounded pb-0 p-1">
            <div class="card mb-4">
                <div class="row g-0 mb-0 pb-4 border-bottom">
                    <div class="col-md-4 pt-3 ps-3">
                        <img class="card-img card-img-left" src="{{ Storage::url($item->foto ?? '') }}" alt="Card image" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body pt-2">
                            <div class="card-text mt-0">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-nowrap">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold text-capitalized">Kategori Wisata</td>
                                                <td  class="d-flex text-wrap">
                                                    : {{ $item->travelCategory->name ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-capitalized">Peringkat</td>
                                                <td  class="d-flex text-wrap">
                                                    : {{ $item->rating ?? '0' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-capitalized">Harga / Tarif</td>
                                                <td  class="d-flex text-wrap">
                                                    : {{ 'Rp. ' . number_format($item->harga ?? 0) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-capitalized">Fasilitas</td>
                                                <td  class="d-flex text-wrap">
                                                    : {{ $item->fasilitas ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-capitalized">Alamat</td>
                                                <td  class="d-flex text-wrap">
                                                    : {{ $item->alamat ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-capitalized">Aksesibilitas</td>
                                                <td  class="d-flex text-wrap">
                                                    : {{ $item->aksesibilitas ?? '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3">
                                        <input type="hidden" id="maps-lokasi" value="{{ $item->maps_lokasi ?? '' }}"/>
                                        <div id="map" style="width: 100%; height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer m-3 bg-label-primary">
                    <span  class="fw-bold fst-italic d-block">{{ $item->name ?? '-' }}</span>
                    <span class="text-dark">
                        {{ $item->deskripsi ?? '-' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection