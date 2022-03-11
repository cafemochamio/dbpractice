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
	<script type="text/javascript" src="script/jkl-calendar.js" charset="Shift_JIS"></script>
	<script type="text/javascript">
    	var cal1 = new JKL.Calendar("caldiv","form1","date");
	</script>
	<title>買い物登録</title>
</head>
<body>
<h1>買い物登録</h1>
<form method="post" id="form1" action="purchase_reg.php">
<table>
<tr><th>購入日:</th><td><input type="text" name="date" size="12" onClick="cal1.write();" onChange="cal1.getFormValue(); cal1.hide();"><div id="caldiv"></div></td></tr>
<tr><th>コード:</th><td><input type="text" name="code" size="24"></td></tr>
<tr><th>商品名:</th><td><input type="text" name="name" size="24"></td></tr>
<tr><th>個数:</th><td><input type="text" name="count" size="3"></td></tr>
<tr><th>合計金額:</th><td>\<input type="text" name="amount" size="6"></td></tr>
</table>
<input type="submit" value="登録">
</form>
</body>
</html>
