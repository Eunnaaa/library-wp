@extends('admin.layout.main')

@section('title', 'Detail User')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-id-card mr-1"></i> Informasi Lengkap Pengguna</h3>
                </div>
                <div class="card-body text-center">
                    <img class="profile-user-img img-fluid img-circle mb-3"
                        src="{{ asset('storage/' . ($user->image ?? 'profil-pic/default.jpg')) }}"
                        alt="Foto User" style="width: 130px; height: 130px; object-fit: cover;">

                    <h3>{{ $user->nama }}</h3>
                    <p class="text-muted">
                        @if($user->role_id == 1)
                            <span class="badge badge-primary">Administrator</span>
                        @else
                            <span class="badge badge-info">Anggota</span>
                        @endif
                    </p>

                    <table class="table table-bordered text-left mt-3">
                        <tr>
                            <th style="width: 35%;">ID Pengguna</th>
                            <td>#{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $user->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Status Akun</th>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Registrasi</th>
                            <td>{{ $user->created_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <a href="{{ route('admin.master.user.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <a href="{{ route('admin.master.user.edit', $user->id) }}" class="btn btn-warning"><i class="fas fa-edit mr-1"></i> Edit Data</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
