@extends('layouts.auth-v2.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>
                Sistem Pendukung Keputusan
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>alamat</th>
                            <th>lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Andi</td>
                            <td>Padang</td>
                            <td>Padang</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection