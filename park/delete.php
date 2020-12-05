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
Удаление пользователя   
</title>
</head>
<body>
    <form action="user.php" method="POST">
        <button class="" rel="stylesheet">Назад</button>
    </form>
<?php
if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){	
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
     
$query ="SELECT id_user, position, fio_worker FROM worker";
 
$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn)); 

    $rows = mysqli_num_rows($result); 
    echo "<form action='' method='POST'>";
    echo "<table><tr>
	<th>Id</th><th>Должность</th><th>ФИО</th><th>Удалить</th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        	while($row=mysqli_fetch_array($result))
			{
				  echo "<tr>";
					echo "<td>" . $row['id_user'] . "</td>";
					echo "<td>" . $row['position'] . "</td>";
					echo "<td>" . $row['fio_worker'] . "</td>";
					$id = $row['id_user'];
					echo "<td><input type='checkbox' name='array[]' value='$id'></td>";
					echo "</tr>";
				}
		

    }
    echo "</table>";
	mysqli_free_result($result);

	echo "
	<br><input type='submit' value='Удалить'>
	</form>";

if(isset($_POST["array"])){
	foreach($_POST["array"] as $key=>$value)
    {
	$query2 ="delete from users where id_user in ($value);";
	$result = mysqli_query($conn, $query2) or die("Ошибка " . mysqli_error($conn));
    }
	header("Refresh: 0");
}

mysqli_close($conn);
}
else {header('Location: http://localhost//park/main.php');}
?>
</body>
</html>


