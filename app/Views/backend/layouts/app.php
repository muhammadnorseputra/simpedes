<?php  
$theme = get_cookie('simpedes-theme');
$color = get_cookie('simpedes-color');
$sidebarColor = get_cookie('sidebarColor');
$colorScheme = implode(" ", [$theme, $color, $sidebarColor])
?>

<!doctype html>
<html lang="en" class="<?= $colorScheme ?>">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= base_url("template/vertical/images/favicon-32x32.png") ?>" type="image/png" />
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
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="<?= base_url("template/vertical/css/dark-theme.css") ?>" />
	<link rel="stylesheet" href="<?= base_url("template/vertical/css/semi-dark.css") ?>" />
	<link rel="stylesheet" href="<?= base_url("template/vertical/css/header-colors.css") ?>" />
	<!-- Custom CSS -->
	 <?= $this->renderSection('css'); ?>
	<title><?= esc($title) ?? 'Administrasi Pemerintahan Desa' ?></title>
</head>

<body>
	<!--wrapper-->
	<?php  
		$sidebarToggle = get_cookie('sidebarToggled') === "true" ? 'toggled' : '';
	?>
	<div class="wrapper <?= $sidebarToggle ?>">
		
		<!--sidebar wrapper -->
		<?= $this->include('backend/layouts/sidebar'); ?>
		<!--end sidebar wrapper -->
		
		<!--start header -->
		<?= $this->include('backend/layouts/header'); ?>
		<!--end header -->
		
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
			  <?= $this->renderSection('content'); ?>
			</div>
		</div>
		<!--end page wrapper -->

		<?= $this->include('backend/layouts/footer'); ?>
	</div>
	

	<!-- search modal -->
    <div class="modal" id="SearchModal" tabindex="-1">
		<div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down">
		  <div class="modal-content">
			<div class="modal-header gap-2">
			  <div class="position-relative popup-search w-100">
				<input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search" placeholder="Search">
				<span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-4"><i class='bx bx-search'></i></span>
			  </div>
			  <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="search-list">
				   
				</div>
			</div>
		  </div>
		</div>
	  </div>
    <!-- end search modal -->

	<!--start switcher-->
	<div class="switcher-wrapper">
		<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
		</div>
		<div class="switcher-body">
			<div class="d-flex align-items-center">
				<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
			</div>
			<hr/>
			<h6 class="mb-0">Theme Styles</h6>
			<hr/>
			<?php  
			$dark_checked = ($theme === "dark-theme") ? "checked" : "";
			$light_checked = ($theme === "light-theme") ? "checked" : "";
			$semidark_checked = ($theme === "semi-dark") ? "checked" : "";
			$minimal_checked = ($theme === "minimal-theme") ? "checked" : "";
			?>
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" <?= $light_checked ?>>
					<label class="form-check-label" for="lightmode">Light</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode" <?= $dark_checked ?>>
					<label class="form-check-label" for="darkmode">Dark</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark" <?= $semidark_checked ?>>
					<label class="form-check-label" for="semidark">Semi Dark</label>
				</div>
			</div>
			<hr/>
			<div class="form-check">
				<input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault" <?= $minimal_checked ?>>
				<label class="form-check-label" for="minimaltheme">Minimal Theme</label>
			</div>
			<hr/>
			<h6 class="mb-0">Header Colors</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator headercolor1" id="headercolor1"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor2" id="headercolor2"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor3" id="headercolor3"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor4" id="headercolor4"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor5" id="headercolor5"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor6" id="headercolor6"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor7" id="headercolor7"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor8" id="headercolor8"></div>
					</div>
					<div class="col">
						<div class="btn btn-sm btn-default headercolor9" id="headercolor9">Reset</div>
					</div>
				</div>
			</div>
			<hr/>
			<h6 class="mb-0">Sidebar Colors</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
					</div>
					<div class="col">
						<div class="btn btn-sm btn-default sidebarcolor9" id="sidebarcolor9">Reset</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="<?= base_url("template/vertical/js/bootstrap.bundle.min.js") ?>"></script>
	<!--plugins-->
	<script src="<?= base_url("template/vertical/js/jquery.min.js") ?>"></script>
	<script src="<?= base_url("template/vertical/plugins/simplebar/js/simplebar.min.js") ?>"></script>
	<script src="<?= base_url("template/vertical/plugins/metismenu/js/metisMenu.min.js") ?>"></script>
	<script src="<?= base_url("template/vertical/plugins/perfect-scrollbar/js/perfect-scrollbar.js") ?>"></script>
	<!--app JS-->
	<script src="<?= base_url("template/vertical/js/app.js") ?>"></script>
	<!-- Custom JS -->
	 <?= $this->renderSection('script'); ?>
</body>

</html>