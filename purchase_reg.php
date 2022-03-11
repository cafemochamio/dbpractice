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
	<title>買い物登録</title>
</head>
<body>
<?php
	//入力された値を取得
	$date = $_POST['date'];
	$code = $_POST['code'];
	$name = $_POST['name'];
	$count = $_POST['count'];
	$amount = $_POST['amount'];
	
	//問題があればエラーを表示して終了
	$errorMessage = '';
	if($date == '' || $name == '' || $count == '' || $amount == ''){
		$errorMessage = '入力されていない項目があります';
	}
	else if(!preg_match("/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/", $date)){
		$errorMessage = '日付の形式が正しくありません';
	}
	else if($code != '' && !is_numeric($code) || !is_numeric($count) || !is_numeric($amount)){
		$errorMessage = 'コード／単価／金額が数値ではありません';
	}
	if($errorMessage != ''){
		echo "<h1>入力エラー</h1>";
		echo "<p>$errorMessage</p>";
		echo "戻って入力内容を確認して下さい。\n";
		echo "</body></html>";
		exit(0);
	}
	
	//DBに接続
	$mysqli = new mysqli($dbserver, $dbuser, $passwd, $dbname);

	//連番の最大番号を取得するSQL文
	$stmt = $mysqli->prepare("select max(seqno) from purchase where id = ?");
	
	//パラメータをバインド
	$stmt->bind_param("s", $id);

	//SQL文を実行
	$stmt->execute();
	
	//結果をバインドして取得
	$stmt->bind_result($maxSeqno);
	$stmt->fetch();
	$stmt->close();

	//追加するレコードの seqnoを決定
	if($maxSeqno == ''){
		$seqno = 1; 
	}else{
		$seqno = $maxSeqno + 1;
	}
	
	//買い物レコードを追加するSQL文を準備(パラメタ部は「？」とする)
	$stmt = $mysqli->prepare("insert into purchase(id, seqno, date, code, name, count, amount) values(?,?,?,?,?,?,?)");

	//パラメータをバインド
	$stmt->bind_param("sisssii", $id, $seqno, $date, $code, $name, $count, $amount);

	//SQL文を実行
	$stmt->execute();

	//DB接続を切断
	$stmt->close();
	$mysqli->close();
?>
<h1>買い物情報登録完了</h1>
<p>買い物情報を登録しました</p>
<a href="menu.php">メニューページに戻る</a>
</body>
</html>
