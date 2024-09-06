<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= base_url("assets/images/app/logo.png") ?>" type="image/png" />
	<!--plugins-->
	<link href="<?= base_url("template/vertical/plugins/simplebar/css/simplebar.css") ?>" rel="stylesheet" />
	<link href="<?= base_url("template/vertical/plugins/perfect-scrollbar/css/perfect-scrollbar.css") ?>" rel="stylesheet" />
	<link href="<?= base_url("template/vertical/plugins/metismenu/css/metisMenu.min.css") ?>" rel="stylesheet" />
	<!-- loader-->
	<link href="<?= base_url("template/vertical/css/pace.min.css") ?>" rel="stylesheet" />
	<script src="<?= base_url("template/vertical/js/pace.min.js") ?>"></script>
	<!-- Bootstrap CSS -->
	<link href="<?= base_url("template/vertical/css/bootstrap.min.css") ?>" rel="stylesheet">
	<link href="<?= base_url("template/vertical/css/bootstrap-extended.css") ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?= base_url("template/vertical/css/app.css") ?>" rel="stylesheet">
	<link href="<?= base_url("template/vertical/css/icons.css") ?>" rel="stylesheet">
	<title>SIMPEDES - Sistem Informasi Manajemen Pemerintah Desa Kab. Balangan</title>
</head>

<body class="">
    
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-cover">
			<div class="">
				<div class="row g-0">
					<div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center 
                    d-none d-xl-flex relative overflow-hidden" 
                    style="background: url('<?= base_url('assets/images/app/auth-bg.jpg') ?>'); 
                    background-attacment: fixed; background-size: cover; background-repeat: no-repeat">
                        <div class="fixed-top left-0 top-0 w-100 h-100 bg-black z-0 opacity-75"></div>
                        <div class="card bg-transparent shadow-none">
                            <div class="card-header">
                                <div class="card-title text-center">
                                    <h2 class="text-white">Sistem Informasi Manajemen Pemerintah Desa</h2>
                                </div>
                            </div>
                            <div class="card-body text-white text-center fs-5">
                                Selamat Datang pada Portal Informasi Desa Kabupaten Balangan Tahun <?= date('Y') ?> <br/>
                                Layanan terpadu yang dikelola oleh Dinas Pemberdayaan Masyarakat dan Desa.
                            </div>
                        </div>
                    </div>

					<div class="col-12 col-xl-4 col-xxl-4 auth-cover-right align-items-center justify-content-center bg-white shadow-lg z-1">
						<div class="card rounded-0 shadow-none bg-transparent mb-0">
							<div class="card-body p-sm-5">
								<div class="">
									<div class="mb-4 text-center">
                                    <img class="mb-2" src="<?= base_url("assets/images/app/logo.png") ?>" alt="logo balangan" width="50">
									</div>
									<div class="text-center mb-4">
										<h5 class="mb-2">Masuk Aplikasi Simpedes</h5>
										<p class="mb-0">Silahkan login dengan akun desa anda.</p>
									</div>
									<div class="form-body">
										<?= form_open("", ["class" => 'row g-3 needs-validation', 'novalidate' => '']) ?>
											<div class="col-12">
											<div class="form-floating  isInvalid">
  <input type="text" class="form-control" id="floatingInput" placeholder="Masukan username">
  <label for="floatingInput">Username</label>
</div>
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control form-control-lg border-end-1" id="inputChoosePassword" placeholder="Masukan Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
												</div>
											</div>
											<div class="col-md-6">
											</div>
											<div class="col-md-6 text-end">	<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">Lupa Password ?</a>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-lg btn-primary">Masuk</button>
												</div>
											</div>
										<?= form_close() ?>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
    <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lupa Password ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Jika anda lupa password, silahkan hubungi admin desa untuk melakukan reset password operator.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
	<!-- Bootstrap JS -->
	<script src="<?= base_url("template/vertical/js/bootstrap.bundle.min.js") ?>"></script>
	<!--plugins-->
	<script src="<?= base_url("template/vertical/js/jquery.min.js") ?>"></script>
	<script src="<?= base_url("template/vertical/plugins/simplebar/js/simplebar.min.js") ?>"></script>
	<script src="<?= base_url("template/vertical/plugins/metismenu/js/metisMenu.min.js") ?>"></script>
	<script src="<?= base_url("template/vertical/plugins/perfect-scrollbar/js/perfect-scrollbar.js") ?>"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
</body>

</html>