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
                            <th>Unit Kerja / Jabatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <th class="filterhead"></th>
                            <th class="filterhead"></th>
                            <th></th>
                            <th class="filterhead"></th>
                            <th class="filterhead"></th>
                            <th class="filterhead"></th>
                            <th></th>
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
        text: '<i class="bx bx-refresh"></i> Refresh',
        action: function ( e, dt, node, config ) {
            dt.ajax.reload();
        },
        className: 'btn btn-secondary',
        
    };

    $.fn.dataTable.ext.buttons.add = {
        text: '<i class="bx bx-plus"></i> Tambah',
        action: function ( e, dt, node, config ) {
            window.location.href= `${origin}/app/master/pegawai/peremajaan`
        },
        className: 'btn btn-primary'
    };

    var datatable = $('table#example').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "desc"]], //this mean no init order on datatable
        layout: {
            topStart: [{
                buttons: ['add']
            }],
            topEnd: [{
                buttons: [
                    'colvis',
                    'spacer',
                    {
                        text: '<i class="bx bx-export"></i> Export',
                        'split': ['print', 'csv']
                    },
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
                ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
            },
        },
        columns: [
            {data: 'nik', orderable: true},
            {data: 'nipd', orderable: true},
            {data: 'photo', width: '5%', className: 'text-center align-middle', orderable: false, searchable: false},
            {data: 'nama',  className: 'align-middle'},
            {data: 'nama_unit_kerja', orderable: false},
            {data: 'status', width: '10%', orderable: false},
            {data: 'action', width: '10%',orderable: false, searchable: false}
        ],
        orderCellsTop: true,
        initComplete: function( settings, json ) 
        {

            var indexColumn = 0;

            this.api().columns([0,1,3,4,5]).every(function () 
            {
                
                var column      = this;
                var input       = document.createElement("input");
                
                $(input).attr( 'placeholder', 'Search' )
                        .attr("type", "search")
                        .addClass('form-control form-control-sm')
                        .appendTo( $('.filterhead:eq('+indexColumn+')').empty() )
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });

                indexColumn++;
            });
        }
    });

    datatable.on("click", "a#verifikasi", function (event) {
        event.preventDefault();
        let _ = $(this);
        let ID = _.data('uid');
        let URL = _.attr('href');
        window.location.href = URL;
    })
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>