<!-- Информация о койках -->
<div class="mb-3">
	<h4 class="mb-0 font-weight-semibold">Койки</h4>
	<span class="text-muted d-block">Информация о койках</span>
</div>

<?php $bed_type = $db->query("SELECT id, name FROM bed_type")->fetchAll(); ?>

<div class="row">

	<div class="col-sm-6 col-xl-3">

		<!-- Invitation stats colored -->
		<div class="card text-center bg-blue-400 has-bg-image">
			<div class="card-body">
				<h6 class="font-weight-semibold mb-0 mt-1">Информация о койках</h6>
				<div class="opacity-75 mb-3">Всего
                    <span id="progress_percentage_all"><?= $db->query("SELECT id FROM beds")->rowCount() ?></span>
                </div>
				<div class="svg-center position-relative mb-1" id="progress_percentage"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
                <span style="display:none" id="progress_percentage_open"><?= $db->query("SELECT id FROM beds WHERE user_id IS NULL")->rowCount() ?></span>
                <span style="display:none" id="progress_percentage_close"><?= $db->query("SELECT id FROM beds WHERE user_id IS NOT NULL")->rowCount() ?></span>

                <div class="row">

                    <div class="col-12">Свободные</div>

                    <?php foreach ($bed_type as $row): ?>
                        <div class="col-6">
                            <div class="text-uppercase font-size-xs"><?= $row['name'] ?></div>
                            <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                <?= $db->query("SELECT id FROM beds WHERE user_id IS NULL AND types = {$row['id']}")->rowCount() ?>
                            </h5>
                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="row">

                    <div class="col-12">Занятые</div>
                    <?php foreach ($bed_type as $row): ?>
                        <div class="col-6">
                            <div class="text-uppercase font-size-xs"><?= $row['name'] ?></div>
                            <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                <?= $db->query("SELECT id FROM beds WHERE user_id IS NOT NULL AND types = {$row['id']}")->rowCount() ?>
                            </h5>
                        </div>
                    <?php endforeach; ?>
                </div>

			</div>
		</div>
		<!-- /invitation stats colored -->

	</div>

    <?php foreach ($FLOOR as $key => $value): ?>
        <div class="col-sm-6 col-xl-3">

    		<!-- Invitation stats white -->
    		<div class="card text-center">
    			<div class="card-body">
    				<h6 class="font-weight-semibold mb-0 mt-1"><?= $value ?></h6>
    				<div class="text-muted mb-3">Всего
                        <span id="progress_percentage_<?=$key?>_all"><?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key")->rowCount() ?></span>
                    </div>
    				<div class="svg-center position-relative mb-1" id="progress_percentage_<?=$key?>"></div>
    			</div>

    			<div class="card-body border-top-0 pt-0">

                    <span style="display:none" id="progress_percentage_<?=$key?>_open"><?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key AND user_id IS NULL")->rowCount() ?></span>
                    <span style="display:none" id="progress_percentage_<?=$key?>_close"><?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key AND user_id IS NOT NULL")->rowCount() ?></span>

                    <div class="row">

                        <div class="col-12">Свободные</div>

                        <?php foreach ($bed_type as $row): ?>
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs"><?= $row['name'] ?></div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                    <?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key AND user_id IS NULL AND bd.types = {$row['id']}")->rowCount() ?>
                                </h5>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <div class="row">

                        <div class="col-12">Занятые</div>

                        <?php foreach ($bed_type as $row): ?>
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs"><?= $row['name'] ?></div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                    <?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key AND user_id IS NOT NULL AND bd.types = {$row['id']}")->rowCount() ?>
                                </h5>
                            </div>
                        <?php endforeach; ?>

                    </div>

    			</div>
    		</div>
    		<!-- /invitation stats white -->

    	</div>
    <?php endforeach; ?>

</div>
<!-- /Информация о койках -->
