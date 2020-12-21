<html>
<head>
<meta charset="utf-8">
<style>
<?php echo file_get_contents("style8.css"); ?>
</style>
<title>
Просмотр отчетов  
</title>
</head>
<body>
    <form action="user.php" method="POST">
        <button class="" rel="stylesheet">Назад</button>
    </form>
<?php
if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){	
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
     
$query ="SELECT id_user, position, fio_worker FROM worker where position !='Супервайзер';";
 
$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn)); 

    $rows = mysqli_num_rows($result); 
    echo "<form action='' method='POST'>";
    echo "<table><tr>
	<th>Id</th><th>Должность</th><th>ФИО</th><th></th></tr>";
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

	echo "<p>Дата: <input class='date' type='date' name='date' min='2020-01-12'></p>
	<br><input class='submit' type='submit' value='Посмотреть отчеты'>
	</form>";

if(isset($_POST["array"]) and isset($_POST["date"])){
	foreach($_POST["array"] as $key=>$value)
    {
	$date = $_POST["date"];
	$select ="select * from work where date_work='$date' and id_worker = $value;";
	$result = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
	$r = mysqli_num_rows($result); 
		if(!empty($r)){
    for ($i = 0 ; $i < $r ; ++$i)
    {
		while($row=mysqli_fetch_array($result)) {
	echo "<br><hr><br><textarea name='rep2' readonly>";
	$wr = $row['work_report'];
	echo file_get_contents("$wr","r");
	$id_work = $row['id_work'];
	echo "</textarea><br>";
		}	
	}
	}
    }
}

mysqli_close($conn);
}
else {header('Location: http://localhost//park/main.php');}
?>
</body>
</html>


