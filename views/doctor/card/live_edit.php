<?php
require_once '../../../tools/warframe.php';
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {
	$update_field='';
	if(isset($input['date'])) {
		$update_field.= "date='".$input['date']."'";
	} else if(isset($input['description'])) {
		$update_field.= "description='".$input['description']."'";
	}
	if($update_field && $input['id']) {
		$sql = "UPDATE notes SET $update_field WHERE id='" . $input['id'] . "'";
		$stm = $db->prepare($sql)->execute();
	}
}
