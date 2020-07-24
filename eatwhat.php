<?php
if(isset($_POST["look"])){
	header("Location: eatwhat_a.php");
}else if(isset($_POST["new"])){
	header("Location: eatwhat_b.php");
}else if(isset($_POST["eat"])){
	header("Location: eatwhat_e.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>EatWhat!?</title>
</head>
<body>
<center>
<h1>等一下吃甚麼?</h1>
<hr/>
<p>等一下吃甚麼?<p/>
<form method="post" action="">
<input type="submit" name="eat" value="我們去吃!?"></p>
<input type="submit" name="look" value="菜單查詢"></p>
<input type="submit" name="new" value="菜單新增">
</form>
</center>
</body>
</html>