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
        Mixin\insert('division', array('level' => 11, 'title' => 'Анестезия', 'name' => 'Анестезиолог', 'assist' => null));
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

function province_temp()
{
    global $db;
    try {
        $db->beginTransaction();

        Mixin\insert('province', array('id' => 1, 'name' => "Ташкент"));
		Mixin\insert('province', array('id' => 2, 'name' => "Андижанская область"));
		Mixin\insert('province', array('id' => 3, 'name' => "Бухарская область"));
		Mixin\insert('province', array('id' => 4, 'name' => "Ферганская область"));
	    Mixin\insert('province', array('id' => 5, 'name' => "Джизакская область"));
	    Mixin\insert('province', array('id' => 6, 'name' => "Наманганская область"));
		Mixin\insert('province', array('id' => 7, 'name' => "Навоинская область"));
		Mixin\insert('province', array('id' => 8, 'name' => "Кашкадарьинская область"));
		Mixin\insert('province', array('id' => 9, 'name' => "Самаркандская область"));
		Mixin\insert('province', array('id' => 10, 'name' => "Сырдарьинская область"));
		Mixin\insert('province', array('id' => 11, 'name' => "Сурхандарьинская область"));
		Mixin\insert('province', array('id' => 12, 'name' => "Хорезмская область"));
	    Mixin\insert('province', array('id' => 13, 'name' => "Республика Каракалпакистан"));

        $db->commit();
        return 200;
    } catch (Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }
}

