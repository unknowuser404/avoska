<?php
	// Проверка авторизации админа
	include "check_admin.php";
	// Подключение подключения к базе
	include "../connect.php";

	$path = "images/upload/1_". time() ."_". $_FILES["image"]["name"];
	move_uploaded_file($_FILES["image"]["tmp_name"], "../".$path);


	// Внисение данных
	$connect->query(sprintf("INSERT INTO `products`(`name`, `price`, `country`, `year`, `model`, `count`, `path`) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')", $_POST["name"], $_POST["price"], $_POST["country"], $_POST["year"], $_POST["model"], $_POST["count"], $path));

	// Возврат
	return header("Location:../admin?message=Товар добавлен");