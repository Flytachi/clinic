<?php
require_once '../tools/warframe.php';
is_module('queue');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= ShowTitle() ?></title>

	<!-- Global stylesheets -->
	<link rel="shortcut icon" href="<?= stack("assets/images/logo.png") ?>" type="image/x-icon">
	<link href="<?= stack("assets/fonts/font.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/bootstrap_limitless.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/layout.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/components.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/colors.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/my_css/style.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/my_css/ckeditor.css") ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

    <!-- Core JS files -->
	<script src="<?= stack("global_assets/js/main/jquery.min.js") ?>"></script>

</head>

<body>

    <?php if($panel = $db->query("SELECT * FROM panels WHERE ip LIKE '".trim($_SERVER['REMOTE_ADDR'])."';")->fetch()): ?>
        <?php $rooms = json_decode($panel['rooms']); ?>
        <div class="content">
        
            <div class="row">

                <?php foreach ($db->query("SELECT * FROM rooms WHERE id IN (".implode(",", $rooms).");") as $room): ?>
                    <div class="col-3">
                        <div class="card" style="height: 600px;">
                            <div class="card-header bg-dark">

                                <div class="row">
                                    <div class="col-4 text-left">
                                        <span style="font-weight: bold;font-size: 27px;"><?= $room['title'] ?></span>
                                    </div>
                                    <div class="col-8 text-right">
                                        <span style="font-weight: bold;font-size: 22px;"><?= $room['description'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody style="font-weight: bold;font-size: 20px;" class="text-center" id="Troom-<?= $room['id'] ?>">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>

        <script>
            $(document).ready(function(){
                setInterval(function() {
                    Checker();
                }, 1000);
            });

            function playMusic() {
                var audio = new Audio(); // Создаём новый элемент Audio
                audio.src = '/static/audio/music'; // Указываем путь к звуку "клика"
                audio.muted = "";
                audio.autoplay = true; // Автоматически запускаем
            }

            function Checker(){
                $.ajax({
                    type: "POST",
                    url: "<?= ajax('check_queue') ?>",
                    data: { panel:<?= $panel['id'] ?> },
                    success: function (result) {
                        var r = JSON.parse(result);
                        if(r.status == 1) for (let index = 0; index < r.data.length; index++) Creater(r.data[index]);
                        else if (r.status == 201) UpdatePanel(r.id);
                    },
                });
            }

            function UpdatePanel(id) {
                $.ajax({
                    type: "POST",
                    url: "<?= add_url() ?>",
                    data: { model: "PanelModel", id:id, is_active:1 },
                    success: function (data) {
                        location.reload();
                    },
                });
            }

            function Creater(element){
                if (element.is_delete) {
                    Delete(element);
                }
                if (document.querySelector("#Troom-"+element.room_id)) {
                    
                    if (!document.querySelector("#item_"+element.room_id+"-"+element.user_id)) {
                        var table = document.querySelector("#Troom-"+element.room_id);
                        let tr = document.createElement("tr");
                        let td = document.createElement("td");
                        td.innerHTML = element.user_id;
                        if (element.is_accept) tr.style.backgroundColor = "rgb(0, 255, 0)";
                        tr.id = "item_"+element.room_id+"-"+element.user_id;
                        tr.dataset.is_accept = element.is_accept;
                        tr.append(td);
                        table.append(tr);
                    }else {
                        if (element.is_accept) Update(element);
                    }

                } else location.reload();
            }

            function Delete(element) {
                $.ajax({
                    type: "GET",
                    url: "<?= del_url(null, "Queue") ?>",
                    data: { id:element.id },
                    success: function (data) {
                        $(`#item_${element.room_id}-${element.user_id}`).css("background-color", "rgb(244, 67, 54)");
                        $(`#item_${element.room_id}-${element.user_id}`).css("color", "white");
                        $(`#item_${element.room_id}-${element.user_id}`).fadeOut(900, function() {
                            $(this).remove();
                        });
                    },
                });
            }

            function Update(element) {
                var item = document.querySelector(`#item_${element.room_id}-${element.user_id}`);
                if (item.dataset.is_accept == "null") {
                    item.dataset.is_accept = element.is_accept;
                    playMusic();
                    $(`#item_${element.room_id}-${element.user_id}`).fadeIn(900, function() {
                        $(this).css("background-color", "rgb(0, 255, 0)");
                    });
                }
            }
        </script>
    <?php endif; ?>
    
</body>
</html>