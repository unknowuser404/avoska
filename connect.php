<?php
	// Файл для управления базой
	$connect = new mysqli("localhost", "root", "", "avoska");
	$connect->set_charset("utf8");

	if($connect->connect_error)
		die("Ошибка подключения: ". $connect->connect_error);
