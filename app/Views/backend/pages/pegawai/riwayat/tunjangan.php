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
        <table id="example" class="table table-striped table-bordered table-hover border border-3">
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
        let datatable  = $('table#example').DataTable({
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
    })
</script>
<?= $this->endSection(); ?>