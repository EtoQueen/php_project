<html>
<head>
<meta charset="utf-8">
<style>
<?php echo file_get_contents("style6.css"); ?>
</style>
<title>
Статистика   
</title>
</head>
<body>
    <form action="user.php" method="POST">
        <button class="back" rel="stylesheet">Назад</button>
    </form>
<?php
	if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){	
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
     
$query ="SELECT * from platform;";
 
$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn)); 

    $rows = mysqli_num_rows($result); 
    echo "<form action='' method='POST'>";
	 echo "<p>Выберите площадку:</p>";
    echo "<table><tr>
	<th>Адрес</th><th>ФИО директора</th><th></th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        	while($row=mysqli_fetch_array($result))
			{
				  echo "<tr>";
					echo "<td>" . $row['address'] . "</td>";
					echo "<td>" . $row['fio_ceo'] . "</td>";
					$id = $row['id_place'];
					echo "<td><input type='radio' name='check' value='$id' id='check'></td>";
					echo "</tr>";
				}
		

    }
    echo "</table><br>";
	mysqli_free_result($result);
	
	if(isset($_POST["check"])){
	$check = $_POST["check"];
	session_start();
	$_SESSION['check'] = $check;
	$query2 ="select a.id_attraction, name 
	from attraction a join relationship r on r.id_attraction = a.id_attraction 
	join platform p on p.id_place = r.id_place 
	where p.id_place=$check;";
	$query4 ="SELECT address from platform where id_place=$check;";
	$result = mysqli_query($conn, $query4) or die("Ошибка " . mysqli_error($conn));
	while($r=mysqli_fetch_array($result))
			{
					echo "<br><p>" . $r['address'] . "</p>";
			}
	mysqli_free_result($result);	
	$result = mysqli_query($conn, $query2) or die("Ошибка " . mysqli_error($conn));
     echo "<table><tr>
	<th>ID</th><th>Название</th><th></th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        	while($row=mysqli_fetch_array($result))
			{
				  echo "<tr>";
					echo "<td>" . $row['id_attraction'] . "</td>";
					echo "<td>" . $row['name'] . "</td>";
					$id = $row['id_attraction'];
					echo "<td><input type='checkbox' name='array[]' value='$id'></td>";
					echo "</tr>";
				}
		

    }
    echo "</table>";

	echo "<p>Дата: <input class='date' type='date' name='date' min='2020-04-13'></p>";
} else if(isset($_POST["date"]) and isset($_POST["array"])){
			session_start();
			$check = $_SESSION['check'];
			$date = $_POST["date"];
			$el = implode(",", $_POST["array"]);
			$query3 ="select name, date, sum(adult) as adult, sum(kids) as kids, sum(privilege)as privilege
			from attraction a join relationship r on r.id_attraction = a.id_attraction 
			join platform p on p.id_place = r.id_place 
			join operation o on r.id_relationship = o.id_relationship 
			where p.id_place='$check' and date = '$date' and a.id_attraction in ($el) group by a.id_attraction;";
			$result1 = mysqli_query($conn, $query3) or die("Ошибка " . mysqli_error($conn));
			$rows = mysqli_num_rows($result1);
			$query4 ="SELECT address from platform where id_place=$check;";
			$result = mysqli_query($conn, $query4) or die("Ошибка " . mysqli_error($conn));
			while($r=mysqli_fetch_array($result))
			{
					echo " <br><p>" . $r['address'] . "</p>";
			}
			echo "<table><tr>
			<th>Название</th><th>Дата</th><th>Взрослые билеты</th><th>Детские билеты</th><th>Льготные билеты</th></tr>";
			for ($i = 0 ; $i < $rows ; ++$i){
        	while($row=mysqli_fetch_array($result1)){
				  echo "<tr>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['date'] . "</td>";
					echo "<td>" . $row['adult'] . "</td>";
					echo "<td>" . $row['kids'] . "</td>";
					echo "<td>" . $row['privilege'] . "</td>";
					echo "</tr>";
				}
		

			}
			echo "</table><br>";	
		} 
	echo "<input class='submit' type='submit' value='Выбрать'></form>";


mysqli_close($conn);
}
else {header('Location: http://localhost//park/main.php');}
?>
</body>
</html>
