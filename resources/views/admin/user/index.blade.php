@extends('admin.layout.main')

@section('title', 'Data User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users mr-1"></i> Daftar Pengguna</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.master.user.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 50px;">#</th>
                                    <th style="width: 60px;">Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th style="width: 100px;">Role</th>
                                    <th style="width: 90px;">Status</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $u)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . ($u->image ?? 'profil-pic/default.jpg')) }}"
                                            class="img-circle" width="40" height="40" style="object-fit: cover;" alt="Avatar">
                                    </td>
                                    <td><strong>{{ $u->nama }}</strong></td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ Str::limit($u->alamat, 40) }}</td>
                                    <td class="text-center">
                                        @if($u->role_id == 1)
                                            <span class="badge badge-primary">Administrator</span>
                                        @else
                                            <span class="badge badge-info">Anggota</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($u->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.master.user.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                            <a href="{{ route('admin.master.user.show', $u->id) }}" class="btn btn-xs btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.master.user.edit', $u->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">Tidak ada data user.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 float-right">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
