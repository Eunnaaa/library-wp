@extends('member.layout.main')

@section('title', 'Profil Saya')

@section('content')
<div class="container pt-4 pb-5">
    <div class="row justify-content-center">
        <!-- Profile Summary Card -->
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card border-0 shadow-sm text-center" style="border-radius: 16px; overflow: hidden;">
                <div class="py-4 px-3" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                    <div class="position-relative d-inline-block">
                        <img src="{{ asset('storage/' . ($user->image ?? 'profil-pic/default.jpg')) }}"
                            class="rounded-circle shadow-lg border border-white" width="120" height="120"
                            style="object-fit: cover; border-width: 4px !important;" alt="Avatar">
                    </div>
                    <h5 class="text-white font-weight-bold mt-3 mb-1">{{ $user->nama }}</h5>
                    <span class="badge badge-pill badge-primary px-3 py-1 font-weight-bold" style="background: #2563eb; color: #fff;">
                        <i class="fas fa-id-badge mr-1"></i> Anggota Perpustakaan UNM
                    </span>
                </div>
                <div class="card-body p-4 text-left">
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size: 0.72rem;">Alamat Email</small>
                        <strong class="text-dark">{{ $user->email }}</strong>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size: 0.72rem;">Alamat Rumah / Domisili</small>
                        <span class="text-dark">{{ $user->alamat ?? '-' }}</span>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size: 0.72rem;">Tanggal Bergabung</small>
                        <span class="text-dark"><i class="fas fa-calendar-alt text-primary mr-1"></i> {{ $user->created_at->format('d F Y') }}</span>
                    </div>

                    <hr class="my-3">
                    <a href="{{ route('member.ganti-password') }}" class="btn btn-outline-warning btn-sm btn-block font-weight-bold" style="border-radius: 8px;">
                        <i class="fas fa-key mr-1"></i> Pengaturan Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Update Profile -->
        <div class="col-lg-8 col-md-7">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-user-edit mr-2 text-primary"></i> Perbarui Data Profil Anggota
                    </h5>
                </div>
                <form action="{{ url('member/profil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        <div class="form-group mb-3">
                            <label for="email" class="font-weight-bold text-muted small text-uppercase">Alamat Email Terdaftar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-envelope text-muted"></i></span>
                                </div>
                                <input type="email" class="form-control bg-light" id="email" value="{{ $user->email }}" readonly>
                            </div>
                            <small class="text-muted">Alamat email digunakan sebagai identitas login utama dan tidak dapat diubah.</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama" class="font-weight-bold text-muted small text-uppercase">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-user text-primary"></i></span>
                                </div>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                    value="{{ old('nama', $user->nama) }}" required>
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat" class="font-weight-bold text-muted small text-uppercase">Alamat Domisili <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap...">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="image" class="font-weight-bold text-muted small text-uppercase">Ganti Foto Profil</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Pilih berkas gambar foto...</label>
                            </div>
                            <small class="text-muted d-block mt-1">Format gambar: JPG, JPEG, PNG (Ukuran berkas maksimal 1 MB).</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top text-right py-3 px-4">
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

