<?php
$db=mysqli_connect("localhost","root","harmonics40");
if(!$db) die("錯誤: 無法連接MYSQL伺服器!" . mysqli_connect_error());
mysqli_select_db($db,"eatwhat") or
	die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
$id=$_GET["id"];
$sql="SELECT * FROM store WHERE 店家編號='".$id."'";
$rows=mysqli_query($db,$sql);
$row=mysqli_fetch_row($rows);

$sql1="SELECT * FROM product WHERE 產品編號='".$id."'";
$rows1=mysqli_query($db,$sql1);
$row1=mysqli_fetch_row($rows1);

$sql5="SELECT 種類
	   FROM product as p,type as t,protyp as pt
	   WHERE p.產品編號=pt.產品編號 AND
			 t.種類編號=pt.種類編號 AND
			 p.產品編號='" .$id. "'";
$rows5=mysqli_query($db,$sql5);
$num5=mysqli_num_rows($rows5);

$sql6="SELECT * FROM type";
$rows6=mysqli_query($db,$sql6);
$num6=mysqli_num_rows($rows6);	
if(isset($_POST["send"])){
	$sn=$_POST["sn"];
	$snm=$_POST["snm"];
	$phone=$_POST["phone"];
	$addr=$_POST["addr"];
	$note=$_POST["note"];
	$sql3="UPDATE `store`
	       SET `店家編號` = '" .$sn. "', `店家名稱` = '" .$snm. "',
		       `店家電話` = '" .$phone. "', `店家地址` = '" .$addr. "', `備註` = '" .$note. "'
	       WHERE `store`.`店家編號` = '" .$id. "'";
	mysqli_query($db,$sql3);	   
	header("Location: eatwhat_a.php");
}else if(isset($_POST["send1"])){
	$pn=$_POST["pn"];
	$pnm=$_POST["pnm"];
	$price=$_POST["price"];

	$sql4="UPDATE `product`
	       SET `產品編號` = '" .$pn. "', `產品名稱` = '" .$pnm. "', `單價` = '" .$price. "'
		   WHERE `product`.`產品編號` = '" .$id. "'";
	mysqli_query($db,$sql4);

	if(isset($_POST["langs"])){
		$sql8="DELETE FROM protyp
	           WHERE 產品編號='" .$pn. "'";		
		mysqli_query($db,$sql8);
		$selected=$_POST["langs"];
		$n=0;
		foreach($selected as $item){
			for($i=$n;$i<$num6;$i++){			
				$r=mysqli_fetch_row($rows6);
				if($i==$item){
					$sql7="INSERT INTO `protyp` (`產品編號`, `種類編號`) VALUES ('" .$pn. "', '" .$r[0]. "')";
					mysqli_query($db,$sql7);
					break;
				}
			}
			$n=$item+1;
		}
	}	
	header("Location: eatwhat_a1.php?id=".$row1[3]);
}
mysqli_close($db);	
if(isset($_POST["return"])){
	header("Location: eatwhat_a.php");
}else if(isset($_POST["return1"])){
	header("Location: eatwhat_a1.php?id=".$row1[3]);
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
<?php
if(isset($row)){ ?>
	<form method="post" action="">
	*店家編號
	<input type="text" name="sn" id="sn" value="<?php echo $row[0]; ?>"></p>
	*店家名稱
	<input type="text" name="snm" id="snm" value="<?php echo $row[1]; ?>"></p>
	店家電話
	<input type="text" name="phone" id="phone" value="<?php echo $row[2]; ?>"></p>
	店家地址
	<input type="text" name="addr" id="addr" value="<?php echo $row[3]; ?>"></p>
	備註
	<input type="text" name="note" id="note" value="<?php echo $row[4]; ?>"></p>
	<input type="submit" name="send" value="更新紀錄">
	<input type="submit" name="return" value="返回">
	</form>
<?php	
}else if(isset($row1)){ ?>
	<form method="post" action="">
	*產品編號
	<input type="text" name="pn" id="pn" value="<?php echo $row1[0]; ?>"><p/>		
	*產品名稱
	<input type="text" name="pnm" id="pnm" value="<?php echo $row1[1]; ?>"><p/>	
	*產品價格
	<input type="text" name="price" id="price" value="<?php echo $row1[2]; ?>"><p/>
	<?php
	$s="";
	for($j=0;$j<$num5;$j++){
		$row5=mysqli_fetch_row($rows5);
		$s=$s.$row5[0]."、";
	} ?>
	類別:<?php echo substr($s,0,-3); ?><p/>
	<select name="langs[]" id="langs" multiple>
		<?php
		for($i=0;$i<$num6;$i++){
			$row6=mysqli_fetch_row($rows6); ?>
			<option value=" <?php echo $i; ?>"><?php echo $row6[1]; ?></option>
		<?php } ?>	
	</select><p/>	
	<input type="submit" name="send1" value="更新紀錄">
	<input type="submit" name="return1" value="返回">
	</form>
<?php } ?>

</form>
</center>
</body>
</html>