<html>
<head>
<meta charset="utf-8">
<style>
<?php echo file_get_contents("style9.css"); ?>
.select-css { 
max-width: 30%; 
display:block;
margin-left:auto;
margin-right:auto;
}
</style>
<title>
Отчетность 
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
	$worker = $_SESSION['worker'];
	$position = $_SESSION['pos'];
				$select = "select id_worker, fio_worker, position from worker w join users u on w.id_user = u.id_user where login = '$worker';";
				$result1 = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
				$select = "select * from platform;";
				$result = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
				$w=mysqli_fetch_array($result1);
				echo "<p>ФИО работника: ". $w['fio_worker'] ."</p>
				<p>Должность работника: ". $w['position'] ."</p>";
				$res = mysqli_num_rows($result); 
				echo "
				<form action='' method='POST'>

				<p>Выберите адрес площадки, на которой он будет работать: </p><p><select name='platform' class='select-css'>
				<option value=''>Выбрать...</option>"; 
				for ($i = 0 ; $i < $res ; ++$i)
				{
					while($plat=mysqli_fetch_array($result))
						{ 
							echo "
							<option value=" . $plat['id_place'] . ">" . $plat['address'] . "</option>";}
				} echo "
				</select>";
				//$select2 = "select id_worker from worker w join users u on w.id_user = u.id_user where login = $worker;";
				//$result = mysqli_query($conn, $select2) or die("Ошибка " . mysqli_error($conn));
				//$id_w = mysqli_fetch_array($result2);
				//$insert = "insert into park.work(date_work, work_report, id_worker, id_relationship) 
				//value ('2020-01-01', 'first', ".$id_w["id_worker"].", ".$id_r["id_relationship"].");"; 
	if(isset($_POST["platform"]) and empty($_POST["attraction"])){
	
	$pl = $_POST["platform"];
	$_SESSION['pl'] = $pl;
	if($position == 'Электрик') {
	$select = "select * from relationship where id_place = $pl and id_attraction between 1 and 3;";
	$result = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
	$id_r = mysqli_fetch_array($result);
	$insert = "insert into park.work(date_work, work_report, id_worker, id_relationship) 
			value ('2020-01-01', 'first', ".$w["id_worker"].", ".$id_r["id_relationship"].");"; 
			$result = mysqli_query($conn, $insert) or die("Ошибка " . mysqli_error($conn));
			if(empty(mysqli_error($conn))){
				echo "<p>Работиник успешно записан.</p>";
			}
	}
	else {
		$select = "select name, a.id_attraction from attraction a join relationship r on a.id_attraction=r.id_attraction 
		where r.id_place = $pl;";
		$result = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
		$res = mysqli_num_rows($result); 
		echo "
	<form action='' method='POST'>
	<p>Выберите аттракцион, на котором он будет работать:</p>
	<select name='attraction' required class='select-css'>
			<option value=''>Выбрать...</option>
			"; for ($i = 0 ; $i < $res ; ++$i)
		{
		while($at=mysqli_fetch_array($result))
			{ 
				echo "
			<option value=" . $at['id_attraction'] . ">" . $at['name'] . "</option>";}
		} echo "
			</select>";	
	}
	}
	else if(isset($_POST["attraction"])) {
	$attr = $_POST["attraction"];
	$pl = $_SESSION['pl'];
	$select = "select * from relationship where id_place = $pl and id_attraction = $attr;";
	$result = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
	$id_r = mysqli_fetch_array($result);
	$insert = "insert into park.work(date_work, work_report, id_worker, id_relationship) value ('2020-01-01', 'first', ".$w["id_worker"].", ".$id_r["id_relationship"].");"; 
			$result = mysqli_query($conn, $insert) or die("Ошибка " . mysqli_error($conn));
			if(empty(mysqli_error($conn))){
				echo "<p>Работиник успешно записан.</p>";
			}
	}
	echo "</p><input class='submit' type='submit' value='OK'></form>";
mysqli_close($conn);
}
else {header('Location: http://localhost//park/main.php');}
	
?>

</body>
</html>
