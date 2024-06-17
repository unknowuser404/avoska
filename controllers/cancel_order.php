<?php
	// Проверка авторизации админа
	include "check_admin.php";
	// Подключение подключения к базе
	include "../connect.php";

	// Обновление
	$connect->query(sprintf("UPDATE `orders` SET `status`='Отменённый',`reason`='%s' WHERE `order_id`='%s'", $_POST["reason"], $_POST["id"]));

	// Возврат
	return header("Location:../admin?message=Статус заказа изменёна на \"Отменённый\"");
