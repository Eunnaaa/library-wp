@extends('member.layout.main')

@section('title', 'Profil Saya')

@section('content')
<div class="container pt-4 pb-5">
    <div class="row justify-content-center">
        <!-- Digital Library Card & Summary -->
        <div class="col-lg-4 col-md-5 mb-4">
            <!-- Digital Member Card -->
            <div class="card border-0 shadow-sm text-center mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563eb 100%); color: #fff;">
                <div class="p-3 d-flex justify-content-between align-items-center border-bottom" style="border-color: rgba(255,255,255,0.1) !important;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-university text-warning mr-2"></i>
                        <span class="font-weight-bold small text-uppercase letter-spacing-1 text-white-50" style="font-size: 0.72rem;">Kartu Anggota Digital</span>
                    </div>
                    <span class="badge badge-success px-2 py-1" style="font-size: 0.68rem; border-radius: 9999px;">
                        <i class="fas fa-check-circle mr-1"></i> AKTIF
                    </span>
                </div>
                <div class="py-4 px-3">
                    <div class="position-relative d-inline-block">
                        <img id="memberAvatarPreview" src="{{ asset('storage/' . ($user->image ?? 'profil-pic/default.jpg')) }}"
                            class="rounded-circle shadow-lg border border-white" width="110" height="110"
                            style="object-fit: cover; border-width: 3px !important;" alt="Avatar"
                            onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/default-150x150.png') }}';">
                    </div>
                    <h5 class="text-white font-weight-bold mt-3 mb-0">{{ $user->nama }}</h5>
                    <div class="small text-white-50 font-monospace mt-1">ID: UNM-LIB-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="p-3 bg-dark-subtle text-left" style="background: rgba(0, 0, 0, 0.2); border-top: 1px solid rgba(255,255,255,0.08);">
                    <div class="d-flex justify-content-between small text-white-50 mb-1">
                        <span>Universitas:</span>
                        <strong class="text-light">Nusa Mandiri</strong>
                    </div>
                    <div class="d-flex justify-content-between small text-white-50">
                        <span>Bergabung:</span>
                        <strong class="text-light">{{ $user->created_at->format('d M Y') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Member Details Card -->
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4 text-left">
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size: 0.72rem;">Alamat Email</small>
                        <strong class="text-dark">{{ $user->email }}</strong>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size: 0.72rem;">Alamat Domisili</small>
                        <span class="text-dark">{{ $user->alamat ?? '-' }}</span>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block font-weight-bold text-uppercase" style="font-size: 0.72rem;">Hak Akses</small>
                        <span class="badge badge-info px-2 py-1"><i class="fas fa-user-graduate mr-1"></i> Mahasiswa / Civitas UNM</span>
                    </div>

                    <a href="{{ route('member.ganti-password') }}" class="btn btn-outline-warning btn-sm btn-block font-weight-bold" style="border-radius: 8px;">
                        <i class="fas fa-key mr-1"></i> Ganti Password Akun
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
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewMemberAvatar(this)">
                                <label class="custom-file-label" for="image">Pilih berkas gambar foto...</label>
                            </div>
                            <small class="text-muted d-block mt-1">Format gambar: JPG, JPEG, PNG (Ukuran berkas maksimal 1 MB).</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top text-right py-3 px-4">
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-save mr-1"></i> Simpan Perbarui Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewMemberAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#memberAvatarPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

