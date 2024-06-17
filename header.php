<?php
	// Меню сайта для разных пользователей
	$menu = '
		<li><a href="index.php"><button>Главная</button></a></li>
		<li><a href="catalog.php"><button>Каталог</button></a></li>
		<li><a href="where.php"><button>О нас</button></a></li>
		%s
	';

	$m = '';
	if(isset($_SESSION["role"])) {
		$m .= ($_SESSION["role"] == "admin") ? '<li><a href="admin"><button>Заказы</button></a></li>' : '';
		$m .= '<li><a href="profile.php"><button>Профиль</button></a></li>';
		$m .= '<li><a href="controllers/logout.php"><button>Выход</button></a></li>';
	} else
		$m = '
			<li><a href="index.php#login"><button>Вход</button></a></li>
			<li><a href="index.php#register"><button>Регистрация</button></a></li>
		';

	$menu = sprintf($menu, $m);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Авоська</title>
	<link rel="stylesheet" href="style.css">
	<script src="scripts/filter.js"></script>
	<script>
		let role = "<?= (isset($_SESSION["role"])) ? $_SESSION["role"] : "guest" ?>";
	</script>
</head>
<body>

	<header>
		<div class="top">
			<div class="row">
				<img src="logo/logo.png" alt="">
				<a href="index.php">
					<h1>Авоська</h1>
				</a>
			</div>
			<h2>Закажи товар со склада компании.</h2>
		</div>
		<div class="content">
			<ul>
				<?= $menu ?>
			</ul>
		</div>
	</header>

	<div class="message"><?= (isset($_GET["message"])) ? $_GET["message"] : ""; ?></div>