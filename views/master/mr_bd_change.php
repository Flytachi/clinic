<?php
require_once '../../tools/warframe.php';

if ($_GET['status'] == "new") {

    $db->exec("ALTER TABLE `beds` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `queue` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visits` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_analyzes` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_applications` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_beds` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_bypass` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_bypass_events` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_bypass_event_applications` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_bypass_transactions` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_investments` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_operations` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_orders` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_services` CHANGE `user_id` `patient_id` INT(11);");
    $db->exec("ALTER TABLE `visit_service_transactions` CHANGE `user_id` `patient_id` INT(11);");

    echo "success";

}elseif ($_GET['status'] == "old") {

    $db->exec("ALTER TABLE `beds` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `queue` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visits` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_analyzes` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_applications` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_beds` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_bypass` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_bypass_events` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_bypass_event_applications` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_bypass_transactions` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_investments` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_operations` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_orders` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_services` CHANGE `patient_id` `user_id` INT(11);");
    $db->exec("ALTER TABLE `visit_service_transactions` CHANGE `patient_id` `user_id` INT(11);");

    echo "success";

}else echo "Not action";

?>