<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand gap-3">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>

					<div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
						<a href="javascript:;" class="btn d-flex align-items-center"><i class='bx bx-search'></i>Search</a>
					 </div>


					  <div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center gap-1">
							<li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
								<a class="nav-link" href="javascript:;"><i class='bx bx-search'></i>
								</a>
							</li>

						</ul>
					</div>
					<div class="user-box dropdown px-3">
						<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<?php if(session()->photo === null): ?>
								<img src="<?= base_url("assets/images/users/default.png") ?>" class="user-img" alt="user default">
							<?php else: ?>
								<img src="<?= base_url("assets/images/users/".session()->get('photo')) ?>" class="user-img" alt="<?= session()->name; ?>">
							<?php endif; ?>
							<div class="user-info">	
								<p class="user-name mb-0"><?= session()->get('name') ? session()->get('name') : session()->get('username') ?></p>
								<p class="designattion mb-0"><?= session()->get('role'); ?></p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><button class="dropdown-item d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bx bx-user fs-5"></i><span>Profile</span></button></li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout') ?>"><i class="bx bx-log-out-circle"></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>