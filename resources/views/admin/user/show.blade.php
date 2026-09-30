@extends('admin.layout.main')

@section('title', 'Detail User')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-2 px-4 text-center">
                    <h4 class="font-weight-bold text-dark mb-0">
                        <i class="fas fa-id-card text-primary mr-2"></i>Detail Informasi Pengguna
                    </h4>
                    <p class="text-muted small mb-0">Rincian profil dan hak akses akun terdaftar</p>
                </div>

                <div class="card-body px-4 text-center">
                    <div class="my-3">
                        <img class="rounded-circle shadow-sm border"
                            src="{{ asset('storage/' . ($user->image ?? 'profil-pic/default.jpg')) }}"
                            alt="Foto {{ $user->nama }}"
                            style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important; border-color: #f1f5f9 !important;"
                            onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/default-150x150.png') }}';">
                    </div>

                    <h4 class="font-weight-bold text-dark mb-1">{{ $user->nama }}</h4>
                    <p class="text-muted mb-3">
                        @if($user->role_id == 1)
                            <span class="badge badge-primary px-3 py-1 font-weight-bold" style="border-radius: 6px;">
                                <i class="fas fa-shield-alt mr-1"></i>Administrator
                            </span>
                        @else
                            <span class="badge badge-info px-3 py-1 font-weight-bold" style="border-radius: 6px;">
                                <i class="fas fa-user mr-1"></i>Anggota Perpustakaan
                            </span>
                        @endif

                        @if($user->is_active)
                            <span class="badge badge-success px-3 py-1 ml-1" style="border-radius: 6px;">
                                <i class="fas fa-check-circle mr-1"></i>Aktif
                            </span>
                        @else
                            <span class="badge badge-danger px-3 py-1 ml-1" style="border-radius: 6px;">
                                <i class="fas fa-ban mr-1"></i>Nonaktif
                            </span>
                        @endif
                    </p>

                    <div class="table-responsive mt-3">
                        <table class="table table-sm border rounded-lg text-left overflow-hidden">
                            <tbody>
                                <tr>
                                    <th class="bg-light text-muted font-weight-semibold pl-3" style="width: 35%; border-top: 0;">ID Pengguna</th>
                                    <td class="font-weight-bold text-primary" style="border-top: 0;">#{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-muted font-weight-semibold pl-3">Alamat Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-muted font-weight-semibold pl-3">Alamat Lengkap</th>
                                    <td>{{ $user->alamat }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-muted font-weight-semibold pl-3">Waktu Bergabung</th>
                                    <td>{{ $user->created_at ? $user->created_at->format('d F Y, H:i') . ' WIB' : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-light px-4 py-3 border-0 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.master.user.index') }}" class="btn btn-outline-secondary font-weight-semibold">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                    <a href="{{ route('admin.master.user.edit', $user->id) }}" class="btn btn-warning px-4 font-weight-bold text-dark shadow-sm">
                        <i class="fas fa-user-edit mr-1"></i> Edit Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
