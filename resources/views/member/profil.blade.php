@extends('member.layout.main')

@section('title', 'Profil Saya')

@section('content')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <img src="{{ asset('storage/' . ($user->image ?? 'profil-pic/default.jpg')) }}"
                        class="rounded-circle shadow mb-3" width="130" height="130" style="object-fit: cover;" alt="Avatar">
                    <h4>{{ $user->nama }}</h4>
                    <p class="text-muted"><span class="badge badge-info">Anggota E-Library</span></p>

                    <hr>
                    <div class="text-left small">
                        <p class="mb-2"><strong>Email:</strong><br>{{ $user->email }}</p>
                        <p class="mb-2"><strong>Alamat:</strong><br>{{ $user->alamat }}</p>
                        <p class="mb-0"><strong>Terdaftar Sejak:</strong><br>{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title font-weight-bold mb-0"><i class="fas fa-user-edit mr-2 text-primary"></i> Perbarui Data Profil</h5>
                </div>
                <form action="{{ url('member/profil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                            <small class="text-muted">Email bersifat permanen dan tidak dapat diubah.</small>
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                value="{{ old('nama', $user->nama) }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Ganti Foto Profil</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Pilih foto...</label>
                            </div>
                            <small class="text-muted">Format yang diperbolehkan: jpg, jpeg, png (Maks. 1MB).</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
