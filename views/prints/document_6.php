<?php
require_once '../../tools/warframe.php';
is_module('module_laboratory');

$comp = $db->query("SELECT * FROM company_constants")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}

$docs = $db->query("SELECT vs.id, us.gender, vs.user_id, vs.parent_id, vs.service_id, us.dateBith, vs.add_date, vs.completed FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

	<?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">
    <style>
        .hr-1 {
			margin-top: 0.3rem;
            margin-bottom: 0.7rem;
            border: 2px solid rgb(0, 0, 0);
        }
		
		
		body {
			backdrop-filter: none;
			margin: 0;
			padding: 0;
			background-color: #FFF;
			font: 15pt "Tahoma";
		}

		* {
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}

		.page {
		  width: 21cm;
		  min-height: 29.7cm;
		  padding: 1cm;
		  margin: 1cm auto;
		  border: 1px #000 solid;
		  border-radius: 10px;
		  background: white;
		  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		}

		.subpage {
		  padding: 0.7cm;
		  border: 2px black solid;
		  height: 352mm;
		  outline: 2cm #FFF solid;
		}

		@page {
		  size: A4;
		  margin: 0;
		}

		@media print {
		  .page {
			margin: 0;
			border: initial;
			border-radius: initial;
			width: initial;
			min-height: initial;
			box-shadow: initial;
			background: initial;
			page-break-after: always;
		  }
		}
		
		.hr-3{
		   white-space: pre;
		    border: 1px solid black; 
			border-bottom: none; 
			padding: 3px; 
			display: inline; 
			background: #efecdf; 
			font-weight: bold; 
			font-size: 90%; 
			margin: 0; 
			white-space: nowrap; 
		} 
		 
		
		.page_title{
			font-size: 1.2rem;
		}
		
		p {
			margin-bottom:0;
			margin-left:15px;
		}
    </style>
  
</head>
<body>    


	<div class="book">

		<div class="page">
			<div class="subpage pagge_2">
			
				<div class="row page_header">
				
					<div class="col-sm-4 col-md-4 col-lg-4">
						
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 text-center">
						<img src="<?= img('prints/icon/uzb_gerb.png') ?>" width="150px" height="100px">
					</div>

					<div class="col-sm-4 col-md-4 col-lg-4 text-center" style="font-size: 12px;">
						Приложение<br>
						утверждено расположением<br> 
						Минестерства здравоохранения и<br>
						социальной защиты населения<br>
						Республики Узбекистан<br>
						от 29.01.2021 года, №84 
					</div>

					
				</div>
				
				<div class="row page_title">
					
					<div class="col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:15px;">
						<strong>
							МИНИСТЕРСТВО ЗДРАВООХРАНИНИЯ И СОЦИАЛЬНОЙ<br>
							ЗАЩИТЫ НАСЕЛЕНИЯ РЕСПУБЛИКИ УЗБЕКИСТАН
						</strong>
					</div>
					
				</div>

				<div class="hr-1"></div>
				<legend></legend>

				
				<div class="text-left">
					<b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
					<b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
					<b>Пол: </b><?= ($docs->gender) ? "Мужской" : "Женский" ?><br>
					<b>Регистрационный номер: </b><?= $docs->id ?><br>
					<b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
					<b>Дата поступления: </b><?= date('d.m.Y H:i', strtotime($docs->add_date)) ?><br>
					<b>Дата выполнения: </b><?= date('d.m.Y H:i', strtotime($docs->completed)) ?><br>
				</div>

				<legend></legend>

				<div class="table-responsive card">
					<table class="minimalistBlack">
						<thead>
							<tr>
								<th colspan="4" class="text-center">Иследование методом ПЦР</th>
							</tr>
							<tr id="text-h">
								<th class="text-center" style="width:25%">Тест</th>
								<th class="text-center" style="width:25%">Результат</th>
								<th class="text-center" style="width:25%">Ед</th>
								<th class="text-center" style="width:25%">Норма</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$norm = "scl.name, scl.code, scl.standart";
							$sql = "SELECT vl.id, vl.result, vl.deviation, $norm, scl.unit FROM visit_analyze vl LEFT JOIN service_analyze scl ON (vl.analyze_id = scl.id) WHERE vl.visit_id = {$_GET['id']}";
							foreach ($db->query($sql) as $row) {
								?>
								<tr id="text-b">
									<td class="text-left"><?= $row['name'] ?></td>
									<td class="text-right"><?= $row['result'] ?></td>
									<td class="text-right">
										<?= preg_replace("#\r?\n#", "<br />", $row['unit']) ?>
									</td>
									<td class="text-right">
										<?= preg_replace("#\r?\n#", "<br />", $row['standart']) ?>
									</td>
								</tr>
								<?php
							}
							?>
							<tr>
								<td colspan="4" class="text-right">
									<b>Иследованный биоматериал:</b> Мазок из носоглотки
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<b>Заключение/Примечание:</b> В анализируемом образце РНК коронавируса COVID-19
									отсутсвует или его концентрация ниже уровня чуствительности
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="row">
					<div class="col-4"></div>
					<div class="col-4 h5 text-left">
						<strong>Лечащий врач</strong>
					</div>
					<div class="col-4 h6 text-right">
						<em><strong><?= get_full_name($docs->parent_id) ?></strong></em>
					</div>
				</div>

				<div class="row">
					<div class="col-4"></div>
					<div class="col-4 h4 text-left">
						<strong>Директор</strong>
					</div>
					<div class="col-4 h5 text-right">
						<!-- <em><strong><?= get_full_name($db->query("SELECT id FROM users WHERE user_level = 8")->fetch()['id']) ?></strong></em> -->
						_______________
					</div>
				</div>

			</div>
		</div>
	
	</div>

</body>
</html>