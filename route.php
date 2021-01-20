<?php

	require_once 'tools/warframe.php';

	class Apps {
		function rout_test (){
			print 'test1';
		}

		function rout_lox (){

			$uploaddir = 'media/files/';
			$uploadfile = $uploaddir . basename($_FILES['filedata']['name']);

			var_dump($_FILES);

			if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
			    echo "Файл корректен и был успешно загружен.\n";
			} else {
			    echo "Возможная атака с помощью файловой загрузки!\n";
			}
		}

		function rout_index (){
			print 'Вывод типичной главной страницы';
		}
	}


	class Routing extends Apps { // Как вы видите, мы сразу наследуем класс Apps, который содержит нужные нам функции

		var $main_action = 'index'; // Функция, вызываемая по стандарту
		var $funcs_prefix = 'rout_'; // Префикс к функциям
		var $modules = 'modules'; // Название роута для объекта, в нашем случае модули

		function __construct (){http://clinic.loc/views/doctor/card/content_9.php?id=15

			$_SERVER['REQUEST_URI'] = strtok($_SERVER['REQUEST_URI'], "?");

			$this->routs = explode('/', $_SERVER['REQUEST_URI']); // Разделяем наш запрос

			var_dump($this->routs);

			if ($this->routs[1] == $this->modules OR !count($this->routs[1])) { // Если передаётся нужный нам объект либо вообще ничего

				$this->action = $this->routs[2];

				$this->action = ($this->action == NULL OR !count($this->action)) ? $this->main_action : $this->action;

				$this->get_routs();

			}

		}

		function get_routs(){

			$action = $this->funcs_prefix . $this->action;	// Получаем название функции
			if(method_exists($this, $action)) $this->$action(); // Если функция присутствует, то выполняем
			else die('Возникла ошибка, ваш запрос не верен!');

		}

	}

    $routing = new Routing;
