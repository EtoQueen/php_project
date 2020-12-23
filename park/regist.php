<html>
<head>
    <title>
        Регистрация
    </title>
	<style>
		<?php echo file_get_contents("style9.css"); ?>
	</style>
	</head>
	<body>
	    <form action="user.php" method="POST">
        <button class="" rel="stylesheet">Назад</button>
    </form>
	<form action="" method="POST">
		<p>Логин: <input type="text" name="t1" maxlength="35" placeholder="Ivanov43"></p>
		<p>Пароль: <input type="password" name="t2" maxlength="21"></p>
        <p>Почта: <input type="email" name="t3" maxlength="35" placeholder="Ivanov@gmail.com"></p>
        <p>Телефон: <input type="phone" name="t4" maxlength="12" placeholder="+79216064053"> </p>
	


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
        $result = mysqli_query($conn, $insert) or die("<p><span>Ошибка:</span> " . mysqli_error($conn));
		if(empty(mysqli_error($conn))) {
		session_start();
		$worker = $_POST["t1"];
		$_SESSION['worker'] = $worker;
			echo "<p>Поьзователь успешно создан.</p>
			<form action='' method='POST'>
		<p>ФИО: <input type='text' name='fio' maxlength='45' required></p>
		<p>Должность: <select class='select-css' name='position' required>
			<option value=''>Выбрать...</option>
			<option value='Кассир'>Кассир</option>
			<option value='Электрик'>Электрик</option>
			<option value='Супервайзер'>Супервайзер</option>
			</select></p>";
		}
}
		else if(isset($_POST["fio"]) and isset($_POST["position"])){
			$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
			session_start();
			$worker = $_SESSION['worker'];
			$fio = $_POST["fio"];
			$position = $_POST["position"];
			$_SESSION['pos'] = $position;
			$select="select id_user from users where login = '$worker';";
			echo "<p>";
			$result = mysqli_query($conn, $select) or die("<span>Ошибка:</span> " . mysqli_error($conn));
			$r=mysqli_fetch_array($result);
			$id_user=$r['id_user'];
			$insert2 = "insert into worker(position, fio_worker, id_user) value ('$position', '$fio', '$id_user');";
			$result = mysqli_query($conn, $insert2) or die("<span>Ошибка:</span> " . mysqli_error($conn));
			if(empty(mysqli_error($conn))){
				if($position !== 'Супервайзер'){
				header('Location: http://localhost//park/distribution.php');
				}
				else {echo "Работиник успешно создан.</p>";}
			}
		}
		

echo "<br><input class='submit' type='submit' value='OK'></form>
	</body>
</html>";
}
else {header('Location: http://localhost//park/main.php');}
?>
