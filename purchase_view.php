<?php
	require_once('db.inc');

	session_start();

	//ログインユーザ情報を取得
	$id = $_SESSION['id'];

	//ログインしていない場合はログインページに飛ばす
	if($id == ''){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: login.php");
		exit(0);
	}
?>
<html>
<head>
	<link rel="stylesheet" href="css/default.css" type="text/css">
	<title>買い物一覧</title>
</head>
<body>
<h1>買い物一覧</h1>
<table>
<tr><th>日付</th><th>合計金額</th></tr>
<?php
	//DBに接続
	$mysqli = new mysqli($dbserver, $dbuser, $passwd, $dbname);

	//連番の最大番号を取得するSQL文
	$stmt = $mysqli->prepare("select date, sum(amount) from purchase where id = ? group by date order by date");
	
	//パラメータをバインド
	$stmt->bind_param("s", $id);

	//SQL文を実行
	$stmt->execute();
	
	//結果をバインドして取得
	$stmt->bind_result($date, $amountSum);
	while($stmt->fetch()){
		echo "<tr><td>$date</td><td style='text-align:right'>\\$amountSum</td></tr>";
	}
	
	$stmt->close();
	$mysqli->close();
?>
</table>
<p>
	<a href="menu.php">戻る</a>
</p>
</body>
</html>
