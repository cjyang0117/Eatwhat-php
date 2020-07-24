<?php
$db=mysqli_connect("localhost","root","harmonics40");
if(!$db) die("錯誤: 無法連接MYSQL伺服器!" . mysqli_connect_error());
mysqli_select_db($db,"eatwhat") or
	die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
$sql="SELECT * FROM type";
$rows=mysqli_query($db,$sql);
$num=mysqli_num_rows($rows);	



$view1=true;
$view2=false;
$view3=false;
$view4=false;	
if(isset($_POST["cheap"])||isset($_POST["expense"])){	
	$j=0;	
	$view1=false;
	$view2=true;
	if(isset($_POST["cheap"])){
		$pu=150;
		$pd=0;
	}else{
		$pu=1000;
		$pd=150;
	}
}else if(isset($_POST["good"])){
	$view1=false;
	$view2=false;
	$view3=true;
	$j1=0;
	
	$pu=$_POST["pu"];
	$pd=$_POST["pd"];
	$typ=$_POST["typ"];
	$sql2="SELECT 產品名稱,pt.產品編號,pt.種類編號
		   FROM product as p,type as t,protyp as pt
		   WHERE pt.種類編號='" .$typ. "' AND
		         p.產品編號=pt.產品編號 AND
				 t.種類編號=pt.種類編號 AND
				 單價>'" .$pd. "' AND
				 單價<='" .$pu. "'";	  
	$rows2=mysqli_query($db,$sql2);
	$num2=mysqli_num_rows($rows2); 	
}else if(isset($_POST["bad"])){
	$j=$_POST["j"];
	$view1=false;
	$view2=true;

	$pu=$_POST["pu"];
	$pd=$_POST["pd"];	
}else if(isset($_POST["back"])){
	header("Location: eatwhat.php");
}else if(isset($_POST["good1"])){
	$view1=false;
	$view2=false;
	$view3=false;
	$view4=true;
	
	$pn=$_POST["r4"];
	$tn=$_POST["r5"];
	$sql3="SELECT 店家名稱,店家地址,店家電話,s.店家編號
	       FROM product as p,store as s
		   WHERE p.店家編號=s.店家編號 AND
		         產品編號='" .$pn. "'";
	$rows3=mysqli_query($db,$sql3);

	$sql4="SELECT 產品名稱
	       FROM product as p,protyp as pt,type as t
		   WHERE p.產品編號=pt.產品編號 AND
		         t.種類編號=pt.種類編號 AND
				 pt.產品編號='" .$pn. "' AND
				 pt.種類編號='" .$tn. "'";
	$rows4=mysqli_query($db,$sql4);			 
}else if(isset($_POST["bad1"])){	
	$j1=$_POST["j1"];
	$pu=$_POST["pu1"];
	$pd=$_POST["pd1"];
	if($j1!=3){
		$view1=false;
		$view2=false;
		$view3=true;
				
		$typ=$_POST["typ1"];
		$sql2="SELECT 產品名稱,pt.產品編號,pt.種類編號
			   FROM product as p,type as t,protyp as pt
			   WHERE pt.種類編號='" .$typ. "' AND
					 p.產品編號=pt.產品編號 AND
					 t.種類編號=pt.種類編號 AND
					 單價>'" .$pd. "' AND
					 單價<='" .$pu. "'";	  
		$rows2=mysqli_query($db,$sql2);
		$num2=mysqli_num_rows($rows2);	
		if($j1==1){
			$n2=$_POST["n3"];
			$n3=$_POST["n4"];
		}else if($j1==2){
			$n2=$_POST["n4"];
		}
	}else{
		$view1=false;
		$view2=true;
		$view3=false;
	}
}else if(isset($_POST["good2"])){
	$view1=false;
	$view2=false;
	$view3=false;
	$view4=true;
	
	$pn=$_POST["r41"];
	$tn=$_POST["r51"];
	$sql3="SELECT 店家名稱,店家地址,店家電話,s.店家編號
	       FROM product as p,store as s
		   WHERE p.店家編號=s.店家編號 AND
		         產品編號='" .$pn. "'";
	$rows3=mysqli_query($db,$sql3);

	$sql4="SELECT 產品名稱
	       FROM product as p,protyp as pt,type as t
		   WHERE p.產品編號=pt.產品編號 AND
		         t.種類編號=pt.種類編號 AND
				 pt.產品編號='" .$pn. "' AND
				 pt.種類編號='" .$tn. "'";
	$rows4=mysqli_query($db,$sql4);		
}else if(isset($_POST["bad2"])){
	$j1=$_POST["j2"];
	$num2=$_POST["num2"];
	$pu=$_POST["pu2"];
	$pd=$_POST["pd2"];	
	if($j1!=$num2){
		$view1=false;
		$view2=false;
		$view3=true;
		
		$typ=$_POST["typ2"];
		$sql2="SELECT 產品名稱,pt.產品編號,pt.種類編號
			   FROM product as p,type as t,protyp as pt
			   WHERE pt.種類編號='" .$typ. "' AND
					 p.產品編號=pt.產品編號 AND
					 t.種類編號=pt.種類編號 AND
					 單價>'" .$pd. "' AND
					 單價<='" .$pu. "'";	  
		$rows2=mysqli_query($db,$sql2);
		$num2=mysqli_num_rows($rows2);	
	}else{
		$view1=false;
		$view2=true;
		$view3=false;
	}	
}else if(isset($_POST["go"])){
	header("Location: eatwhat.php");
}else if(isset($_POST["menu"])){
	$sn=$_POST["sn"];
	header("Location: eatwhat_a1.php?id=".$sn);
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
<?php
if($view1){ ?>
	<table cellpadding="50" border="1">
	<td>你想吃便宜一點的還是貴一點的?</td>
	</table>
	<input type="submit" name="cheap" value="便宜點好了">
	<input type="submit" name="expense" value="貴一點的">
<?php
}else if($view2){	
	for($i=0;$i<$num;$i++){
		$row=mysqli_fetch_row($rows);
		$r[$i]=$row[1];
		$r2[$i]=$row[0];
	}
	do{	
		$n=rand(0,$num-1);
		$sql2="SELECT 產品名稱,pt.產品編號,pt.種類編號
			   FROM product as p,type as t,protyp as pt
			   WHERE pt.種類編號='" .$r2[$n]. "' AND
		             p.產品編號=pt.產品編號 AND
				     t.種類編號=pt.種類編號 AND
					 單價>'" .$pd. "' AND
					 單價<='" .$pu. "'";	  
		$rows2=mysqli_query($db,$sql2);
		$num2=mysqli_num_rows($rows2);
	}while($num2<1);
	/*$i=0; 測試重複
	for(;$i<$j;$i++){
		if($nn[$i]==$n) break;
	}
	if($i<$j) continue;
	$nn[$j]=$n; */
	$j++;
	if($j<9){	?>
		<table cellpadding="50" border="1">
		<td>你想吃「<?php echo $r[$n]; ?>」嗎?</td>
		</table>
		<input type="hidden" name="j" id="j" value="<?php echo $j; ?>">
		<input type="hidden" name="typ" id="typ" value="<?php echo $r2[$n]; ?>">
		<input type="hidden" name="pu" id="pu" value="<?php echo $pu; ?>">
		<input type="hidden" name="pd" id="pd" value="<?php echo $pd; ?>">
		<input type="submit" name="good" value="聽起來不錯~">
		<input type="submit" name="bad" value="不想欸~">			
	<?php	
	}else{ ?>
		<table cellpadding="50" border="1">
		<td>什麼都不吃!!你去吃土好了!!!</td>
		</table>
		<input type="submit" name="back" value="重新再來一次">		
	<?php } ?>	
		
	
<?php
}else if($view3){ 	
	for($i=0;$i<$num2;$i++){	
		$row2=mysqli_fetch_row($rows2);
		$r3[$i]=$row2[0];
		$r4[$i]=$row2[1];
		$r5[$i]=$row2[2];
	}	
	if($num2>3){
		if($j1==0){
			do{
				$n2=rand(0,$num2-1);  //找出不重複的三個數字
				$n3=rand(0,$num2-1);
				$n4=rand(0,$num2-1);
			}while($n2==$n3||$n3==$n4||$n2==$n4); ?>
			
			<input type="hidden" name="n3" id="n3" value="<?php echo $n3; ?>">
			<input type="hidden" name="n4" id="n4" value="<?php echo $n4; ?>">
		<?php
		}else if($j1==1){ ?>
			<input type="hidden" name="n4" id="n4" value="<?php echo $n3; ?>">
		<?php }
		$j1++; ?>
		<table cellpadding="50" border="1">
		<td>那你覺得「<?php echo $r3[$n2]; ?>」怎麼樣?</td>
		</table>		
		<input type="hidden" name="j1" id="j1" value="<?php echo $j1; ?>">
		<input type="hidden" name="typ1" id="typ1" value="<?php echo $typ; ?>">
		<input type="hidden" name="r4" id="r4" value="<?php echo $r4[$n2]; ?>">
		<input type="hidden" name="r5" id="r5" value="<?php echo $r5[$n2]; ?>">
		<input type="hidden" name="pu1" id="pu1" value="<?php echo $pu; ?>">
		<input type="hidden" name="pd1" id="pd1" value="<?php echo $pd; ?>">		
		<input type="submit" name="good1" value="就這麼決定了!">
		<input type="submit" name="bad1" value="再考慮別的吧">
	<?php
	}else{ ?>
		<table cellpadding="50" border="1">
		<td>那你覺得「<?php echo $r3[$j1]; ?>」怎麼樣?</td>
		</table>
		<input type="hidden" name="r41" id="r41" value="<?php echo $r4[$j1]; ?>">
		<input type="hidden" name="r51" id="r51" value="<?php echo $r5[$j1++]; ?>">		
		<input type="hidden" name="j2" id="j2" value="<?php echo $j1; ?>">		
		<input type="hidden" name="typ2" id="typ2" value="<?php echo $typ; ?>">
		<input type="hidden" name="num2" id="num2" value="<?php echo $num2; ?>">
		<input type="hidden" name="pu2" id="pu2" value="<?php echo $pu; ?>">
		<input type="hidden" name="pd2" id="pd2" value="<?php echo $pd; ?>">		
		<input type="submit" name="good2" value="就這麼決定了!">
		<input type="submit" name="bad2" value="再考慮別的吧">		
	<?php } ?>	
<?php
}else{
	$row3=mysqli_fetch_row($rows3);
    $row4=mysqli_fetch_row($rows4);	
	//echo $row3[0].$row3[1].$row4[0]; ?>
	<table cellpadding="50" border="1">
	<td>太棒了!!那我們一起去吃「<?php echo $row3[0]; ?>」的「<?php echo $row4[0]; ?>」吧~~! 他就位在「<?php echo $row3[1]; ?>」，訂購電話為「<?php echo $row3[2]; ?>」。</td>
	</table>
	<input type="submit" name="go" value="回主頁面">
	<input type="hidden" name="sn" id="sn" value="<?php echo $row3[3]; ?>">
	<input type="submit" name="menu" value="查看店家菜單">
<?php	
} 
mysqli_close($db);?>	
</form>
</center>
</body>
</html>	