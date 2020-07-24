<?php
$db=mysqli_connect("localhost","root","harmonics40");
if(!$db) die("錯誤: 無法連接MYSQL伺服器!" . mysqli_connect_error());
mysqli_select_db($db,"eatwhat") or
	die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
$sql2="SELECT 店家編號,店家名稱 FROM store";
$rows=mysqli_query($db,$sql2);
$num=mysqli_num_rows($rows);
$sql3="SELECT * FROM type";
$rows3=mysqli_query($db,$sql3);
$num1=mysqli_num_rows($rows3);
	
if(isset($_POST["return"])){
	mysqli_close($db);
	header("Location: eatwhat.php");
}else if(isset($_POST["newpro"])){
	for($i=0;$i<$num;$i++){           //找出欲新增之店家編號
		$r=mysqli_fetch_row($rows);
		if($i==$_POST["sn"]){
			$sn=$r[0];
		}
	}
	$pn=$_POST["pn"];
	$pnm=$_POST["pnm"];
	$price=$_POST["price"];
			

	$sql="INSERT INTO `product` (`產品編號`, `產品名稱`, `單價`, `店家編號`)
	      VALUES ('" .$pn. "', '" .$pnm. "', '" .$price. "', '" .$sn. "')";
	mysqli_query($db,$sql);
	
	$selected=$_POST["langs"];
	$n=0;
	foreach($selected as $item){
		for($i=$n;$i<$num1;$i++){			
			$r=mysqli_fetch_row($rows3);
			if($i==$item){
				$sql4="INSERT INTO `protyp` (`產品編號`, `種類編號`) VALUES ('" .$pn. "', '" .$r[0]. "')";
				mysqli_query($db,$sql4);
				break;
			}
		}
		$n=$item+1;
	}	
	mysqli_close($db);
	header("Location: eatwhat_b.php");
}else if(isset($_POST["newst"])){
	$sn1=$_POST["sn1"];
	$snm=$_POST["snm"];
	$addr=$_POST["addr"];
	$phone=$_POST["phone"];
	$note=$_POST["note"];
	if($phone=="") $phone="無資料";
	if($addr=="") $addr="無資料";
	if($note=="") $note="無資料";
	$sql3="INSERT INTO `store` (`店家編號`, `店家名稱`, `店家電話`, `店家地址`, `備註`)
	       VALUES ('" .$sn1. "', '" .$snm. "', '" .$phone. "', '" .$addr. "', '" .$note. "')";
	mysqli_query($db,$sql3);
	mysqli_close($db);
	header("Location: eatwhat_b.php");
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
<form method="post" action="">
*店家編號
<input type="text" name="sn1"><p/>
*店家名稱
<input type="text" name="snm"><p/>
*店家地址
<input type="text" name="addr"><p/>
訂購電話
<input type="text" name="phone"><p/>
備註
<input type="text" name="note"><p/>
<input type="submit" name="newst" value="新增店家"></p>

*選擇店家
<select name="sn" id="sn">	
<?php
for($i=0;$i<$num;$i++){
	$row=mysqli_fetch_row($rows);?>
	<option value=" <?php echo $i; ?> "> <?php echo $row[1]; ?> </option>
<?php } ?>
</select><p>
*產品編號
<input type="text" name="pn"><p/>		
*產品名稱
<input type="text" name="pnm"><p/>	
*產品價格
<input type="text" name="price"><p/>
類別
<select name="langs[]" id="langs" multiple>
	<?php
	for($i=0;$i<$num1;$i++){
		$row3=mysqli_fetch_row($rows3); ?>
		<option value=" <?php echo $i; ?>"><?php echo $row3[1]; ?></option>
	<?php } echo $nnn;?>	
</select><p/>	
<input type="submit" name="newpro" value="新增菜單"></p>
<input type="submit" name="return" value="返回">
</form>
</center>
</body>
</html>