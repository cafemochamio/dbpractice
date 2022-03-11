<?php
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
	<title>処理メニュー</title>
</head>
<body>
<h1>処理メニュー</h1>
<ul>
	<li><a href="purchase_input.php">買い物登録</a></li>
	<li><a href="purchase_view.php">買い物履歴</a></li>
	<li><a href="logout.php">ログアウト</a></li>
</ul>
</body>
</html>
