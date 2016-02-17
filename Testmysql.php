<html>
	<head>
		<meta chaset="utf8">
		<title>将棋部</title>
	</head>
<table border="1">
<tr><th>名前</th><th>年齢</th></tr>
<?php
	$pdo = new PDO("mysql:dbname=members","root");
	$st = $pdo->query("select * from names");
	while($row = $st->fetch()){
		$name = htmlspecialchars($row['name']);
		$age = htmlspecialchars($row['age']);
		echo "<tr><td>$name</td><td>$age 歳</td><tr>";
	}
?>
</table>
</html>