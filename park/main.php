<html>
<head>
<meta charset="utf-8">
<title>Главная страница</title>
<style>
<?php echo file_get_contents("style1.css"); ?>
</style>
</head>
<body>
<div class ="center">
<h2>Здравствуйте пользователь, Вас приветствует сайт, посвященный обслуживанию парков аттракционов.</h2>
<p>Чтобы воспользоваться функционалом сайта, заполните форму авторизации и нажмите на кнопку ниже.</p>
<p>Если у вас еще нет данных для авторизации, обратитесь к администратору сайта любым удобным для Вас способом.</p>
<?php
	
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
	$query ="select fio_worker, mail, phone  from worker w join users u on u.id_user = w.id_user where position = 'Супервайзер';";
 
	$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn)); 

	while($R=mysqli_fetch_array($result))
	{
	echo "<span>Администратор: ".$R["fio_worker"]."<br>  Электронная почта: ".$R["mail"]."<br>  Номер телефона: ".$R["phone"]."</span>"; 
	}
	mysqli_free_result($result);
?>
	<form action="" method="POST" >
		<br>Логин: <input type="text" name="t1" maxlength="35" placeholder="Ivanov43"><br>
		<br>Пароль: <input type="password" name="t2" maxlength="21" id='pass' placeholder="***********"><br>
		<br><input type="submit" value="OK">
	</form>
<?php
 if(isset($_COOKIE["login"]) and isset($_COOKIE["pass"])){
	$login = $_COOKIE["login"];
	$password = $_COOKIE["pass"];
	$select = "select login, password from park.users WHERE login = '$login' and password = '$password';";
	$re = mysqli_query($conn, $select);
	$num_row= mysqli_num_rows($re);
	if($num_row != 0){
	header('Location: http://localhost//park/user.php');
	}
	mysqli_free_result($re);
}

 else if(isset($_POST["t1"]) and isset($_POST["t2"])){
	session_start();
	$login = $_POST["t1"];
	$password =$_POST["t2"];
    $select = "select login, password from park.users WHERE '$login' = login and '$password' = password;";
    $re = mysqli_query($conn, $select);
    $num_row= mysqli_num_rows($re);
    if($num_row != 0){
		$_SESSION['login'] = $login;
		setcookie("login", $login, time()+3600, "","localhost");
		setcookie("pass", $password, time()+3600, "", "localhost");
		header('Location: http://localhost//park/user.php');
		exit;
    }
    else{
        echo "<span id='er'>Логин или Пароль неправельные</span>";
    }
}
mysqli_close($conn);
?>
</div>
</body>
</html>


