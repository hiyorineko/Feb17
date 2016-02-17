<?php
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		if($_POST["pass"]=='hoge'){
			header("Location:main.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta chaset="utf8">
		<title>hoge部</title>
	</head>
	<body>
		<header>
			<h1>hoge部</h1>
		</header>
		<article>
			<form action="" method="post">
			<input type = "password" name = "pass" placeholder="パスワードを入力してください。"><br>
			<input type="submit" id ="login" value="ログイン"><br><br>
			</form>
		</article>
		<footer>
			作成日付:2016/02/17
		</footer>
	</body>
</html>