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
<p class='intro'>Чтобы воспользоваться функционалом сайта, заполните форму авторизации и нажмите на кнопку ниже.</p>
<p class='intro'>Если у вас еще нет данных для авторизации, обратитесь к администратору сайта любым удобным для Вас способом.</p>
<?php
	
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
	$query ="select fio_worker, mail, phone  from worker w join users u on u.id_user = w.id_user where position = 'Супервайзер';";
 
	$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn)); 

	while($R=mysqli_fetch_array($result))
	{
	echo "<div class='info'><span><br>Администратор: ".$R["fio_worker"]."<br>  Электронная почта: ".$R["mail"]."<br>  Номер телефона: ".$R["phone"]."</span></div>"; 
	}
	mysqli_free_result($result);
?>
	<form action="" method="POST" >
		<p>Логин: <input type="text" name="m1" maxlength="35" placeholder="Ivanov43"></p>
		<p>Пароль: <input type="password" name="m2" maxlength="21" id='pass' placeholder="***********"></p>
		<input class='submit' type="submit" value="OK">
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

 else if(isset($_POST["m1"]) and isset($_POST["m2"])){
	session_start();
	$login = $_POST["m1"];
	$password =$_POST["m2"];
	if(!empty($login) and !empty($password)){
    $select = "select login, password from park.users WHERE '$login' = login and '$password' = password;";
    $re = mysqli_query($conn, $select);
    $num_row= mysqli_num_rows($re);
    if($num_row != 0){
		$_SESSION['login'] = $login;
		setcookie("login", $login, time()+5400, "","localhost");
		setcookie("pass", $password, time()+5400, "", "localhost");
		header('Location: http://localhost//park/user.php');
		exit;
    }
    else{
        echo "<p class='error'>Логин или пароль неправельные</p>";
    }
 }
 else {echo "<p class='error'>Введите логин и пароль</p>";}
 }
mysqli_close($conn);
?>
</div>
</body>
</html>


