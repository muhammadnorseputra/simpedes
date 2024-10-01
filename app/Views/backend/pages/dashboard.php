<?= $this->extend('backend/layouts/app'); ?>
<?= $this->section('content'); ?>
<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 flex-lg-nowrap overflow-y-auto">
    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-info">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <p class="mb-0 text-secondary">Total Pegawai</p>
                    <h4 class="my-1 text-info"><?= $total_pegawai_bpd_aktif; ?></h4>
                    <p class="mb-0 font-13">BPD AKTIF</p>
                </div>
                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-group'></i>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Pegawai</p>
                        <h4 class="my-1 text-warning"><?= $total_pegawai_pemdes_aktif; ?></h4>
                        <p class="mb-0 font-13">PEMDES AKTIF</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Pegawai</p>
                        <h4 class="my-1 text-danger"><?= $total_pegawai_non_aktif; ?></h4>
                        <p class="mb-0 font-13">BPD / PEMDES NON AKTIF</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class='bx bxs-group'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Pengeluaran Tunjangan</p>
                        <h4 class="my-1 text-warning"><?= number_to_currency($total_pengeluaran_tunjangan_tahunan ?? 0, "IDR", "id_ID"); ?></h4>
                        <p class="mb-0 font-13">Tahun <?= date('Y') ?></p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-wallet' ></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Unit Kerja/Desa</p>
                        <h4 class="my-1 text-success"><?= $total_unit_kerja_aktif; ?> / <?= $total_desa; ?></h4>
                        <p class="mb-0 font-13">Unit Kerja per Desa</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-buildings' ></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0 border-4 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Userportal</p>
                        <h4 class="my-1 text-warning"><?= $total_userportal; ?></h4>
                        <p class="mb-0 font-13">Keseluruhan Pengguna</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-user-check'></i>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div><!--end row-->
<div class="row">
    <!-- Chart Pengeluaran Tunjangan Bulanan -->
    <div class="col-12 col-ld-12 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-chart bx-md"></i>
                    <div>
                        <h6 class="mb-0">Trend Tunjangan</h6>
                        <p class="mb-0 text-secondary">Jumlah Pengeluaran Tunjangan Bulanan</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="tunjangan">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Chart Lokasi -->
<!-- <div class="row">
    <div class="col-12 col-lg-12 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-chart bx-md"></i>
                    <div>
                        <h6 class="mb-0">Lokasi</h6>
                        <p class="mb-0 text-secondary">Jumlah Pegawai Berdasarkan Lokasi Kerja</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="lokasi" style="height: 300px"></div>
            </div>
        </div>
    </div>
</div> -->
<div class="row row-cols-1 row-cols-md-2">
    <!-- Chart Gender -->
    <div class="col-12 col-lg-6 d-flex">
        <div class="card radius-10 w-100">
        <div class="card-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-chart bx-md"></i>
                <div>
                    <h6 class="mb-0">Trend Gender</h6>
                    <p class="mb-0 text-secondary">Jumlah pegawai berdasarkan jenis kelamin</p>
                </div>
            </div>
        </div>
            <div class="card-body">
                    <div id="gender"></div>
            </div>
        </div>
    </div>
    <!-- Chart Umur -->
    <div class="col-12 col-lg-6 d-flex">
        <div class="card radius-10 w-100">
        <div class="card-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-chart bx-md"></i>
                <div>
                    <h6 class="mb-0">Trend Umur</h6>
                    <p class="mb-0 text-secondary">Jumlah Pegawai Berdasarkan Kelompok Umur</p>
                </div>
            </div>
        </div>
            <div class="card-body">
                <div id="umur"></div>
            </div>
        </div>
    </div>
</div>
<div class="row row-cols-1 row-cols-md-2">
    <!-- Chart Pendidikan -->
    <div class="col-12 col-lg-6 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-chart bx-md"></i>
                    <div>
                        <h6 class="mb-0">Trend Pendidikan</h6>
                        <p class="mb-0 text-secondary">Jumlah Pegawai Berdasarkan Tingkat Pendidikan</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="pendidikan"></div>
            </div>
        </div>
    </div>
    <!-- Chart Agama -->
    <div class="col-12 col-lg-6 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-chart bx-md"></i>
                    <div>
                        <h6 class="mb-0">Trend Agama</h6>
                        <p class="mb-0 text-secondary">Jumlah Pegawai Berdasarkan Agama</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="agama"></div>
            </div>
        </div>
    </div>
