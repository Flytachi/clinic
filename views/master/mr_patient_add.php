<?php

use Mixin\HellCrud;

require_once '../../tools/warframe.php';

$users = (new UserModel)->Where("user_level = 15")->list();

foreach ($users as $user) {
    $patient = array(
        'id' => $user->id,
        'parent_id' => $user->parent_id,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'father_name' => $user->father_name,
        'birth_date' => $user->birth_date,
        'province_id' => $user->province_id,
        'region_id' => $user->region_id,
        'passport_seria' => $user->passport_seria,
        'passport_pin_fl' => $user->passport_pin_fl,
        'work_place' => $user->work_place,
        'work_position' => $user->work_position,
        'phone_number' => $user->phone_number,
        'address_residence' => $user->address_residence,
        'address_registration' => $user->address_registration,
        'gender' => $user->gender,
        'status' => $user->status,
        'is_foreigner' => $user->is_foreigner,
        'insurance_policy' => $user->insurance_policy,
        'add_date' => $user->add_date,
    );
    HellCrud::insert_or_update('patients', $patient);
}
echo "success";
?>