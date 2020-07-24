<?php
$db=mysqli_connect("localhost","root","harmonics40");
if(!$db) die("錯誤: 無法連接MYSQL伺服器!" . mysqli_connect_error());
mysqli_select_db($db,"eatwhat") or
	die("錯誤: 無法選擇資料庫!" . mysqli_error($db));		
$id=$_GET["id"];	
$sql="SELECT 產品編號,產品名稱,單價
      FROM product
	  WHERE 店家編號='" .$id. "'";	  
$rows=mysqli_query($db,$sql);
$num=mysqli_num_rows($rows);
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
<form method="post" action="eatwhat_a.php">	
<table border="1" style="border:3px #FFD382 dashed;">
	<thead>
		<tr>
			<th>產品名稱</th>
			<th>單價</th>
			<th>類別</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	if($num>0){
		for($i=0;$i<$num;$i++){
			$row=mysqli_fetch_row($rows);
			echo "<tr>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			$sql1="SELECT 種類
				   FROM product as p,type as t,protyp as pt
				   WHERE p.產品編號=pt.產品編號 AND
						 t.種類編號=pt.種類編號 AND
						 p.產品編號='" .$row[0]. "'";
			$rows1=mysqli_query($db,$sql1);
			$num1=mysqli_num_rows($rows1);
			$s="";
			for($j=0;$j<$num1;$j++){
				$row1=mysqli_fetch_row($rows1);
				$s=$s.$row1[0]."、";
			}
			echo "<td>".substr($s,0,-3)."</td>";	
			echo "<td>";
			echo "<a href='eatwhat_c.php?id=" .$row[0]. "'>更改|";
			echo "<a href='eatwhat_d.php?id=" .$row[0]. "'>刪除";
			echo "</a>";
			echo "</td>";
			echo "</tr>";
		}
	}
	mysqli_free_result($rows);
	mysqli_close($db);	
	?>
	</tbody>
</table>
<input type="submit" name="return" value="返回">
</form>
</center>
</body>
</html>