<?php
// Проверка авторизации пользователя
include "controllers/check.php";

// Подключение подключения к базе
include "connect.php";

// Получение id пользователя
$user_id = $_SESSION["user_id"];

// Запрос на получение запросов ползователя
$sql = sprintf("SELECT * FROM `orders`
                WHERE `user_id`='%s'", $user_id);
// Отправка запроса в базу
$result = $connect->query($sql);
// Проверка на наличие ошибок в исполнении запроса
if(!$result) die("Error: ". $connect->error);
// Получение данных из результата запроса
$app = "";
while($row = $result->fetch_assoc()) {
	$do = ($row["status"] == "Новая") ?
		sprintf('<p class="small"><a onclick="return window.confirm(\'Вы действительно хотите удалить заявку?\')" href="controllers/app_delete.php?app_id=%s">Удалить заявку</a></p>', $row["order_id"])
		: "";
	$refusal = ($row["status"] == "Отклонена") ? sprintf('<p class="center"><b>Причина отклонения:</b></p><p>%s</p>', $row["rejection_reason"]) : "";
	$app .= sprintf('
		<div class="col">
			<h2>Заказ №%s</h2>
			<p>Название: %s</p>
			<p>Статус заказа: <b>%s</b></p>
			<p>Количество товаров: <b>%s</b></p>
		</div>
	', $row["order_id"], $row["product_id"], $row["status"], $row["count"]);
}

// Запрос на получение категорий
$sql = "SELECT * FROM `products`";
$result = $connect->query($sql);
$categories = "";
while($row = $result->fetch_assoc())
	$categories .= sprintf('<option value="%s">%s</option>', $row["name"], $row["name"]);
// Подключение хедера
include "header.php";
?>

	<main>
		<div class="content">
			
			<div class="head">Ваши заказы</div>
			<!-- Вывод данных запросов -->
			<div class="row"><?= $app ?></div>

			<div class="head">Добавить заказ</div>
			<form action="controllers/add_order.php" enctype="multipart/form-data" method="POST">
                <select required name="product">
					<option value selected disabled>Товары</option>
					<!-- Вывод категорий -->
					<?= $categories  ?>
				</select>
				<input type="text" name="count" placeholder="Количество" required pattern=".{1,100}">
				<textarea name="adress" placeholder="Адрес" required pattern=".{1,256}"></textarea>
				<button>Создать заказ</button>
			</form>

		</div>
	</main>

</body>
</html>

<?php include "footer.php" ?>