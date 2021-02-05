<?php
require_once '../../tools/warframe.php';
is_auth();
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<style media="screen">
.fade-out-siblings {
     --gutter: 2.5rem;
     background: #fffff;
     text-align: center;
     grid-gap: 2.5rem;
     padding: 1.5rem;
     display: grid;
     margin: 2rem 0;
     pointer-events: none;
}

.fade-out-siblings > * {
    box-shadow: 0 2px 30px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    background: #fff;
    padding: 2rem 1rem;
    cursor: pointer;
    pointer-events: auto;
    transition: 300ms opacity, 500ms transform;
}

.fade-out-siblings:hover > * {
    opacity: 0.4;
}

.fade-out-siblings:hover > *:hover {
    transform: scale(1.1);
    opacity: 1;
}

@media (min-width: 40em) {
    .fade-out-siblings {
        grid-template-columns: repeat(3, 1fr);
    }

    .fade-out-siblings > * {
        padding: 2rem 1rem;
    }
}
</style>

<!-- Theme JS files -->
<script src="<?= stack("global_assets/js/demo_pages/widgets_stats.js") ?>"></script>
<script src="<?= stack("vendors/js/jquery.chained.js") ?>"></script>
<!-- /theme JS files -->

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
			<!-- /page header -->

			<script src="<?= stack("global_assets/js/demo_pages/dashboard.js") ?>"></script>

			<!-- Content area -->
			<div class="content">

                <article class="fade-out-siblings">

                    <!-- Общий отчет -->
                    <?php if (permission(8)): ?>
                        <a href="<?= viv('reports/all/content_1') ?>" class="btn btn-outline-success" style="font-size:1rem;">Общий отчет</a>
                    <?php else: ?>
                        <button class="btn btn-outline-danger" style="font-size:1rem;">Общий отчет</button>
                    <?php endif; ?>
                    <!-- end -->

                    <!-- Касса -->
                    <?php if (permission([3, 8, 32])): ?>
                        <a href="<?= viv('reports/cashbox/content_1') ?>" class="btn btn-outline-success" style="font-size:1rem;">Касса</a>
                    <?php else: ?>
                        <button class="btn btn-outline-danger" style="font-size:1rem;">Касса</button>
                    <?php endif; ?>
                    <!-- end -->

                    <!-- Лаборатория -->
                    <?php if (permission([6, 8])): ?>
                        <a href="<?= viv('reports/laboratory/content_1') ?>" class="btn btn-outline-success" style="font-size:1rem;">Лаборатория</a>
                    <?php else: ?>
                        <button class="btn btn-outline-danger" style="font-size:1rem;">Лаборатория</button>
                    <?php endif; ?>
                    <!-- end -->

                    <!-- Диагностика -->
                    <?php if (permission([8, 10])): ?>
                        <a href="<?= viv('reports/diagnostic/content_1') ?>" class="btn btn-outline-success" style="font-size:1rem;">Диагностика</a>
                    <?php else: ?>
                        <button class="btn btn-outline-danger" style="font-size:1rem;">Диагностика</button>
                    <?php endif; ?>
                    <!-- end -->

                    <!-- Анестезия -->
                    <?php if (permission([8, 11])): ?>
                        <a href="<?= viv('reports/anest/content_1') ?>" class="btn btn-outline-success" style="font-size:1rem;">Анестезия</a>
                    <?php else: ?>
                        <button class="btn btn-outline-danger" style="font-size:1rem;">Анестезия</button>
                    <?php endif; ?>
                    <!-- end -->

                    <!-- Физиотерапия -->
                    <?php if (permission([8, 12])): ?>
                        <a href="<?= viv('reports/physio/content_1') ?>" class="btn btn-outline-success" style="font-size:1rem;">Физиотерапия</a>
                    <?php else: ?>
                        <button class="btn btn-outline-danger" style="font-size:1rem;">Физиотерапия</button>
                    <?php endif; ?>
                    <!-- end -->

                    <!-- Физиотерапия -->
                    <?php if (permission([8, 12])): ?>
                        <!-- <a href="<?= viv('reports/physio/content_1') ?>" class="btn btn-outline-secondary" style="font-size:1rem;">Процедурная</a> -->
                        <button class="btn btn-outline-secondary" style="font-size:1rem;">Процедурная</button>
                    <?php else: ?>
                        <button class="btn btn-outline-danger" style="font-size:1rem;">Процедурная</button>
                    <?php endif; ?>
                    <!-- end -->

                </article>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
