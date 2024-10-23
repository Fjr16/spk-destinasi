@extends('layouts.auth-v1.main')

@section('content')
    <div class="card">
        <div class="card-header mb-4 border-bottom">
            <h4 class="m-0 p-0">Tambah Alternatif Wisata</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('spk/destinasi/user.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="useri-wisata" class="form-label">Nama User</label>
                        <input type="text" class="form-control form-control-md" id="nama-user" name="name" placeholder="Nama User" value="{{ old('name') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-md" id="email" name="email" placeholder="Email User" value="{{ old('email') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-md" id="username" name="username" placeholder="Masukkan Username Anda" value="{{ old('username') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Username</label>
                        <input type="password" class="form-control form-control-md" id="password" name="password" placeholder="Buat Password" required />
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select form-select-md">
                            <option value="Pengelola" {{ old('role') == 'Pengelola' ? 'selected' : '' }}>Pengelola</option>
                            <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-4 border-top">
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('spk/destinasi/user.index') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                            <button type="submit" class="btn btn-md btn-success"><i class="bx bx-file"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection