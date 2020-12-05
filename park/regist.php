<html>
<head>
    <title>
        Регистрация
    </title>
	</head>
	<body>
	    <form action="user.php" method="POST">
        <button class="" rel="stylesheet">Назад</button>
    </form>
	<form action="" method="POST">
		<br>Логин: <input type="text" name="t1" maxlength="35" placeholder="Ivanov43"><br>
		<br>Пароль: <input type="password" name="t2" maxlength="21"><br>
        <br>Почта: <input type="email" name="t3" maxlength="35" placeholder="Ivanov@gmail.com"><br>
        <br>Телефон: <input type="phone" name="t4" maxlength="12" placeholder="+79216064053"> <br>
		<br><input type="submit" value="OK">
	</form>
	</body>
</html>

<?php 
	if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){	
if(isset($_POST["t1"]) and isset($_POST["t2"]) and isset($_POST["t3"]) and isset($_POST["t4"])){
    //$dbconn = mysqli_connect("localhost", "root", 12345, "park", 3303);
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
	if(!empty($_POST['t3'])){ 
	$p3 = "'".$_POST['t3']."'"; 
	}else{ 
	$p3 = "NULL"; 
	}
	if(!empty($_POST['t4'])){ 
	$p4 = "'".$_POST['t4']."'"; 
	}else{ 
	$p4 = "NULL"; 
	}
        $insert = "insert into park.users(password, login, mail, phone) value ('$_POST[t2]', '$_POST[t1]', ".$p3.", ".$p4.");";
        $result = mysqli_query($conn, $insert) or die("Ошибка: " . mysqli_error($conn));
		if(empty(mysqli_error($conn))) {
			echo "Поьзователь успешно создан.";
		}
}
}
else {header('Location: http://localhost//park/main.php');}
?>

