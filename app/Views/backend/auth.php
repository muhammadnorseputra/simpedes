<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= base_url("assets/images/app/logo.png") ?>" type="image/png" />
	<!--plugins-->
	<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/notifications/css/lobibox.min.css") ?>" />
	<!-- loader-->
	<link href="<?= base_url("template/vertical/css/pace.min.css") ?>" rel="stylesheet" />
	<script src="<?= base_url("template/vertical/js/pace.min.js") ?>"></script>
	<!-- Bootstrap CSS -->
	<link href="<?= base_url("template/vertical/css/bootstrap.min.css") ?>" rel="stylesheet">
	<link href="<?= base_url("template/vertical/css/bootstrap-extended.css") ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?= base_url("template/vertical/css/app.css") ?>" rel="stylesheet">
	<link href="<?= base_url("template/vertical/css/icons.css") ?>" rel="stylesheet">
	<title><?= $config->siteSortName ?> - <?= $config->siteDesc ?></title>
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
                                    <h2 class="text-white"><?= $config->siteName ?></h2>
                                </div>
                            </div>
                            <div class="card-body text-white text-center fs-5">
								<?= $config->siteDesc ?>
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
										<h5 class="mb-2">Masuk Aplikasi <?= ucwords(strtolower($config->siteSortName)) ?></h5>
										<p class="mb-0">Silahkan login dengan akun pegawai anda.</p>
									</div>
									<div class="form-body">
										<div id="message"></div>
										<?= form_open(base_url("auth/action"), ["id" => "formAuth", "class" => 'row g-3 needs-validation', 'novalidate' => '']) ?>
											<div class="col-12">
											<div class="form-floating">
												<input type="text" required minlength="3" name="username" value="<?= set_value('username') ?>" class="form-control" id="floatingInputUsername" placeholder="Masukan usernamel">
												<label for="floatingInputUsername">Masukan Username</label>
												<div id="floatingInputUsername" class="invalid-feedback">
													Please choose a username.
												</div>
											</div>
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="position-relative input-icon" id="show_hide_password">
													<input type="password" required name="password" class="form-control form-control-lg border-end-1" id="inputChoosePassword" placeholder="Masukan Password"> 
													<span class="position-absolute top-0 pt-2 mt-1"><em class="bx bx-key"></em></span>
													<a href="javascript:;" class="bg-transparent position-absolute end-0" data-bs-toggle="tooltip" data-bs-placement="top" style="top: -30px">
														<i class="bx bx-hide fs-5 text-secondary"></i>
													</a>
													<div id="floatingInputUsername" class="invalid-feedback">
														Please choose a password.
													</div>
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
											<div class="col-12">
												<p class="text-center text-secondary">&copy; Dikembangkan oleh PPIK . 2024 - <?= date('Y') ?></p>
												<p class="text-center">Version <?= $config->siteVersion ?></p>
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
                <div class="modal-body">Jika anda lupa password, silahkan hubungi operator desa / dinas untuk melakukan reset password pegawai.</div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" aria-label="Oke" class="btn btn-primary">OKE</button>
                </div>
            </div>
        </div>
    </div>
	<!-- Bootstrap JS -->
	<script src="<?= base_url("template/vertical/js/bootstrap.bundle.min.js") ?>"></script>
	<!--plugins-->
	<script src="<?= base_url("template/vertical/js/jquery.min.js") ?>"></script>
	<script src="<?= base_url("template/vertical/plugins/notifications/js/lobibox.min.js") ?>"></script>
	<script src="<?= base_url("template/vertical/plugins/notifications/js/notifications.min.js") ?>"></script>
	<!--Password show & hide js -->
	<script src="<?= base_url("assets/js/notification.js") ?>"></script>
	<script>
		$(document).ready(function () {
			var exampleEl = $("a")
			var tooltip = new bootstrap.Tooltip(exampleEl, {
				trigger: 'hover',
				title: 'Lihat Password'
			})

			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show-alt");
					// $(this).attr('title', 'Show Password');
					tooltip._config.title = "Lihat Password";
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show-alt");
					// $(this).attr('title', 'Hide Password');
					tooltip._config.title = "Sembuyikan Password";
				}
				tooltip.update();
			});

			$("form#formAuth").on("submit", function(event) {
				event.preventDefault();
				let _ = $(this)
				$containerMsg = $("#message"),
				$url = _.attr('action'),
				$data = _.serialize(),
				$method = _.attr('method');

				if (!this.checkValidity()) {
					event.preventDefault()
					event.stopPropagation()
				}
				this.classList.add('was-validated')
				$.ajax({
					url: $url,
					method: $method,
					data: $data,
					success: function (res) {
						
						if(res.status !== true) {
							// NotifError(res.message)
							$containerMsg.attr("class", "alert alert-danger d-flex justify-content-start align-items-center p-2").html(`<span class="ms-2">${res.message}</span> <i class="bx bxs-error-circle bx-sm ms-auto"></i>`);
						}
						if(res.status === true) {
							$containerMsg.attr("class", "alert alert-success d-flex justify-content-start align-items-center p-2").html(`<span class="ms-2">${res.message}</span> <i class="bx bxs-check-circle bx-sm ms-auto text-success"></i>`);
							NotifSuccess(`Success, mohon tunggu loading ...`)
							setTimeout(function() {
								window.location.href = res.data.redirect
							}, 1000)
						}
					},
					error: function(err) {
						$containerMsg.attr("class", "alert alert-danger d-flex justify-content-start align-items-center p-2").html(`<span class="ms-2">${ err.responseJSON.message || err.statusText} (${err.status})</span> <i class="bx bxs-error-circle bx-sm ms-auto"></i>`);
						// NotifError(`${ err.responseJSON.message || err.statusText} (${err.status})`)
					},
				})
			})
		});
	</script>
</body>

</html>