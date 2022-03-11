<?php
	ini_set('display_errors', 1);
	require_once('db.inc');
?>
<html>
<head>
	<link rel="stylesheet" href="css/default.css" type="text/css">
	<title>ユーザ登録</title>
</head>
<body>
<?php
	//入力された値を取得
	$id = $_POST['id'];
	$password = $_POST['password'];
	$password_rep = $_POST['password_rep'];
	$name = $_POST['name'];
	$age = $_POST['age'];
	
	//問題があればエラーを表示して終了
	$errorMessage = '';
	if($id == '' || $password == '' || $name == '' || $age == ''){
		$errorMessage = '入力されていない項目があります';
	}
	else if($password != $password_rep){
		$errorMessage = 'パスワードが一致していません';
	}
	else if(!is_numeric($age)){
		$errorMessage = '年齢に数字以外が入力されています';
	}
	if($errorMessage != ''){
		echo "<h1>入力エラー</h1>";
		echo "<p>$errorMessage</p>";
		echo "戻って入力内容を確認して下さい。\n";
		echo "</body></html>";
		exit(0);
	}
	
	//パスワードをハッシュ化
	$passwordHash = crypt($password);

	//DBに接続
	$mysqli = new mysqli($dbserver, $dbuser, $passwd, $dbname);

	//SQL文を準備(パラメタ部は「？」とする)
	$stmt = $mysqli->prepare("insert into user(id, password, name, age) values(?,?,?,?)");

	//パラメータをバインド
	$stmt->bind_param("sssi", $id, $passwordHash, $name, $age);

	//SQL文を実行
	$stmt->execute();

	//DB接続を切断
	$stmt->close();
	$mysqli->close();
?>
<h1>ユーザ登録完了</h1>
<p>ユーザ登録が完了しました</p>
<a href="login.php">ログイン</a>してご利用下さい
</body>
</html>
