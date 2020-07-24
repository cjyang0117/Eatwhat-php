<?php
$db=mysqli_connect("localhost","root","harmonics40");
if(!$db) die("錯誤: 無法連接MYSQL伺服器!" . mysqli_connect_error());
mysqli_select_db($db,"eatwhat") or
	die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
$id=$_GET["id"];
$sql="SELECT * FROM store WHERE 店家編號='" .$id. "'";			
$rows=mysqli_query($db,$sql);
$row=mysqli_fetch_row($rows);
$sql2="SELECT * FROM product WHERE 產品編號='" .$id. "'";			
$rows2=mysqli_query($db,$sql2);
$row2=mysqli_fetch_row($rows2);

if(isset($_POST["send"])&&$row){
	$sql3="DELETE FROM store
	       WHERE 店家編號='" .$id. "'";
	if(!mysqli_query($db,$sql3)){
	
	}else{
		header("Location: eatwhat_a.php");
	}	
}else if(isset($_POST["send"])&&$row2){
	$sql4="DELETE FROM product
	       WHERE 產品編號='" .$id. "'";
	if(!mysqli_query($db,$sql4)){
	
	}else{
		header("Location: eatwhat_a1.php?id=".$row2[3]);
	}	
}
if(isset($_POST["return"])&&$row){
	header("Location: eatwhat_a.php");
}else if(isset($_POST["return"])&&$row2){
	header("Location: eatwhat_a1.php?id=".$row2[3]);
}	
mysqli_close($db);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>EatWhat!?</title>
</head>
<body>

<h1>等一下吃甚麼?</h1><hr/>
<h2>刪除紀錄</h2><hr/>
<?php
if(isset($row)){ ?>
<ul>
	<li>店家編號: <?php echo $row[0]; ?> </li>
	<li>店家名稱: <?php echo $row[1]; ?> </li>
	<li>店家電話: <?php echo $row[2]; ?> </li>
	<li>店家地址: <?php echo $row[3]; ?> </li>
	<li>備註: <?php echo $row[4]; ?> </li>
<ul><hr/>
<?php
}else if(isset($row2)){ ?>
<ul>
	<li>產品編號: <?php echo $row2[0]; ?> </li>
	<li>產品名稱: <?php echo $row2[1]; ?> </li>
	<li>單價: <?php echo $row2[2]; ?> </li>
<ul><hr/>	
<?php } ?>
<form method="post" action="">	
	<input type="submit" name="send" value="刪除紀錄"/>
	<input type="submit" name="return" value="返回"/>
</form>

</body>