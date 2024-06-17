<?php
	session_start();
	// Подключение подключения к базе
	include "connect.php";

	$sql = "SELECT * FROM `products` WHERE `count` > 0 ORDER BY `created_at` DESC LIMIT 5";
	if(!$result = $connect->query($sql))
		return die ("Ошибка получения данных: ". $connect->error);
	// Получение данных из результата запроса
	$data = "";
	while($row = $result->fetch_assoc())
		$data .= sprintf('
			<div class="slide col">
				<img src="%s" alt="" />
				<h3><a href="product.php?id=%s">%s</a></h3>
			</div>
		', $row["path"], $row["product_id"], $row["name"]);

	if($data == "")
		$data = '<h3 class="text-center">Товары отсутствуют</h3>';

	include "header.php";
?>

	<main>
		<div class="content">
			
			<div class="head">Новинки компании</div>

			<div id="slider">
				<div class="slides">
					<?= $data ?>
				</div>
			</div>

			<div class="head" id="register">Регистрация</div>
			<form action="controllers/register.php" method="POST">
				<input type="text" placeholder="ФИО" name="fio" pattern="[а-яА-ЯёЁ\s\-]+" required>
				<input type="text" placeholder="Логин" name="login" pattern="[a-zA-Z0-9\-]+" required>
				<input type="email" placeholder="Email" name="email" required>
				<input type="phone" name="phone" pattern=".{11,19}" placeholder="+7(XXX)-XXX-XX-XX" required>
				<input type="password" placeholder="Пароль" name="password" pattern=".{4,32}" required>
				<input type="password" placeholder="Повтор пароля" name="password_check" required>
				<div class="part">
					<input type="checkbox" name="rules" required>
					<p>Согласие с правилами регистрации</p>
				</div>
				<button>Зарегистрироваться</button>
			</form>

			<div class="head" id="login">Вход</div>
			<form action="controllers/login.php" method="POST">
				<input type="text" placeholder="Логин" name="login" required>
				<input type="password" placeholder="Пароль" name="password" required>
				<button>Войти</button>
			</form>

		</div>
	</main>

	<script src="scripts/slider.js"></script>

<?php include "footer.php" ?>