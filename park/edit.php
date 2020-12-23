<html>
<head>
<meta charset="utf-8">
<title>
Редактирование   
</title>
<style>
<?php echo file_get_contents('style4.css'); ?>
</style>
</head>
<body>
    <form action="user.php" method="POST">
        <button class="" rel="stylesheet">Назад</button>
    </form>
<?php
	if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){	
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
	session_start();
	$login = $_SESSION['login'];
	$query ="select fio_worker, mail, phone  from worker w join users u on u.id_user = w.id_user where login = '$login';";
 
	$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn)); 

    echo "<form action='' method='POST'>";

	while($R=mysqli_fetch_array($result))
	{
	echo "<p>".$R["fio_worker"]."<br>  Электронная почта: ".$R["mail"]."<br>  Номер телефона: ".$R["phone"]."</p>"; 
	}
	mysqli_free_result($result);
	echo "
	<p>Новая почта: <input type='email' name='e1' maxlength='35' placeholder='Ivanov@gmail.com'></p>
        <p>Новый телефон: <input type='phone' name='e2' maxlength='12' placeholder='+79216064053'> </p>
	<input type='submit' value='Отредактировать' id='id_edit'>
	</form>";

if(isset($_POST["e1"]) and isset($_POST["e2"])){
	$email=$_POST["e1"];
	$phone=$_POST["e2"];
	echo "<p class ='error'>";
	if(!empty($email) and !empty($phone)){
		$query ="UPDATE users SET mail = '$email', phone = '$phone' WHERE login = '$login';";
		$result = mysqli_query($conn, $query) or die("<span>Ошибка:</span>Номер телефона или электронная почта уже заняты.");
		header("Refresh: 0");
	}
	else if (!empty($email) and empty($phone)){
		$query ="UPDATE users SET mail = '$email' WHERE login = '$login';";
		$result = mysqli_query($conn, $query) or die("<span>Ошибка:</span> Данная электронная почта уже занята.");
		header("Refresh: 0");
	}
	else if (empty($email) and !empty($phone)){
		$query ="UPDATE users SET phone = '$phone' WHERE login = '$login';";
		$result = mysqli_query($conn, $query) or die("<span>Ошибка:</span> Данный номер телефона уже занят.");
		header("Refresh: 0");
	}
	else if(empty($email) and empty($phone)){
		echo "Введите пожалуйста новые значения.";
	}
	echo "</p>";
}

mysqli_close($conn);
}
else {header('Location: http://localhost//park/main.php');}
?>
</body>
</html>


