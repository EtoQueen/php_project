<?php
if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){
    $conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
	session_start();
	$login = $_SESSION['login'];
	$select1 = "select position, id_worker, fio_worker from worker w join users u on u.id_user = w.id_user where login = '$login';";
	
	
	$re1 = mysqli_query($conn, $select1);
	$R1=mysqli_fetch_array($re1);
	$title=$R1["fio_worker"];
	$_SESSION['id_worker'] = $R1["id_worker"];
	$_SESSION['fio_worker'] = $R1["fio_worker"];
	echo "<html>
	<head>
	<title>$title</title>
	</head>
	<body>";
	if($R1["position"] == 'Кассир') { 
		echo " 
	<form action='sale.php' method='POST' id='sale'>
        <button class='sale' rel='stylesheet'>Продать билет</button>
    </form>
	<form action='report_cashier.php' method='POST' id='report_cashier'>
        <button class='report_cashier' rel='stylesheet'>Оставить отчет</button>
    </form>
	";
	} elseif ($R1["position"] == 'Электрик') { 
		echo "
	<form action='report.php' method='POST' id='report'>
        <button class='report' rel='stylesheet'>Оставить отчет</button>
    </form>";
		} else {
			echo "
    <form action='regist.php' method='POST'>
	<div id='regist'>
        <button class='regist' rel='stylesheet'>Регистрация</button>
		<p>Регистрация новых сотрудников</p>
	</div>
    </form>
	<form action='delete.php' method='POST'>
	<div id='delete'>
        <button class='delete' rel='stylesheet'>Удаление</button>
		<p>Удаление сотрудников</p>
	</div>
    </form>
	<form action='stat.php' method='POST'>
	<div id='stat'>
        <button class='stat' rel='stylesheet'>Статистика</button>
		<p>Статистика продаж билетов на аттракционе определенной площадки</p>
	</div>
    </form>
	<form action='reporting.php' method='POST'>
	<div id='reporting'>
        <button class='reporting' rel='stylesheet'>Отчеты</button>
		<p>Отчеты сотрудников о работе</p>
	</div>
    </form>
	";
			}
	echo "
		<form action='edit.php' method='POST'>
		<div id='edit'>
			<button class='edit' rel='stylesheet'>Редактирование</button> <p>Редактирование собственных данных</p>
			</div>
		</form>
		
		<form action='' method='POST'>
		<div id='exit'>
			<button class='exit' rel='stylesheet' name='exit'>Выход</button> 
			<p>Выход из учетной записи, возвращение на главную страницу</p>
			</div>
		</form>
	</body>
</html>";

	if(isset($_POST["exit"])){
		setcookie("login", $login, time()-5400, "","localhost");
		setcookie("pass", $password, time()-5400, "", "localhost");
		header('Location: http://localhost//park/main.php');
	}
	/*while($R=mysqli_fetch_array($re1))
	{
	echo $R["id_worker"]."  ".$R["position"]."  ".$R["fio_worker"]."<br>"; 
	}*/
}
else {header('Location: http://localhost//park/main.php');}
?>
<style>
<?php echo file_get_contents('style2.css'); ?>
</style>
