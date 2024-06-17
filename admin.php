<?php
	include "controllers/check_admin.php";
	// Подключение к базе
	include "connect.php";

	$sql = "SELECT * FROM `orders` INNER JOIN `users` USING(`user_id`)";
	$result = $connect->query($sql);
	$orders = "";
	while($row = $result->fetch_assoc()) {
		$adv = ($row["status"] == "Новый") ? '
			<form action="controllers/confirm_order.php" class="w100" method="POST">
				<input type="hidden" value="'.$row["order_id"].'" name="id" />
				<button>Подтвердить заказ</button>
			</form>
			<h3 class="text-center">Отменить заказ</h3>
			<form action="controllers/cancel_order.php" class="w100" method="POST">
				<input type="hidden" value="'.$row["order_id"].'" name="id" />
				<textarea placeholder="Причина отмены" name="reason" required></textarea>
				<button style="margin:0">Отменить заказ</button>
			</form>
		' : '';
		$adv = ($row["status"] == "Отменённый") ? '
			<h3 class="text-center">Причина отмены:</h3>
			<p class="reason">'.$row["reason"].'</p>
		' : $adv;
		$orders .= sprintf('
			<div class="col text-left">
				<h2>Заказ №%s</h2>
				<p>Заказчик: <b>%s %s %s</b></p>
				<p>Почта: %s</p>
				<p>Название: %s</p>
				<p>Статус заказа: <b>%s</b></p>
				<p>Количество товаров: <b>%s</b></p>
				<input type="hidden" value="%s" name="order_id" />
				%s
				<p class="text-small text-right">%s</p>
			</div>
		', $row["order_id"], $row["fio"], $row["surname"], $row["patronymic"], $row["email"], $row["product_id"], $row["status"], $row["count"], $row["order_id"], $adv, $row["created_at"]);
	}
	if(!$orders)
		$orders = '<h3 class="text-center">Заказы отсутствуют</h3>';

	include "header.php";
?>

	<main>
		<div class="content">
			<div class="head">Добавить товар</div>
			<form enctype="multipart/form-data" action="controllers/add_product.php" method="POST">
				<input type="text" placeholder="Название" name="name" required>
				<input type="number" placeholder="Цена" name="price" required>
				<input type="text" placeholder="Страна производитель" name="country" required>
				<input type="number" placeholder="Год выпуска" name="year" required>
				<input type="text" placeholder="Модель" name="model" required>
				<input type="number" placeholder="Количество на складе" name="count" required>
				<p class="text-left">Фотография товара</p>
				<input type="file" name="image" required>
				<button>Добавить</button>
			</form>

			<div class="head" style="margin-bottom: 10px">Заказы</div>
			<p style="margin-bottom: 20px">
				<span onclick="filter.filter('all', 'admin')">Все</span> |
				<span onclick="filter.filter('Новый', 'admin')">Новые</span> |
				<span onclick="filter.filter('Подтверждённый', 'admin')">Подтверждённые</span> |
				<span onclick="filter.filter('Отменённый', 'admin')">Отменённые</span> 
			</p>
			<div class="row at" id="orders">
				<?= $orders ?>
			</div>
		</div>
	</main>

	<script>filter.orders()</script>

<?php include "footer.php" ?>