<?php
require_once '../../tools/warframe.php';
is_auth('master');

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

$DB_HEADER = "CREATE TABLE IF NOT EXISTS";
$DB_FOOTER = " ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

$MUL = array('beds' => 'bed' ,'wards' => 'floor');
$json = array();

foreach ($db->query("SHOW TABlES") as $table) {

	$sql = $DB_HEADER." `{$table['Tables_in_clinic']}` (";
	$column = "";
	$keys = "";

	foreach ($db->query("DESCRIBE {$table['Tables_in_clinic']}") as $col) {
		$column .= "`{$col['Field']}` {$col['Type']}";

		if ($col['Null'] == "YES") {
			$column .= " DEFAULT";
			if (is_null($col['Default'])) {
				$column .= " NULL";
			}else {
				$column .= " ".$col['Default'];
			}
		}else {
			$column .= " NOT NULL";
			if ($col['Default']) {
				$column .= " DEFAULT ".$col['Default'];
			}
		}

		if ($col['Extra']) {
			$column .= " ".strtoupper($col['Extra']);
		}

		switch ($col['Key']) {
			case "PRI":
				$keys .= "PRIMARY KEY (`{$col['Field']}`)";
				$keys.=",";
				break;

			case "MUL":
				$keys .= "UNIQUE KEY `{$MUL[$table['Tables_in_clinic']]}` (`{$col['Field']}`,`{$MUL[$table['Tables_in_clinic']]}`) USING BTREE";
				$keys.=",";
				break;
		}

		$column.=",";
		unset($col);
	}
	$column_keys = substr($column.$keys,0,-1);

	$sql .= $column_keys.")";
	$sql .= $DB_FOOTER.";";
	$json[] = $sql;
	unset($column);
	unset($keys);
}

echo json_encode($json);
header("Content-Dsisposition:attachment;filename=database.json");
?>
