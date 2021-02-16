<?php
function FLUSH_clinic()
{
    Mixin\T_flush('beds');
    Mixin\T_flush('bed_type');
    Mixin\T_flush('bypass');
    Mixin\T_flush('bypass_date');
    Mixin\T_flush('bypass_time');
    Mixin\T_flush('bypass_preparat');
    Mixin\T_flush('chat');
    Mixin\T_flush('division');
    Mixin\T_flush('guides');
    Mixin\T_flush('investment');
    Mixin\T_flush('laboratory_analyze');
    Mixin\T_flush('laboratory_analyze_type');
    Mixin\T_flush('members');
    Mixin\T_flush('multi_accounts');
    Mixin\T_flush('notes');
    Mixin\T_flush('operation');
    Mixin\T_flush('operation_inspection');
    Mixin\T_flush('operation_member');
    Mixin\T_flush('operation_stats');
    // Mixin\T_flush('province');
    // Mixin\T_flush('region');
    Mixin\T_flush('service');
    Mixin\T_flush('storage_orders');
    Mixin\T_flush('storage_preparat');
    Mixin\T_flush('storage_type');
    Mixin\T_flush('templates');
    Mixin\T_flush('users');
    Mixin\T_flush('user_card');
    Mixin\T_flush('user_stats');
    Mixin\T_flush('visit');
    Mixin\T_flush('visit_price');
    Mixin\T_flush('visit_inspection');
    Mixin\T_flush('wards');

}

function division_temp()
{
    Mixin\insert('division', array('level' => 10, 'title' => 'Радиология', 'name' => 'Радиолог', 'assist' => 2));
    Mixin\insert('division', array('level' => 10, 'title' => 'МРТ', 'name' => 'МРТ', 'assist' => 1));
    Mixin\insert('division', array('level' => 10, 'title' => 'Рентген', 'name' => 'Рентгенолог', 'assist' => 1));
    Mixin\insert('division', array('level' => 10, 'title' => 'МСКТ', 'name' => 'МСКТ', 'assist' => 1));
    Mixin\insert('division', array('level' => 10, 'title' => 'Маммография', 'name' => 'Маммограф', 'assist' => 1));
    Mixin\insert('division', array('level' => 10, 'title' => 'УЗИ', 'name' => 'УЗИ', 'assist' => null));
    Mixin\insert('division', array('level' => 6, 'title' => 'Лаборатория', 'name' => 'Лаборант', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Хирургия', 'name' => 'Хирург', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Гинекология', 'name' => 'Гинеколог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Неврология', 'name' => 'Невролог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Оториноларинголог', 'name' => 'Лор', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Кардиология', 'name' => 'Кардиолог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Урология', 'name' => 'Уролог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Ревматология', 'name' => 'Ревматолог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Стоматология', 'name' => 'Стамотолог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Терапия', 'name' => 'Терапевт', 'assist' => null));
	Mixin\insert('division', array('level' => 5, 'title' => 'Нейрохирургия', 'name' => 'Нейрохирург', 'assist' => null));
	Mixin\insert('division', array('level' => 5, 'title' => 'Травматология', 'name' => 'Травматолог', 'assist' => null));
    Mixin\insert('division', array('level' => 12, 'title' => 'Физиотерапия', 'name' => 'Физиотерапевт', 'assist' => null));
    Mixin\insert('division', array('level' => 13, 'title' => 'Процедурная', 'name' => 'Процедурная мед-сестра/брат', 'assist' => null));
}

function users_temp()
{
    return Mixin\insert('users', array('parent_id' => null, 'username' => 'admin', 'password' => 'd033e22ae348aeb5660fc2140aec35850c4da997', 'user_level' => 1));
}

function service_temp()
{
    return Mixin\insert('service', array('id' => 1, 'user_level' => 1, 'name' => "Стационарный Осмотр", 'type' => 101));
}
?>
