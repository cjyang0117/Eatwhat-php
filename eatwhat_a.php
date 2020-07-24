<?php
$db=mysqli_connect("localhost","root","harmonics40");
if(!$db) die("錯誤: 無法連接MYSQL伺服器!" . mysqli_connect_error());
mysqli_select_db($db,"eatwhat") or
	die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
$sql="SELECT * FROM store";			
$rows=mysqli_query($db,$sql);
$num=mysqli_num_rows($rows);

if(isset($_POST["return"])){
	header("Location: eatwhat.php");
}else if(isset($_POST["look"])){
	$n=$_POST["s"];
	$sql="SELECT * FROM store WHERE 店家名稱='" .$n. "'";			
	$rows=mysqli_query($db,$sql);
	$num=mysqli_num_rows($rows);
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
<center>
<h1>等一下吃甚麼?</h1>
<hr/>
<form method="post" action="">
店家查詢
<input type="text" name="s">
<input type="submit" name="look" value="搜"><p/>	
<table border="1" style="border:3px #FFD382 dashed;">
	<thead>
		<tr>
			<th>店家名稱</th>
			<th>店家電話</th>
			<th>店家地址</th>
			<th>備註</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	if($num>0){
		for($i=0;$i<$num;$i++){
			$row=mysqli_fetch_row($rows);
			echo "<tr>";
			echo "<td>";
			echo "<a href='eatwhat_a1.php?id=" .$row[0]. "'>".$row[1];
			echo "</a>";
			echo "</td>";			
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row[4]."</td>";
			echo "<td>";
			echo "<a href='eatwhat_c.php?id=" .$row[0]. "'>更改|";
			echo "<a href='eatwhat_d.php?id=" .$row[0]. "'>刪除";
			echo "</a>";
			echo "</td>";
			echo "</tr>";
		}
	}
	mysqli_free_result($rows);	
	?>
	</tbody>
</table>
<input type="submit" name="return" value="返回">
</form>
</center>
</body>
</html>	