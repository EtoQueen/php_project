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
	


<?php 
	if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){	
if(isset($_POST["t1"]) and isset($_POST["t2"]) and isset($_POST["t3"]) and isset($_POST["t4"]) and empty($_POST["position"])){
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
		session_start();
		$worker = $_POST["t1"];
		$_SESSION['worker'] = $worker;
			echo "<br>Поьзователь успешно создан.<br>
			<form action='' method='POST'>
		<br>ФИО: <input type='text' name='fio' maxlength='45' required><br>
		<br>Должность: <select name='position' required>
			<option value=''>Выбрать...</option>
			<option value='Кассир'>Кассир</option>
			<option value='Электрик'>Электрик</option>
			<option value='Супервайзер'>Супервайзер</option>
			</select><br>";
		}
}
		else if(isset($_POST["fio"]) and isset($_POST["position"])){
			$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
			session_start();
			$worker = $_SESSION['worker'];
			$fio = $_POST["fio"];
			$position = $_POST["position"];
			$select="select id_user from users where login = '$worker';";
			$result = mysqli_query($conn, $select) or die("Ошибка: " . mysqli_error($conn));
			$r=mysqli_fetch_array($result);
			$id_user=$r['id_user'];
			$insert2 = "insert into worker(position, fio_worker, id_user) value ('$position', '$fio', '$id_user');";
			$result = mysqli_query($conn, $insert2) or die("Ошибка: " . mysqli_error($conn));
			if(empty(mysqli_error($conn))){
				echo "<br>Работиник успешно создан.";
			}
		}
		

echo "<br><input type='submit' value='OK'></form>
	</body>
</html>";
}
else {header('Location: http://localhost//park/main.php');}
?>

