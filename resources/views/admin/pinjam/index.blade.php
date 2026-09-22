@extends('admin.layout.main')

@section('title', 'Transaksi Peminjaman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-4 mb-2 mb-md-0">
                            <label class="small text-muted mb-1">Tanggal Mulai:</label>
                            <input type="date" id="start_date" class="form-control form-control-sm" placeholder="Tanggal Mulai">
                        </div>
                        <div class="col-lg-3 col-md-4 mb-2 mb-md-0">
                            <label class="small text-muted mb-1">Tanggal Akhir:</label>
                            <input type="date" id="end_date" class="form-control form-control-sm" placeholder="Tanggal Akhir">
                        </div>
                        <div class="col-lg-6 col-md-4 mt-md-4">
                            <button type="button" id="filter" class="btn btn-sm btn-primary">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger ml-1" id="export-pdf">
                                <i class="far fa-file-pdf mr-1"></i> Export PDF
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success ml-1" id="export-excel">
                                <i class="far fa-file-excel mr-1"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="transaksi-table" style="width:100%">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th style="width: 30px;">No</th>
                                    <th>No. Pinjam</th>
                                    <th>Tgl. Pinjam</th>
                                    <th>Tgl. Kembali</th>
                                    <th>Judul Buku</th>
                                    <th style="width: 70px;">Status</th>
                                    <th style="width: 60px;">Gambar</th>
                                    <th>Anggota</th>
                                    <th>Petugas</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#transaksi-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.transaksi.peminjaman.data') }}",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'no_pinjam', name: 'no_pinjam' },
                { data: 'tgl_pinjam', name: 'tgl_pinjam', className: 'text-center' },
                { data: 'tgl_kembali', name: 'tgl_kembali', className: 'text-center' },
                { data: 'judul_buku', name: 'judul_buku' },
                { data: 'status', name: 'status', className: 'text-center' },
                { data: 'gambar', name: 'gambar', orderable: false, searchable: false, className: 'text-center' },
                { data: 'anggota', name: 'anggota' },
                { data: 'petugas', name: 'petugas' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $('#filter').click(function() {
            table.draw();
        });

        $('#export-pdf').click(function() {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var url = '{{ route("admin.transaksi.pinjam.exportPdfPinjam") }}' + '?start_date=' + startDate + '&end_date=' + endDate;
            window.open(url, '_blank');
        });

        $('#export-excel').click(function() {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var url = '{{ route("admin.transaksi.pinjam.exportExcelPinjam") }}' + '?start_date=' + startDate + '&end_date=' + endDate;
            window.location.href = url;
        });

        $(document).on('submit', '.form-kembalikan', function(e) {
            e.preventDefault();
            if (!confirm('Apakah buku ini sudah dikembalikan oleh anggota?')) {
                return;
            }

            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.success || 'Buku berhasil dikembalikan!');
                    table.draw();
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON ? xhr.responseJSON.error : 'Terjadi kesalahan.');
                }
            });
        });
    });
</script>
@endpush