function region_temp()
{
    global $db;
    try {
        $db->beginTransaction();

        Mixin\insert('region', array('id' => 1, 'province_id' => 1, 'name' => "Бектемирский район"));
        Mixin\insert('region', array('id' => 2, 'province_id' => 1, 'name' => "М.Улугбекский район"));
        Mixin\insert('region', array('id' => 3, 'province_id' => 1, 'name' => "Мирабадский район"));
        Mixin\insert('region', array('id' => 4, 'province_id' => 1, 'name' => "Алмазарский район"));
        Mixin\insert('region', array('id' => 5, 'province_id' => 1, 'name' => "Сергелиский район"));
        Mixin\insert('region', array('id' => 6, 'province_id' => 1, 'name' => "Учтепинский район"));
        Mixin\insert('region', array('id' => 7, 'province_id' => 1, 'name' => "Чиланзарский район"));
        Mixin\insert('region', array('id' => 8, 'province_id' => 1, 'name' => "Шайхантахурский район"));
        Mixin\insert('region', array('id' => 9, 'province_id' => 1, 'name' => "Юнусабадский район"));
        Mixin\insert('region', array('id' => 10, 'province_id' => 1, 'name' => "Яккасарайский район"));
        Mixin\insert('region', array('id' => 11, 'province_id' => 1, 'name' => "Яшнабадский район"));
        Mixin\insert('region', array('id' => 12, 'province_id' => 2, 'name' => "Андижан город"));
        Mixin\insert('region', array('id' => 13, 'province_id' => 2, 'name' => "Ханабад (город)"));
        Mixin\insert('region', array('id' => 14, 'province_id' => 2, 'name' => "Алтынкульский район"));
        Mixin\insert('region', array('id' => 15, 'province_id' => 2, 'name' => "Андижанский район"));
        Mixin\insert('region', array('id' => 16, 'province_id' => 2, 'name' => "Асакинский район"));
        Mixin\insert('region', array('id' => 17, 'province_id' => 2, 'name' => "Балыкчинский район"));
        Mixin\insert('region', array('id' => 18, 'province_id' => 2, 'name' => "Бустанский район"));
        Mixin\insert('region', array('id' => 19, 'province_id' => 2, 'name' => "Булакбашинский район"));
        Mixin\insert('region', array('id' => 20, 'province_id' => 2, 'name' => "Джалакудукский район"));
        Mixin\insert('region', array('id' => 21, 'province_id' => 2, 'name' => "Избасканский район"));
        Mixin\insert('region', array('id' => 22, 'province_id' => 2, 'name' => "Кургантепинский район"));
        Mixin\insert('region', array('id' => 23, 'province_id' => 2, 'name' => "Мархаматский район"));
        Mixin\insert('region', array('id' => 24, 'province_id' => 2, 'name' => "Пахтаабадский район"));
        Mixin\insert('region', array('id' => 25, 'province_id' => 2, 'name' => "Улугнорский район"));
        Mixin\insert('region', array('id' => 26, 'province_id' => 2, 'name' => "Ходжаабадский район"));
        Mixin\insert('region', array('id' => 27, 'province_id' => 2, 'name' => "Ходжаабадский район"));
        Mixin\insert('region', array('id' => 28, 'province_id' => 2, 'name' => "Шахриханский район"));
        Mixin\insert('region', array('id' => 29, 'province_id' => 3, 'name' => "Алатский район"));
        Mixin\insert('region', array('id' => 30, 'province_id' => 3, 'name' => "Бухарский район"));
        Mixin\insert('region', array('id' => 31, 'province_id' => 3, 'name' => "Гиждуванский район"));
        Mixin\insert('region', array('id' => 32, 'province_id' => 3, 'name' => "Жондорский район"));
        Mixin\insert('region', array('id' => 33, 'province_id' => 3, 'name' => "Каганский район"));
        Mixin\insert('region', array('id' => 34, 'province_id' => 3, 'name' => "Каракульский район"));
        Mixin\insert('region', array('id' => 35, 'province_id' => 3, 'name' => "Караулбазарский район"));
        Mixin\insert('region', array('id' => 36, 'province_id' => 3, 'name' => "Пешкунский район"));
        Mixin\insert('region', array('id' => 37, 'province_id' => 3, 'name' => "Ромитанский район"));
        Mixin\insert('region', array('id' => 38, 'province_id' => 3, 'name' => "Шафирканский район"));
        Mixin\insert('region', array('id' => 39, 'province_id' => 3, 'name' => "Вабкентский район"));
        Mixin\insert('region', array('id' => 40, 'province_id' => 4, 'name' => "Алтыарыкский район"));
        Mixin\insert('region', array('id' => 41, 'province_id' => 4, 'name' => "Багдатский район"));
        Mixin\insert('region', array('id' => 42, 'province_id' => 4, 'name' => "Бешарыкский район"));
        Mixin\insert('region', array('id' => 43, 'province_id' => 4, 'name' => "Кокандский район"));
        Mixin\insert('region', array('id' => 44, 'province_id' => 4, 'name' => "Кувинский район"));
        Mixin\insert('region', array('id' => 45, 'province_id' => 4, 'name' => "Кудашский район"));
        Mixin\insert('region', array('id' => 46, 'province_id' => 4, 'name' => "Маргеланский район"));
        Mixin\insert('region', array('id' => 47, 'province_id' => 4, 'name' => "Риштанский район"));
        Mixin\insert('region', array('id' => 48, 'province_id' => 4, 'name' => "Ферганский район"));
        Mixin\insert('region', array('id' => 49, 'province_id' => 5, 'name' => "Арнасайский район"));
        Mixin\insert('region', array('id' => 50, 'province_id' => 5, 'name' => "Бахмальский район"));
        Mixin\insert('region', array('id' => 51, 'province_id' => 5, 'name' => "Дустликский район"));
        Mixin\insert('region', array('id' => 52, 'province_id' => 5, 'name' => "Фаришский район"));
        Mixin\insert('region', array('id' => 53, 'province_id' => 5, 'name' => "Галляаральский район"));
        Mixin\insert('region', array('id' => 54, 'province_id' => 5, 'name' => "Шараф-Рашидовский район"));
        Mixin\insert('region', array('id' => 55, 'province_id' => 5, 'name' => "Мирзачульский район"));
        Mixin\insert('region', array('id' => 56, 'province_id' => 5, 'name' => "Пахтакорский район"));
        Mixin\insert('region', array('id' => 57, 'province_id' => 5, 'name' => "Янгиабадский район"));
        Mixin\insert('region', array('id' => 58, 'province_id' => 5, 'name' => "Зааминский район"));
        Mixin\insert('region', array('id' => 59, 'province_id' => 5, 'name' => "Зафарабадский район"));
        Mixin\insert('region', array('id' => 60, 'province_id' => 5, 'name' => "Зарбдарский район"));
        Mixin\insert('region', array('id' => 61, 'province_id' => 6, 'name' => "Касансайский район"));
        Mixin\insert('region', array('id' => 62, 'province_id' => 6, 'name' => "Мингбулакский район"));
        Mixin\insert('region', array('id' => 63, 'province_id' => 6, 'name' => "Наманганский район"));
        Mixin\insert('region', array('id' => 64, 'province_id' => 6, 'name' => "Нарынский район"));
        Mixin\insert('region', array('id' => 65, 'province_id' => 6, 'name' => "Папский район"));
        Mixin\insert('region', array('id' => 66, 'province_id' => 6, 'name' => "Туракурганский район"));
        Mixin\insert('region', array('id' => 67, 'province_id' => 6, 'name' => "Уйчинский район"));
        Mixin\insert('region', array('id' => 68, 'province_id' => 6, 'name' => "Учкурганский район"));
        Mixin\insert('region', array('id' => 69, 'province_id' => 6, 'name' => "Чартакский район"));
        Mixin\insert('region', array('id' => 70, 'province_id' => 6, 'name' => "Чустский район"));
        Mixin\insert('region', array('id' => 71, 'province_id' => 6, 'name' => "Янгикурганский район"));
        Mixin\insert('region', array('id' => 72, 'province_id' => 7, 'name' => "Канимехский район"));
        Mixin\insert('region', array('id' => 73, 'province_id' => 7, 'name' => "Карманинский район"));
        Mixin\insert('region', array('id' => 74, 'province_id' => 7, 'name' => "Кызылтепинский район"));
        Mixin\insert('region', array('id' => 75, 'province_id' => 7, 'name' => "Хатырчинский район"));
        Mixin\insert('region', array('id' => 76, 'province_id' => 7, 'name' => "Навбахорский район"));
        Mixin\insert('region', array('id' => 77, 'province_id' => 7, 'name' => "Нуратинский район"));
        Mixin\insert('region', array('id' => 78, 'province_id' => 7, 'name' => "Тамдынский район"));
        Mixin\insert('region', array('id' => 79, 'province_id' => 7, 'name' => "Учкудукский район"));
        Mixin\insert('region', array('id' => 80, 'province_id' => 8, 'name' => "Чиракчинский район"));
        Mixin\insert('region', array('id' => 81, 'province_id' => 8, 'name' => "Дехканабадский район"));
        Mixin\insert('region', array('id' => 82, 'province_id' => 8, 'name' => "Гузарский район"));
        Mixin\insert('region', array('id' => 83, 'province_id' => 8, 'name' => "Камашинский район"));
        Mixin\insert('region', array('id' => 84, 'province_id' => 8, 'name' => "Каршинский район"));
        Mixin\insert('region', array('id' => 85, 'province_id' => 8, 'name' => "Касанский район"));
        Mixin\insert('region', array('id' => 86, 'province_id' => 8, 'name' => "Касбийский район"));
        Mixin\insert('region', array('id' => 87, 'province_id' => 8, 'name' => "Китабский район"));
        Mixin\insert('region', array('id' => 88, 'province_id' => 8, 'name' => "Миришкорский район"));
        Mixin\insert('region', array('id' => 89, 'province_id' => 8, 'name' => "Мубарекский район"));
        Mixin\insert('region', array('id' => 90, 'province_id' => 8, 'name' => "Нишанский район"));
        Mixin\insert('region', array('id' => 91, 'province_id' => 8, 'name' => "Шахрисабзский район"));
        Mixin\insert('region', array('id' => 92, 'province_id' => 8, 'name' => "Яккабагский район"));
        Mixin\insert('region', array('id' => 93, 'province_id' => 9, 'name' => "Булунгурский район"));
        Mixin\insert('region', array('id' => 94, 'province_id' => 9, 'name' => "Иштыханский район"));
        Mixin\insert('region', array('id' => 95, 'province_id' => 9, 'name' => "Джамбайский район"));
        Mixin\insert('region', array('id' => 96, 'province_id' => 9, 'name' => "Каттакурганский район"));
        Mixin\insert('region', array('id' => 97, 'province_id' => 9, 'name' => "Кошрабадский район"));
        Mixin\insert('region', array('id' => 98, 'province_id' => 9, 'name' => "Нарпайский район"));
        Mixin\insert('region', array('id' => 99, 'province_id' => 9, 'name' => "Нурабадский район"));
        Mixin\insert('region', array('id' => 100, 'province_id' => 9, 'name' => "Акдарьинский район"));
        Mixin\insert('region', array('id' => 101, 'province_id' => 9, 'name' => "Пахтачийский район"));
        Mixin\insert('region', array('id' => 102, 'province_id' => 9, 'name' => "Пайарыкский район"));
        Mixin\insert('region', array('id' => 103, 'province_id' => 9, 'name' => "Пастдаргомский район"));
        Mixin\insert('region', array('id' => 104, 'province_id' => 9, 'name' => "Самаркандский район"));
        Mixin\insert('region', array('id' => 105, 'province_id' => 9, 'name' => "Тайлакский район"));
        Mixin\insert('region', array('id' => 106, 'province_id' => 9, 'name' => "Ургутский район"));
        Mixin\insert('region', array('id' => 107, 'province_id' => 10, 'name' => "Акалтынский район"));
        Mixin\insert('region', array('id' => 108, 'province_id' => 10, 'name' => "Баяутский район"));
        Mixin\insert('region', array('id' => 109, 'province_id' => 10, 'name' => "Гулистанский район"));
        Mixin\insert('region', array('id' => 110, 'province_id' => 10, 'name' => "Хавастский район"));
        Mixin\insert('region', array('id' => 111, 'province_id' => 10, 'name' => "Мирзаабадский район"));
        Mixin\insert('region', array('id' => 112, 'province_id' => 10, 'name' => "Сардобинский район"));
        Mixin\insert('region', array('id' => 113, 'province_id' => 10, 'name' => "Сайхунабадский район"));
        Mixin\insert('region', array('id' => 114, 'province_id' => 10, 'name' => "Сырдарьинский район"));
        Mixin\insert('region', array('id' => 115, 'province_id' => 10, 'name' => "Алтынсайский район"));
        Mixin\insert('region', array('id' => 116, 'province_id' => 11, 'name' => "Ангорский район"));
        Mixin\insert('region', array('id' => 117, 'province_id' => 11, 'name' => "Байсунский район"));
        Mixin\insert('region', array('id' => 118, 'province_id' => 11, 'name' => "Бандыханский район"));
        Mixin\insert('region', array('id' => 119, 'province_id' => 11, 'name' => "Денауский район"));
        Mixin\insert('region', array('id' => 120, 'province_id' => 11, 'name' => "Джаркурганский район"));
        Mixin\insert('region', array('id' => 121, 'province_id' => 11, 'name' => "Кизирикский район"));
        Mixin\insert('region', array('id' => 122, 'province_id' => 11, 'name' => "Кумкурганский район"));
        Mixin\insert('region', array('id' => 123, 'province_id' => 11, 'name' => "Музрабадский район"));
        Mixin\insert('region', array('id' => 124, 'province_id' => 11, 'name' => "Сариасийский район"));
        Mixin\insert('region', array('id' => 125, 'province_id' => 11, 'name' => "Термезский район"));
        Mixin\insert('region', array('id' => 126, 'province_id' => 11, 'name' => "Узунский район"));
        Mixin\insert('region', array('id' => 127, 'province_id' => 11, 'name' => "Шерабадский район"));
        Mixin\insert('region', array('id' => 128, 'province_id' => 11, 'name' => "Шурчинский район"));
        Mixin\insert('region', array('id' => 129, 'province_id' => 12, 'name' => "Багатский район"));
        Mixin\insert('region', array('id' => 130, 'province_id' => 12, 'name' => "Гурленский район"));
        Mixin\insert('region', array('id' => 131, 'province_id' => 12, 'name' => "Кошкупырский район"));
        Mixin\insert('region', array('id' => 132, 'province_id' => 12, 'name' => "Ургенчский район"));
        Mixin\insert('region', array('id' => 133, 'province_id' => 12, 'name' => "Хазараспский район"));
        Mixin\insert('region', array('id' => 134, 'province_id' => 12, 'name' => "Ханкинский район"));
        Mixin\insert('region', array('id' => 135, 'province_id' => 12, 'name' => "Хивинский район"));
        Mixin\insert('region', array('id' => 136, 'province_id' => 12, 'name' => "Шаватский район"));
        Mixin\insert('region', array('id' => 137, 'province_id' => 12, 'name' => "Янгиарыкский район"));
        Mixin\insert('region', array('id' => 138, 'province_id' => 12, 'name' => "Янгибазарский район"));
        Mixin\insert('region', array('id' => 139, 'province_id' => 12, 'name' => "Тупраккалинский район"));
        Mixin\insert('region', array('id' => 140, 'province_id' => 13, 'name' => "г. Нукус"));
        Mixin\insert('region', array('id' => 141, 'province_id' => 13, 'name' => "Амударьинский район"));
        Mixin\insert('region', array('id' => 142, 'province_id' => 13, 'name' => "Берунийский район"));
        Mixin\insert('region', array('id' => 143, 'province_id' => 13, 'name' => "Бозатауский район"));
        Mixin\insert('region', array('id' => 144, 'province_id' => 13, 'name' => "Канлыкульский район"));
        Mixin\insert('region', array('id' => 145, 'province_id' => 13, 'name' => "Караузякский район"));
        Mixin\insert('region', array('id' => 146, 'province_id' => 13, 'name' => "Кегейлинский район"));
        Mixin\insert('region', array('id' => 147, 'province_id' => 13, 'name' => "Кунградский район"));
        Mixin\insert('region', array('id' => 148, 'province_id' => 13, 'name' => "Муйнакский район"));
        Mixin\insert('region', array('id' => 149, 'province_id' => 13, 'name' => "Нукусский район"));
        Mixin\insert('region', array('id' => 150, 'province_id' => 13, 'name' => "Тахиаташский район"));
        Mixin\insert('region', array('id' => 151, 'province_id' => 13, 'name' => "Тахтакупырский район"));
        Mixin\insert('region', array('id' => 152, 'province_id' => 13, 'name' => "Турткульский район"));
        Mixin\insert('region', array('id' => 153, 'province_id' => 13, 'name' => "Ходжейлинский район"));
        Mixin\insert('region', array('id' => 154, 'province_id' => 13, 'name' => "Чимбайский район"));
        Mixin\insert('region', array('id' => 155, 'province_id' => 13, 'name' => "Шуманайский район"));
        Mixin\insert('region', array('id' => 156, 'province_id' => 13, 'name' => "Элликкалинский район"));
        Mixin\insert('region', array('id' => 157, 'province_id' => 3, 'name' => "Город Бухара"));
        $db->commit();
        return 200;
    } catch (Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }
}

?>
