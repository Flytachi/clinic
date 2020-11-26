<?php
    header("Content-Type: text/html; charset=utf-8");
?>
<?php
	//Start session
	session_start();

  $ini =  parse_ini_file("../../tools/functions/setting.ini", true);

	//Array to store validation errors
	$errmsg_arr = array();

	//Validation error flag
	$errflag = false;

	//Connect to mysql server
	$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($ini['DATABASE']['HOST'], $ini['DATABASE']['USER'], $ini['DATABASE']['PASS']));
	if(!$link) {
		die('Ошибка соединения с базой: ' . mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	//Select database
	$db = mysqli_select_db( $link, u723643070_apt);
	if(!$db) {
		die("Не могу выбрать базу");
	}

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $str);
	}

	//Sanitize the POST values
	$login = clean($_POST['username']);
	$password = clean($_POST['password']);

	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Неправильный логин';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Не правильный пароль';
		$errflag = true;
	}

	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	}

	//Create query
	$qry="SELECT * FROM user WHERE username='$login' AND password='$password'";
	$result=mysqli_query($GLOBALS["___mysqli_ston"], $qry);

	//Check whether the query was successful or not
	if($result) {
		if(mysqli_num_rows($result) > 0) {
			//Login Successful
			session_regenerate_id();
			$member = mysqli_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['name'];
			$_SESSION['SESS_LAST_NAME'] = $member['position'];
			//$_SESSION['SESS_PRO_PIC'] = $member['profImage'];

			session_write_close();
			//if ($_SESSION['SESS_LAST_NAME']= 'Cashier') {
//		header("location: main/sales_cashier.php");
	//}
			header("location: main/index.php");
			exit();
		}else {
			//Login failed
			header("location: index.php");
			exit();
		}
	}else {
		die("Ошибка запроса");
	}

?>
