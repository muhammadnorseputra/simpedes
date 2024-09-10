<?= $this->extend("backend/layouts/app"); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-separate table-hover border border-3">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>NIPD</th>
                            <th>Photo</th>
                            <th>Nama Lengkap</th>
                            <th>Desa</th>
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
    $.fn.dataTable.ext.buttons.reload = {
        text: '<i class="bx bx-refresh"></i> Reload',
        action: function ( e, dt, node, config ) {
            dt.ajax.reload();
        },
        className: 'btn btn-info',
        
    };

    $.fn.dataTable.ext.buttons.add = {
        text: '<i class="bx bx-plus"></i> Tambah',
        action: function ( e, dt, node, config ) {
            console.log('add')
        },
        className: 'btn btn-primary'
    };

    $('table#example').DataTable({
        processing: true,
        serverSide: true,
        order: [[1, 'asc']], //this mean no init order on datatable
        layout: {
            topStart: [{
                buttons: ['add', {
                    text: '<i class="bx bx-export"></i> Export',
                    'split': ['print', 'csv']
                }]
            }],
            topEnd: [{
                search: {
                    placeholder: 'Masukan keyword ..',
                    type: 'search',
                    boundary: true
                }
            }, {
                buttons: [
                    'colvis',
                    'spacer',
                    'reload',
                ]
            }],
            bottomStart: ['info','pageLength']
        },
        ajax: {
            url: '<?= base_url('datatable/master/pegawai') ?>',
            method: 'POST',
            data: {
                csrf_token_simpedes: '<?= csrf_hash() ?>'
            },
        },
        columns: [
            {data: 'nik', orderable: true},
            {data: 'nipd', orderable: true},
            {data: 'photo', orderable: false, searchable: false},
            {data: 'nama'},
            {data: 'fid_keldesa', orderable: false, searchable: false}
        ],
        columnDefs: [
            {target: 0, orderable: false}
        ]
    });
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>