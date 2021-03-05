<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md sidebar-fixed">
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user-material">
			<div class="sidebar-user-material-body">
				<div class="card-body text-center">
					<h4 class="mb-0 text-white text-shadow-dark siya">Master</h4>
				</div>

				<div class="sidebar-user-material-footer">
					<a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>My account</span></a>
				</div>
			</div>

			<div class="collapse" id="user-nav">
				<ul class="nav nav-sidebar">
					<li class="nav-item">
						<a href="<?= logout() ?>" class="nav-link">
							<i class="icon-switch2"></i>
							<span>Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">

            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Рабочий стол</div> <i class="icon-menu" title="Main"></i>
                </li>

                <li class="nav-item">
                    <a href="<?= viv('master/index') ?>" class="nav-link legitRipple <?= viv_link('master/index') ?>">
                        <i class="icon-stack2"></i>
                        <span>Main</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= viv('master/panel') ?>" class="nav-link legitRipple <?= viv_link('master/panel') ?>">
                        <i class="icon-hammer-wrench"></i>
                        <span>Сontrol Panel</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= viv('master/server') ?>" class="nav-link legitRipple <?= viv_link('master/server') ?>">
                        <i class="icon-server"></i>
                        <span>Server</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= viv('master/database') ?>" class="nav-link legitRipple <?= viv_link('master/database') ?>">
                        <i class="icon-database"></i>
                        <span>Database</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= viv('master/visit_control') ?>" class="nav-link legitRipple <?= viv_link('master/visit_control') ?>">
                        <i class="icon-archive"></i>
                        <span>Сontrol of visits</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= viv('master/logs') ?>" class="nav-link legitRipple <?= viv_link('master/logs') ?>">
                        <i class="icon-price-tag3"></i>
                        <span>Logs</span>
                    </a>
                </li>

                <!-- <li class="nav-item">
                    <a href="test.php" class="nav-link legitRipple">
                        <i class="icon-width"></i>
                        <span>Tests</span>
                        <span class="badge bg-blue-400 align-self-center ml-auto">2.0</span>
                    </a>
                </li> -->
                <!-- /main -->
            </ul>

        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->
</div>
