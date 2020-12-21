<html>
<head>
<meta charset="utf-8">
<style>
<?php echo file_get_contents("style3.css"); ?>
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
	session_start();
	$id_worker = $_SESSION['id_worker'];
	$fio = $_SESSION['fio_worker'];
	$today = date('Y-m-d');
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
	$select = "select id_relationship, name, pl.id_place, address, fio_ceo from relationship r, platform pl, attraction a  
		where pl.id_place=r.id_place and a.id_attraction=r.id_attraction and id_relationship in 
		(select id_relationship from work join worker on worker.id_worker=work.id_worker where worker.id_worker=$id_worker group by id_relationship);";
	    $result = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
		$pl=mysqli_fetch_array($result);
		 echo "<form action='report_cashier.php' method='POST'>
	<br><textarea name='rep'>Дата отчета: $today




ФИО директора площадки: ".$pl['fio_ceo']."
ФИО работника: $fio
Адрес площадки: ".$pl['address']."
Название аттракциона: ".$pl['name']."
</textarea><br>
        <br><input type='submit' value='Создать отчет'><br> <hr> 
    </form>
	";
	$select ="select * from work where date_work=current_date and id_worker = $id_worker;";
	$result1 = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
	$r = mysqli_num_rows($result); 
	if(isset($_POST["edit"]) and isset($_POST["rep2"])){
		$select = "select work_report from work where id_work = " . $_POST["edit"] . ";";
		$result = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
		$ed = mysqli_fetch_array($result);
		$prev = file_get_contents($ed['work_report'],"r");
		if($prev != $_POST["rep2"]){
		$fp = fopen($ed['work_report'], "w+");
		file_put_contents($ed['work_report'],$_POST["rep2"]);
		header("Refresh: 0");
		}
	}
	else if(isset($_POST["work"])){
		$select = "select work_report from work where id_work = " . $_POST["work"] . ";";
		$result = mysqli_query($conn, $select) or die("Ошибка " . mysqli_error($conn));
		$del = mysqli_fetch_array($result);
		unlink($del['work_report']);
		$delete = "delete from work where id_work = " . $_POST["work"] . ";";
		$result = mysqli_query($conn, $delete) or die("Ошибка " . mysqli_error($conn));
		header("Refresh: 0");
		exit;
		
	}
	
	else if(isset($_POST["rep"])){
	
	$query =" select max(id_work)+1 as num from work;";
	$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn));
	$num = mysqli_fetch_array($result);
	$fp = fopen("report/".$num['num'].".txt", "w+");
	file_put_contents("report/".$num['num'].".txt",$_POST["rep"]);
	$insert = "insert into work(date_work, work_report, id_worker, id_relationship) 
	values ( current_date, 'report/".$num['num'].".txt', $id_worker, ".$pl['id_relationship'].");";
	$result = mysqli_query($conn, $insert) or die("Ошибка " . mysqli_error($conn));
	header("Refresh: 0");
	
}
	if(!empty($r)){
    for ($i = 0 ; $i < $r ; ++$i)
    {
		while($row=mysqli_fetch_array($result1)) {
	echo "<form id = 'edit' action='report_cashier.php' method='POST'><br><textarea name='rep2'>";
	$wr = $row['work_report'];
	echo file_get_contents("$wr","r");
	$id_work = $row['id_work'];
	echo "</textarea><input id = 'edit2' type='text' name='edit' value='$id_work'><input id = 'edit1' type='submit' value='Редактировать'></form>
	<form id = 'del' action='report_cashier.php' method='POST'><input id = 'del1' type='submit' value='Удалить'><input id = 'del2' type='text' name='work' value='$id_work'>
	</form>";
	
		}	
	}
	}
mysqli_close($conn);
}
else {header('Location: http://localhost//park/main.php');}
	
?>

</body>
</html>
