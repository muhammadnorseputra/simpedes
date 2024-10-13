<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Riwayat</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/unit?id='.dohash($row->id_unit_kerja)) ?>"><?= $row->nama_unit_kerja ?></a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/detail/'.dohash($row->nik)) ?>"><?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Tunjangan</li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-danger btn-sm ms-auto d-flex align-items-center gap-2" onClick="window.history.back()">Kembali <i class="bx bx-right-arrow-alt pe-0 me-0"></i></button>
</div>
<!--end breadcrumb-->
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-primary" role="tablist">
            <li class="nav-item" role="presentation">
                <a
                class="nav-link active"
                data-bs-toggle="tab"
                href="#primary"
                role="tab"
                aria-selected="true">
                <div class="d-flex align-items-center">
                    <div class="tab-icon">
                    <i class="bx bx-money font-18 me-1"></i>
                    </div>
                    <div class="tab-title text-uppercase">Tunjangan</div>
                </div>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a
                class="nav-link"
                data-bs-toggle="tab"
                href="#secondary"
                role="tab"
                aria-selected="false">
                <div class="d-flex align-items-center">
                    <div class="tab-icon">
                    <i class="bx bx-spreadsheet font-18 me-1"></i>
                    </div>
                    <div class="tab-title text-uppercase">Absensi</div>
                </div>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="primary" role="tabpanel">
                <table id="tunjangan" class="table table-striped table-bordered table-hover border border-3">
                    <thead>
                        <tr>
                            <th data-bs-toggle="tooltip" data-bs-title="Nomor">No</th>
                            <th data-bs-toggle="tooltip" data-bs-title="Order By Tahun">Tahun</th>
                            <th data-bs-toggle="tooltip" data-bs-title="Order By Bulan">Bulan</th>
                            <th>Jabatan</th>
                            <th>Jumlah Bulan</th>
                            <th>Jumlah Uang</th>
                            <th>PPh21</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tab-pane fade" id="secondary" role="tabpanel">
                <table id="absensi" class="table table-striped table-bordered table-hover border border-3">
                    <thead>
                        <tr>
                            <th data-bs-toggle="tooltip" data-bs-title="Nomor">No</th>
                            <th data-bs-toggle="tooltip" data-bs-title="Order By Tahun">Tahun</th>
                            <th data-bs-toggle="tooltip" data-bs-title="Order By Bulan">Bulan</th>
                            <th>Hadir</th>
                            <th>Izin</th>
                            <th>Sakit</th>
                            <th>TK</th>
                            <th>CUTI</th>
                            <th>TUDIN</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- Ex: script -->
<?= $this->section('script'); ?>
<script src="<?= base_url("template/vertical/plugins/datatable/js/datatables.min.js") ?>" type="text/javascript"></script>
<?= $this->endSection(); ?>
<!-- Ex: css -->
<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>
<!-- In: script -->
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        let tunjangan  = $('table#tunjangan').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            // lengthChange: false,
            layout: {
                topStart: [],
                bottomStart: ['info','pageLength']
            },
            // paging: false,
            // info: false,
            order: [], //this mean no init order on datatable
            ajax: {
                url: '<?= base_url('datatable/riwayat/tunjangan') ?>',
                method: 'POST',
                data: {
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                    nik: '<?= $row->nik ?>'
                },
            },
            columns: [
                {data: 'no', width: '3%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'tahun', className: 'text-center text-uppercase', width: '5%'},
                {data: 'bulan', className: 'text-uppercase', width: '10%'},
                {data: 'nama_jabatan', orderable: false, searchabel: false},
                {data: 'jumlah_bulan', width: '8%', className: 'text-center', orderable: false, searchabel: false},
                {data: 'jumlah_uang', orderable: false, searchabel: false},
                {data: 'pph21', orderable: false, searchabel: false, className: 'text-center'},
            ]
        });

        let absensi  = $('table#absensi').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            // lengthChange: false,
            layout: {
                topStart: [],
                bottomStart: ['info','pageLength']
            },
            // paging: false,
            // info: false,
            order: [], //this mean no init order on datatable
            ajax: {
                url: '<?= base_url('datatable/riwayat/absensi') ?>',
                method: 'POST',
                data: {
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                    nik: '<?= $row->nik ?>'
                },
            },
            columns: [
                {data: 'no', width: '3%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'tahun', className: 'text-center text-uppercase', width: '5%'},
                {data: 'bulan', className: 'text-uppercase', width: '10%'},
                {data: 'hadir', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'izin', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'sakit', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'tk', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'cuti', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'tudin', orderable: false, searchabel: false, className: 'text-center'},
            ]
        });
    })
</script>
<?= $this->endSection(); ?>