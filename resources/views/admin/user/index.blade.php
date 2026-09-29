@extends('admin.layout.main')

@section('title', 'Data Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center w-100">
                    <h5 class="font-weight-bold mb-0 text-dark">
                        <i class="fas fa-users-cog mr-2 text-primary"></i> Data Master Pengguna & Anggota
                    </h5>
                    <div class="ml-auto">
                        <a href="{{ route('admin.master.user.create') }}" class="btn btn-primary btn-sm font-weight-bold shadow-sm px-3 py-2" style="border-radius: 8px;">
                            <i class="fas fa-user-plus mr-1"></i> Tambah User Baru
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light text-center">
                                    <th style="width: 50px;">#</th>
                                    <th style="width: 70px;">Avatar</th>
                                    <th class="text-left">Nama & Email</th>
                                    <th class="text-left">Alamat Domisili</th>
                                    <th style="width: 120px;">Role Akun</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $u)
                                <tr>
                                    <td class="text-center font-weight-bold text-muted">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . ($u->image ?? 'profil-pic/default.jpg')) }}"
                                            class="rounded-circle border shadow-sm" width="40" height="40" style="object-fit: cover;" alt="Avatar">
                                    </td>
                                    <td>
                                        <strong class="text-dark d-block">{{ $u->nama }}</strong>
                                        <small class="text-muted">{{ $u->email }}</small>
                                    </td>
                                    <td class="small text-muted">{{ Str::limit($u->alamat, 50) }}</td>
                                    <td class="text-center">
                                        @if($u->role_id == 1)
                                            <span class="badge badge-primary font-weight-bold">Administrator</span>
                                        @else
                                            <span class="badge badge-info font-weight-bold">Anggota</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($u->is_active)
                                            <span class="badge badge-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Aktif</span>
                                        @else
                                            <span class="badge badge-danger font-weight-bold"><i class="fas fa-times-circle mr-1"></i> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.master.user.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                            <a href="{{ route('admin.master.user.show', $u->id) }}" class="btn btn-sm btn-outline-info p-1 px-2" title="Detail"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.master.user.edit', $u->id) }}" class="btn btn-sm btn-outline-warning p-1 px-2" title="Edit"><i class="fas fa-edit"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="fas fa-users fa-3x text-muted mb-2 d-block"></i>
                                        Belum ada data user.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top d-flex justify-content-end">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
