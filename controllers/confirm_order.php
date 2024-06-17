<?php
	include "check_admin.php";
	// Подключение к базе
	include "../connect.php";

	$connect->query("UPDATE `orders` SET `status`='Подтверждённый' WHERE `order_id`=".$_POST["id"]);
	return header("Location:../admin?message=Статус заказа изменёна на \"Подтверждённый\"");
