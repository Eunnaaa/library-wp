@extends('admin.layout.main')

@section('title', 'Transaksi Peminjaman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
                <!-- Header with Title & Export Actions -->
                <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <div>
                        <h5 class="font-weight-bold mb-1 text-dark">
                            <i class="fas fa-address-book mr-2 text-primary"></i> Laporan Sirkulasi & Transaksi Peminjaman
                        </h5>
                        <p class="text-muted small mb-0">Pantau seluruh sirkulasi peminjaman aktif dan kelola pengembalian buku</p>
                    </div>
                    <div class="mt-3 mt-md-0 d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-danger font-weight-bold px-3 mr-2 shadow-sm" id="export-pdf" style="border-radius: 8px;">
                            <i class="far fa-file-pdf mr-1"></i> Unduh PDF
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success font-weight-bold px-3 shadow-sm" id="export-excel" style="border-radius: 8px;">
                            <i class="far fa-file-excel mr-1"></i> Unduh Excel
                        </button>
                    </div>
                </div>

                <!-- Filter Bar -->
                <div class="p-3 bg-light border-bottom">
                    <div class="row align-items-end">
                        <div class="col-md-4 col-lg-3 mb-2 mb-md-0">
                            <label class="small text-muted font-weight-bold text-uppercase mb-1">
                                <i class="far fa-calendar-alt mr-1 text-primary"></i> Periode Mulai
                            </label>
                            <input type="date" id="start_date" class="form-control form-control-sm bg-white" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-4 col-lg-3 mb-2 mb-md-0">
                            <label class="small text-muted font-weight-bold text-uppercase mb-1">
                                <i class="far fa-calendar-check mr-1 text-primary"></i> Periode Sampai
                            </label>
                            <input type="date" id="end_date" class="form-control form-control-sm bg-white" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-4 col-lg-4 mb-2 mb-md-0 d-flex">
                            <button type="button" id="filter" class="btn btn-sm btn-primary font-weight-bold px-3 mr-2 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-filter mr-1"></i> Filter Data
                            </button>
                            <button type="button" id="reset-filter" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-redo-alt mr-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="transaksi-table" style="width:100%">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th style="width: 40px;">No</th>
                                    <th>No. Pinjam</th>
                                    <th>Tgl. Pinjam</th>
                                    <th>Tgl. Kembali</th>
                                    <th>Judul Buku</th>
                                    <th style="width: 80px;">Status</th>
                                    <th style="width: 60px;">Gambar</th>
                                    <th>Anggota</th>
                                    <th>Petugas</th>
                                    <th style="width: 130px;">Aksi</th>
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
            responsive: true,
            autoWidth: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data transaksi...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data peminjaman",
                infoEmpty: "Menampilkan 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ada data peminjaman yang cocok",
                emptyTable: "Belum ada transaksi peminjaman aktif saat ini",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    previous: '<i class="fas fa-angle-left"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>'
                },
                processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Memuat...</span></div>'
            },
            ajax: {
                url: "{{ route('admin.transaksi.peminjaman.data') }}",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center font-weight-bold text-muted' },
                { 
                    data: 'no_pinjam', 
                    name: 'no_pinjam',
                    className: 'font-weight-bold text-primary',
                    render: function(data) {
                        return '<code>' + data + '</code>';
                    }
                },
                { data: 'tgl_pinjam', name: 'tgl_pinjam', className: 'text-center' },
                { data: 'tgl_kembali', name: 'tgl_kembali', className: 'text-center' },
                { 
                    data: 'judul_buku', 
                    name: 'judul_buku',
                    render: function(data) {
                        return '<strong class="text-dark">' + data + '</strong>';
                    }
                },
                { data: 'status', name: 'status', className: 'text-center' },
                { data: 'gambar', name: 'gambar', orderable: false, searchable: false, className: 'text-center' },
                { 
                    data: 'anggota', 
                    name: 'anggota',
                    render: function(data) {
                        return '<span class="font-weight-bold text-dark">' + data + '</span>';
                    }
                },
                { data: 'petugas', name: 'petugas', className: 'text-muted small' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#filter').click(function() {
            table.draw();
        });

        $('#reset-filter').click(function() {
            $('#start_date').val('');
            $('#end_date').val('');
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
