<html>
<head>
<meta charset="utf-8">
<title>
Редактирование   
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
	$login = $_SESSION['login'];
	$query ="select fio_worker, mail, phone  from worker w join users u on u.id_user = w.id_user where login = '$login';";
 
	$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn)); 

    echo "<form action='' method='POST'>";

	while($R=mysqli_fetch_array($result))
	{
	echo $R["fio_worker"]."<br>  Электронная почта: ".$R["mail"]."<br>  Номер телефона: ".$R["phone"]."<br>"; 
	}
	mysqli_free_result($result);
	echo "
	<br>Новая почта: <input type='email' name='t1' maxlength='35' placeholder='Ivanov@gmail.com'><br>
        <br>Новый телефон: <input type='phone' name='t2' maxlength='12' placeholder='+79216064053'> <br>
	<br><input type='submit' value='Отредактировать'>
	</form>";

if(isset($_POST["t1"]) and isset($_POST["t2"])){
	$email=$_POST["t1"];
	$phone=$_POST["t2"];
	if(!empty($email) and !empty($phone)){
		$query ="UPDATE users SET mail = '$email', phone = '$phone' WHERE login = '$login';";
		$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn));
		header("Refresh: 0");
	}
	else if (!empty($email) and empty($phone)){
		$query ="UPDATE users SET mail = '$email' WHERE login = '$login';";
		$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn));
		header("Refresh: 0");
	}
		else if (empty($email) and !empty($phone)){
		$query ="UPDATE users SET phone = '$phone' WHERE login = '$login';";
		$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn));
		header("Refresh: 0");
	}
	else if(empty($email) and empty($phone)){
		echo "Введите пожалуйста новые значения";
	}
}

mysqli_close($conn);
}
else {header('Location: http://localhost//park/main.php');}
?>
</body>
</html>


