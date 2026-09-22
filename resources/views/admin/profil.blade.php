@extends('admin.layout.main')

@section('title', 'Profil Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ asset('storage/' . ($user->image ?? 'profil-pic/default.jpg')) }}"
                        alt="Foto Profil"
                        style="width: 120px; height: 120px; object-fit: cover;">

                    <h3 class="profile-username text-center mt-2">{{ $user->nama }}</h3>
                    <p class="text-muted text-center">Administrator E-Library</p>

                    <ul class="list-group list-group-unbordered mb-3 text-left">
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Status</b> <a class="float-right"><span class="badge badge-success">Aktif</span></a>
                        </li>
                        <li class="list-group-item">
                            <b>Bergabung</b> <a class="float-right">{{ $user->created_at->format('d M Y') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-edit mr-1"></i> Edit Profil</h3>
                </div>
                <form action="{{ url('admin/profil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                            <small class="text-muted">Email akun tidak dapat diubah.</small>
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Ganti Foto Profil</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Pilih file foto...</label>
                            </div>
                            <small class="text-muted">Format yang diperbolehkan: jpg, jpeg, png (Maks. 1MB).</small>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
