<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Referensi</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tingkat Pendidikan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover border border-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Tingkat Pendidikan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url("template/vertical/plugins/datatable/js/datatables.min.js") ?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('table#example').DataTable({
        processing: true,
        serverSide: true,
        order: [], //this mean no init order on datatable
        ajax: {
            url: '<?= base_url('datatable/tingkat_pendidikan') ?>',
            method: 'POST',
            data: {
                ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
            },
        },
        column: [
            {data: 'id_tingkat_pendidikan', orderable: false, searchable: false},
            {data: 'nama_tingkat_pendidikan'},
        ]
    });
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>