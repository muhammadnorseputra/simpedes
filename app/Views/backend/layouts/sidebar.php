<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header d-flex justify-content-start align-items-center gap-3">
				<div class="ps-2">
					<img src="<?= base_url("assets/images/app/logo.png") ?>" width="30" class="rounded" alt="logo icon">
				</div>
				<div class="d-flex flex-column justify-content-center align-items-start">
					<h4 class="logo-text ms-0">Simpedes</h4>
					<span class="logo-desc small mutted lh-0 text-center">Kab. Balangan</span>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-menu-alt-left'></i></div>
			 </div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="<?= base_url('app/dashboard') ?>">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				
				<li class="menu-label">Pegawai</li>
				<li>
					<a href="<?= base_url('app/pegawai/unit_kerja') ?>">
						<div class="parent-icon"><i class='bx bx-buildings'></i>
						</div>
						<div class="menu-title">By Unit Kerja</div>
					</a>
				</li>

				<li class="menu-label">Data Master</li>
				<li>
					<a href="<?= base_url('app/master/pegawai') ?>">
						<div class="parent-icon"><i class='bx bx-user-plus'></i>
						</div>
						<div class="menu-title">Pegawai</div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('app/master/jabatan') ?>">
						<div class="parent-icon"><i class='bx bx-data'></i>
						</div>
						<div class="menu-title">Jabatan</div>
					</a>
				</li>
				<li class="menu-label">Referensi</li>
				<li>
					<a href="<?= base_url('app/referensi/agama') ?>">
						<div class="parent-icon"><i class='bx bx-flag'></i>
						</div>
						<div class="menu-title">Agama</div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('app/referensi/kecamatan') ?>">
						<div class="parent-icon"><i class='bx bx-map'></i>
						</div>
						<div class="menu-title">Kecamatan</div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('app/referensi/desa') ?>">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Desa</div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('app/referensi/jenis_workshop') ?>">
						<div class="parent-icon"><i class='bx bx-calendar-star'></i>
						</div>
						<div class="menu-title">Jenis Workshop</div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('app/referensi/tingkat_pendidikan') ?>">
						<div class="parent-icon"><i class='bx bx-layer'></i>
						</div>
						<div class="menu-title">Tingkat Pendidikan</div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('app/referensi/jurusan_pendidikan') ?>">
						<div class="parent-icon"><i class='bx bx-book-alt'></i>
						</div>
						<div class="menu-title">Jurusan Pendidikan</div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('app/referensi/rumpun_diklat') ?>">
						<div class="parent-icon"><i class='bx bx-collection'></i>
						</div>
						<div class="menu-title">Rumpun Diklat</div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('app/referensi/satuan_unit_kerja') ?>">
						<div class="parent-icon"><i class='bx bx-building'></i>
						</div>
						<div class="menu-title">Satuan Unit Kerja</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>