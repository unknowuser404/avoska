<?php
	// Проверка авторизации
	include "check.php";

	// Подключение подключения к базе
	include "../connect.php";
	
	// Получение id пользователя
	$user_id = $_SESSION["user_id"];

	// Получение данных
	$product = trim($_POST["product"]);
	$count = trim($_POST["count"]);
	$adress = trim($_POST["adress"]);

	// Добавление данных в базу
	$sql = sprintf("INSERT INTO `orders`(`product_id`, `user_id`, `adress`, `count`, `status`) VALUES('%s', '%s', '%s', '%s', 'Новый')",
		$connect->real_escape_string($product),
		$user_id,
		$connect->real_escape_string($adress),
		$connect->real_escape_string($count),
	);
	// В случае ошибки исполнения запроса
	if(!$connect->query($sql)) die("Error: ". $connect->error);

	// В случае успеха
	return header("Location:../?message=Заказ создан");