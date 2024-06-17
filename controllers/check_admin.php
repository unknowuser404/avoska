<?php
	// Проверка
	include "check.php";
	// Условие
	if($_SESSION["role"] != "admin")
		return header("Location:../cart.php?message=Отказано в доступе");