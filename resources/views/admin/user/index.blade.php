@extends('admin.layout.main')

@section('title', 'Data Master Pengguna')

@section('content')
<div class="container-fluid pb-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <!-- Header with Title & Action Button -->
                <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <div class="mb-2 mb-md-0">
                        <h5 class="font-weight-bold mb-1 text-dark">
                            <i class="fas fa-users-cog mr-2 text-primary"></i> Data Master Pengguna & Anggota
                        </h5>
                        <p class="text-muted small mb-0">Kelola akun administrator sistem dan anggota aktif perpustakaan UNM</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.master.user.create') }}" class="btn btn-primary btn-sm font-weight-bold shadow-sm px-3 py-2" style="border-radius: 8px;">
                            <i class="fas fa-user-plus mr-1"></i> Tambah User Baru
                        </a>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <div class="p-3 bg-light border-bottom">
                    <form action="{{ route('admin.master.user.index') }}" method="GET" class="row align-items-end">
                        <div class="col-lg-5 col-md-5 mb-2 mb-lg-0">
                            <label class="small text-muted font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-search mr-1 text-primary"></i> Cari Pengguna
                            </label>
                            <input type="text" name="keyword" class="form-control form-control-sm bg-white"
                                placeholder="Cari nama, email, atau alamat..." value="{{ request('keyword') }}" style="border-radius: 8px;">
                        </div>

                        <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                            <label class="small text-muted font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-user-tag mr-1 text-primary"></i> Peran
                            </label>
                            <select name="role" class="form-control form-control-sm bg-white" style="border-radius: 8px;">
                                <option value="">Semua Peran</option>
                                <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Administrator</option>
                                <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Anggota</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">
                            <label class="small text-muted font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-toggle-on mr-1 text-primary"></i> Status
                            </label>
                            <select name="status" class="form-control form-control-sm bg-white" style="border-radius: 8px;">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-12 d-flex">
                            <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-3 mr-2 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-filter mr-1"></i> Saring
                            </button>
                            <a href="{{ route('admin.master.user.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-redo-alt mr-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Active Filter Notification -->
                @if(request('keyword') || request('role') || request('status') !== null && request('status') !== '')
                    <div class="px-3 py-2 bg-white border-bottom small text-secondary d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-info-circle text-primary mr-1"></i>
                            Menampilkan hasil saringan:
                            @if(request('keyword')) <strong>"{{ request('keyword') }}"</strong> @endif
                            @if(request('role'))
                                <span class="badge badge-info ml-1">{{ request('role') == 1 ? 'Administrator' : 'Anggota' }}</span>
                            @endif
                            @if(request('status') !== null && request('status') !== '')
                                <span class="badge {{ request('status') == 1 ? 'badge-success' : 'badge-danger' }} ml-1">
                                    {{ request('status') == 1 ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            @endif
                            <span class="text-muted">({{ $users->total() }} user ditemukan)</span>
                        </div>
                        <a href="{{ route('admin.master.user.index') }}" class="text-danger small font-weight-bold">Hapus Filter &times;</a>
                    </div>
                @endif

                <!-- Table Content -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="bg-light text-center">
                                    <th style="width: 50px;">#</th>
                                    <th style="width: 70px;">Avatar</th>
                                    <th class="text-left">Nama & Email</th>
                                    <th class="text-left">Alamat Domisili</th>
                                    <th style="width: 140px;">Role Akun</th>
                                    <th style="width: 110px;">Status</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $u)
                                <tr>
                                    <td class="text-center font-weight-bold text-muted">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . ($u->image ?? 'profil-pic/default.jpg')) }}"
                                            class="rounded-circle border shadow-sm" width="40" height="40" style="object-fit: cover;" alt="Avatar"
                                            onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/default-150x150.png') }}';">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.master.user.show', $u->id) }}" class="font-weight-bold text-dark d-block" style="font-size: 0.95rem;">
                                            {{ $u->nama }}
                                        </a>
                                        <small class="text-muted"><i class="fas fa-envelope mr-1 text-primary opacity-75"></i> {{ $u->email }}</small>
                                    </td>
                                    <td class="small text-muted">{{ Str::limit($u->alamat, 55) }}</td>
                                    <td class="text-center">
                                        @if($u->role_id == 1)
                                            <span class="badge badge-primary px-3 py-1 font-weight-bold" style="border-radius: 9999px;">
                                                <i class="fas fa-shield-alt mr-1"></i> Administrator
                                            </span>
                                        @else
                                            <span class="badge badge-info px-3 py-1 font-weight-bold" style="border-radius: 9999px;">
                                                <i class="fas fa-user mr-1"></i> Anggota
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($u->is_active)
                                            <span class="badge badge-success px-2 py-1 font-weight-bold">
                                                <i class="fas fa-check-circle mr-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-danger px-2 py-1 font-weight-bold">
                                                <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.master.user.show', $u->id) }}" class="btn btn-sm btn-outline-info p-1 px-2" title="Detail Pengguna" data-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.master.user.edit', $u->id) }}" class="btn btn-sm btn-outline-warning p-1 px-2" title="Edit Akun" data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.master.user.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Hapus User" data-toggle="tooltip" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; background: #eff6ff;">
                                            <i class="fas fa-users fa-2x text-primary"></i>
                                        </div>
                                        <h6 class="font-weight-bold text-dark">Tidak Ada Pengguna yang Sesuai</h6>
                                        <p class="small text-muted mb-3">Coba gunakan kata kunci pencarian yang lain atau reset filter peran/status.</p>
                                        <a href="{{ route('admin.master.user.index') }}" class="btn btn-sm btn-outline-primary font-weight-bold px-3">
                                            <i class="fas fa-sync mr-1"></i> Tampilkan Seluruh User
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <small class="text-muted mb-2 mb-sm-0">
                            Menampilkan <strong>{{ $users->firstItem() ?? 0 }}</strong> - <strong>{{ $users->lastItem() ?? 0 }}</strong> dari <strong>{{ $users->total() }}</strong> pengguna
                        </small>
                        <div>
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