</div>
<div class="row row-cols-1 row-cols-md-2">
    <!-- Chart Status Kawin -->
    <div class="col-12 col-lg-6 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-chart bx-md"></i>
                    <div>
                        <h6 class="mb-0">Trend Perkawinan</h6>
                        <p class="mb-0 text-secondary">Jumlah Pegawai Berdasarkan Status Perkawinan</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="status_kawin"></div>
            </div>
        </div>
    </div>
    <!-- Chart Jenis Pegawai -->
    <div class="col-12 col-lg-6 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-chart bx-md"></i>
                    <div>
                        <h6 class="mb-0">Trend Jenis Pegawai</h6>
                        <p class="mb-0 text-secondary">Jumlah Pegawai Berdasarkan Jenis Pegawai</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="jenis_pegawai"></div>
            </div>
        </div>
    </div>
    
</div>  
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="<?= base_url('template/vertical/plugins/hightcharts/exporting.js') ?>"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
$(function() {
    // Trend Tunjangan
    // Data dari PHP (CI4 Query Builder)
    var TUNJANGAN = <?= json_encode($charts['tunjangan']); ?>;

    // Konversi data untuk Highcharts
    var TUNJANGAN_CATEGORIES = [];
    var TUNJANGAN_DATA = [];

    TUNJANGAN.forEach(function(item) {
        TUNJANGAN_CATEGORIES.push(item.bulan);
        TUNJANGAN_DATA.push(parseInt(item.jumlah_uang));
    });
    console.log(TUNJANGAN_CATEGORIES)
    Highcharts.chart('tunjangan', {
        chart: {
            type: 'line',
            scrollablePlotArea: {
                minWidth: 600,
                scrollPositionX: 1
            }
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories: TUNJANGAN_CATEGORIES,
            title: {
                text: 'Tahun <?= date("Y") ?>'
            },
            labels: {
                style: {
                    fontWeight: 'bold', // Mengatur teks menjadi tebal
                    fontSize: 12
                }
            },
            gridLineWidth: 1
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Uang'
            },
            labels: {
                format: 'Rp. {value:,.0f}', // Format untuk menampilkan nilai dalam Rupiah
                style: {
                    fontWeight: 'bold', // Mengatur teks menjadi tebal
                    fontSize: 12
                }
            },
            stackLabels: {
                enabled: true
            },
            gridLineWidth: 0
        },
        tooltip: {
            headerFormat: 'Bulan <b>{point.x}</b><br/>',
            pointFormat: 'Jumlah: <b>{point.y}</b>',
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            dataLabels: true,
            lseries: {
                states: {
                    hover: {
                        enabled: true,
                        lineWidth: 6,
                        fillColor: 'rgba(255, 255, 0, 0.2)' // Background color on hover
                    }
                }
            }
        },
        series: [{
            colorByPoint: false,
            name: "Tunjangan Bulanan",
            data: TUNJANGAN_DATA,
            color: {
                linearGradient: {
                    x1: 0,
                    x2: 0,
                    y1: 1,
                    y2: 0
                },
                stops: [
                    [0, '#0000ff'],
                    [1, '#ff0000']
                ]
            }
        }]
    });

    // Lokasi MAP
    // let LOKASI = <?= json_encode($charts['lokasi']); ?>;
    // let LOKASI_DATA = [];
    // LOKASI.forEach(function(item) {
    //     LOKASI_DATA.push({latLng: [item.latitude,item.longitude], name: item.nama_unit_kerja});
    // });
    // Trend Gender
    Highcharts.chart('gender', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: false,
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Jumlah : <b>{point.y:f}</b><br />{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name} : {point.y:f}<br />{point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                showInLegend: true
            }
        },
        series: [{
            type : 'pie',
            name: 'Persentase ',
            colorByPoint: true,
            data: [
                ['PEREMPUAN',<?= $charts["gender_wanita"]; ?>],['LAKI-LAKI',<?= $charts["gender_pria"]; ?>],
            ]
        }]
    });
    
    // Trend Umur
    // Data dari PHP (CI4 Query Builder)
    var UMUR = <?= json_encode($charts['usia']); ?>;

    // Konversi data untuk Highcharts
    var UMUR_CATEGORIES = [];
    var UMUR_DATA = [];

    UMUR.forEach(function(item) {
        UMUR_CATEGORIES.push(item.kelompok_usia);
        UMUR_DATA.push(parseInt(item.jumlah));
    });
    Highcharts.chart('umur', {
        chart: {
            type: 'column',
            options3d: {
                enabled: false,
                alpha: 15,
                beta: 0
            }
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories: UMUR_CATEGORIES,
            title: {
                text: 'Kelompok Usia'
            },
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah (Pegawai)'
            },
            stackLabels: {
                enabled: false,
                    style: {
                        fontWeight: 'bold',
                            color: ( // theme
                                Highcharts.defaultOptions.title.style &&
                                    Highcharts.defaultOptions.title.style.color
                            ) || 'grey'
                    }
            }
        },
        tooltip: {
            headerFormat: 'Kelompok Usia <b>{point.x}</b><br/>',
            pointFormat: 'Jumlah: <b>{point.y}</b>'
        },
        plotOptions: {
            column: {
                //stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                    },
            }
        },
        series: [{
            colorByPoint: true,
            data: UMUR_DATA
        }]
    });

    // Trend Pendidikan
    let TP = <?= json_encode($charts['tingkat_pendidikan']); ?>;
    let TP_CATEGORIES = [];
    let TP_DATA = [];
    TP.forEach(function(item) {
        TP_CATEGORIES.push(item.tingkat);
        TP_DATA.push(parseInt(item.jumlah));
    });
    Highcharts.chart('pendidikan', {
        chart: {
            type: 'bar'
        },
        title: false,
        credits: {
            enabled: false
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: false
        },
        tooltip: {
            //valueSuffix: ' orang',
            pointFormat: 'Jumlah : <b>{point.y:f}</b> orang'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                },
                pointPadding: 0.02,
                borderWidth: 0,
                showInLegend: false
            }
        },
        xAxis: {
            categories: TP_CATEGORIES,
            title: {
                text: 'Tingkat Pendidikan'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah',
                align: 'high',
                color: 'red'
            },
            labels: {
                overflow: 'justify'
            }
        },
        series: [{
            name: 'Jumlah',
            data: TP_DATA,
            colorByPoint: true,
        }]
    });

    // Trend Agama
    let AGAMA = <?= json_encode($charts['agama']); ?>;
    let AGAMA_CATEGORIES = [];
    let AGAMA_DATA = [];
    AGAMA.forEach(function(item) {
        AGAMA_DATA.push([item.nama_agama,parseInt(item.total)]);
    });
    Highcharts.chart('agama', {
        chart: {
            type: 'pie',
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: 'Jumlah : <b>{point.y:f}</b> Pegawai <br />{series.name}: <b>{point.percentage:.1f}%</b>'
            //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        subtitle: {
            text: ''
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                //depth: 130,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                enabled: true,
                format: '{point.name} : {point.y:f} [{point.percentage:.1f} %]',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
                },
                showInLegend: true
            },
        },
        series: [{
            name: 'Persentase',
            data: AGAMA_DATA,
            //size: 150,
        }]
    });

    // Status Kawin
    let STATUS_KAWIN = <?= json_encode($charts['status_kawin']); ?>;
    let STATUS_KAWIN_CATEGORIES = [];
    let STATUS_KAWIN_DATA = [];
    STATUS_KAWIN.forEach(function(item) {
        STATUS_KAWIN_DATA.push([item.nama_status_kawin,parseInt(item.total)]);
    });
    Highcharts.chart('status_kawin', {
        chart: {
            type: 'pie',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Jumlah : <b>{point.y:f}</b> Pegawai <br />{series.name}: <b>{point.percentage:.1f}%</b>'
            //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        subtitle: {
            text: ''
        },
        plotOptions: {
            pie: {
                //innerSize: 0,
                //depth: 30,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}<br/>{point.y:f} [{point.percentage:.1f} %]',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                showInLegend: true
            },
        },
        series: [{
            name: 'Persentase',
            data: STATUS_KAWIN_DATA,
            //size: 150,
        }]
    });

    // Jenis Pegawai
    let JENIS_PEGAWAI = <?= json_encode($charts['jenis_pegawai']); ?>;
    let JENIS_PEGAWAI_DATA = [];
    JENIS_PEGAWAI.forEach(function(item) {
        JENIS_PEGAWAI_DATA.push({'name': item.jenis,'y':parseInt(item.total), 'z':parseInt(item.total)});
    });
    
    Highcharts.chart('jenis_pegawai', {
        chart: {
            type: 'pie',
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Jumlah : <b>{point.y:f}</b> Pegawai <br />{series.name}: <b>{point.percentage:.1f}%</b>'
            //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        subtitle: {
            text: ''
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                //innerSize: 0,
                //depth: 30,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    distance: -50,
                    format: '{point.name}<br/>{point.y:f} [{point.percentage:.1f} %]',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                showInLegend: true,
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '75%'],
                size: '110%'
            },
        },
        series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            borderRadius: 5,
            name: 'Pegawai',
            data: JENIS_PEGAWAI_DATA,
            //size: 150,
        }]
    });
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<link rel="stylesheet" href="<?= base_url('template/vertical/plugins/hightcharts/highcharts-gridlight.css'); ?>">
<link href="<?= base_url('template/vertical/plugins/vectormap/jquery-jvectormap-2.0.2.css') ?>" rel="stylesheet" />
<?= $this->endSection(); ?>