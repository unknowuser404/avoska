<?php
	// Начало ссесии
	session_start();
	// Подключение к базе
	include "connect.php";

	$role = (isset($_SESSION["role"])) ? $_SESSION["role"] : "guest";



	$sql = "SELECT * FROM `products` WHERE `count` > 0 ORDER BY `created_at` DESC";
	if(!$result = $connect->query($sql))
		return die ("Ошибка получения данных: ". $connect->error);

	$data = "";
	while($row = $result->fetch_assoc())
		$data .= sprintf('
			<div class="col">
				<img src="%s" alt="">
				<div class="row">
					<h3><a href="product.php?id=%s">%s</a></h3>
					<p>%sр</p>
					<input type="hidden" value="%s" name="product_id">
					<input type="hidden" value="%s" name="year">
					<input type="hidden" value="%s" name="category">
				</div>
				%s
				%s
			</div>
		', $row["path"], $row["product_id"], $row["name"], $row["price"], $row["product_id"], $row["year"], $row["category"],
		($role == "admin") ? '
			<div class="row">
				<p><a href="update.php?id='.$row["product_id"].'" class="text-small">Редактировать</a></p>
				<p><a onclick="return confirm(\'Вы действительно хотите удалить этот товар?\')" href="controllers/delete_product.php?id='.$row["product_id"].'" class="text-small">Удалить</a></p>
			</div>
		' : '',
		($role != "guest") ? '<p class="text-right"><a href="controllers/add_cart.php?id='. $row["product_id"] .'" class="text-small"></a></p>' : '');

	if($data == "")
		$data = '<h3 class="text-center">Товары отсутствуют</h3>';

	include "header.php";
?>

	<main>
		<div class="content">

			<div class="head" style="margin-bottom: 10px">Наши товары</div>
			<div class="row" style="margin-bottom: 20px">
				<p>
					<span id="year" onclick="filter.filter('all')">Все</span> | 
					<span id="year" onclick="filter.filter('year', 'sort')">Год</span> | 
					<span id="name" onclick="filter.filter('name', 'sort')">Наименование</span> | 
					<span id="price" onclick="filter.filter('price', 'sort')">Цена</span>
				</p>
			</div>

			<div class="row" id="products">
				<?= $data ?>
			</div>

		</div>
	</main>

	<script>filter.products()</script>

<?php include "footer.php" ?>