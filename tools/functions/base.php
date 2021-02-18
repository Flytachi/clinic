<?php


function division_temp()
{
    global $db;
    try {
        $db->beginTransaction();

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

        $db->commit();
        return 200;
    } catch (Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }
}

function users_temp()
{
    global $db;
    try {
        $db->beginTransaction();

        Mixin\insert('users', array('parent_id' => null, 'username' => 'admin', 'password' => 'd033e22ae348aeb5660fc2140aec35850c4da997', 'user_level' => 1));

        $db->commit();
        return 200;
    } catch (Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }
}

function service_temp()
{
    global $db;
    try {
        $db->beginTransaction();

        Mixin\insert('service', array('id' => 1, 'user_level' => 1, 'name' => "Стационарный Осмотр", 'type' => 101));

        $db->commit();
        return 200;
    } catch (Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }
}

?>
