<?php
if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){
    $conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
	session_start();
	$login = $_SESSION['login'];
	$select1 = "select position, id_worker, fio_worker from worker w join users u on u.id_user = w.id_user where login = '$login';";
	
	$re1 = mysqli_query($conn, $select1);
	$R1=mysqli_fetch_array($re1);
	$title=$R1["fio_worker"];
	echo "<html>
	<head>
	<title>$title</title>
	</head>
	<body>";
	if($R1["position"] == 'Кассир') { 
		echo " ";
	} elseif ($R1["position"] == 'Электрик') { 
		echo " ";
		} else {
			echo "
    <form action='regist.php' method='POST'>
        <button class='' rel='stylesheet'>Регистрация</button>
    </form>
	<form action='delete.php' method='POST'>
        <button class='' rel='stylesheet'>Удаление</button>
    </form>
	<form action='stat.php' method='POST'>
        <button class='' rel='stylesheet'>Статистика</button>
    </form>
	";
			}
	echo "
		<form action='edit.php' method='POST'>
			<button class='' rel='stylesheet'>Редактирование</button>
		</form>
		<form action='' method='POST'>
			<button class='' rel='stylesheet' name='exit'>Выход</button>
		</form>
	</body>
</html>";

	if(isset($_POST["exit"])){
		setcookie("login", $login, time()-3600, "","localhost");
		setcookie("pass", $password, time()-3600, "", "localhost");
		header('Location: http://localhost//park/main.php');
	}
	/*while($R=mysqli_fetch_array($re1))
	{
	echo $R["id_worker"]."  ".$R["position"]."  ".$R["fio_worker"]."<br>"; 
	}*/
}
else {header('Location: http://localhost//park/main.php');}
?>

