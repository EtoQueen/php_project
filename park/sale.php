<html>
<head>
<meta charset="utf-8">
  <style type="text/css">
   TD, TH {
    padding: 3px; /* Поля вокруг содержимого таблицы */
    border: 1px solid black; /* Параметры рамки */
	
   }
   table {
	 border-collapse: collapse;  
   }
   </style>
<title>
Продажа билетов  
</title>
</head>
<body>
    <form action="user.php" method="POST">
        <button class="" rel="stylesheet">Назад</button>
    </form>
<?php
if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){	
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
     session_start();
	 $id_worker = $_SESSION['id_worker'];
	 
$query ="select name, address, price_kids, price_adult, price_privilege, price.id_relationship from price, relationship r, platform pl, attraction a 
where price.id_relationship=r.id_relationship and pl.id_place=r.id_place and a.id_attraction=r.id_attraction and price.id_relationship in 
(select id_relationship from work join worker on worker.id_worker=work.id_worker where worker.id_worker=$id_worker group by id_relationship);";
 
$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn));
$result2 = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn));  

    $rows = mysqli_num_rows($result2); 
	$r=mysqli_fetch_array($result);
	$id_relationship = $r['id_relationship'];
	echo "<h2>Прайс лист</h2>
	<p>Адрес площадки: ". $r['address'] ."</p>
	<p>Название аттракциона: ". $r['name'] ."</p>";
	echo "<form action='' method='POST'>";
    echo "<table><tr>
	<th>Цена за детский билет</th><th>Цена за взрослый билет</th><th>Цена за льготный билет</th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        	while($r=mysqli_fetch_array($result2))
			{
				  echo "<tr>";
					echo "<td>" . $r['price_kids'] . "₽</td>";
					echo "<td>" . $r['price_adult'] . "₽</td>";
					echo "<td>" . $r['price_privilege'] . "₽</td>";
					echo "</tr>";
				}
		

    }
    echo "<tr>
	<th><input type='number' name='s1' placeholder='0' min='0'></th>
	<th><input type='number' name='s2' placeholder='0' min='0'></th>
	<th><input type='number' name='s3' placeholder='0' min='0'></th></tr>
	</table>";
	mysqli_free_result($result);
	echo "
	<br><input type='submit' value='Продать'>
	</form>";
if(isset($_POST["s1"]) and isset($_POST["s2"]) and isset($_POST["s3"])){
	$kids = $_POST["s1"];
	$adult = $_POST["s2"];
	$privilege = $_POST["s3"];
	if(empty($kids)){ 
	$kids = 0; 
	}
	if(empty($adult)){ 
	$adult = 0; 
	}
	if(empty($privilege)){ 
	$privilege = 0; 
	}
	$insert = "insert into operation (date, kids, adult, privilege, id_relationship) 
	value (CURRENT_DATE,$kids, $adult, $privilege, $id_relationship);";
    $result = mysqli_query($conn, $insert) or die("Ошибка: " . mysqli_error($conn));
	echo "Билеты успешно проданы :^)";
}


mysqli_close($conn);
}
else {header('Location: http://localhost//park/main.php');}
?>
</body>
</html>


