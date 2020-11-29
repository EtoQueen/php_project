<html>
    <title>
        Регистрация
    </title>
	<head>
        Регистрация ---
	</head>
	<body>
	<form action="" method="POST">
		<br>Логин: <input type="text" name="t1" maxlength="35" placeholder="Ivanov43"><br>
		<br>Пароль: <input type="password" name="t2" maxlength="21"><br>
        <br>Почта: <input type="email" name="t3" maxlength="35" placeholder="Ivanov@gmail.com"><br>
        <br>Телефон: <input type="phone" name="t4" maxlength="12" placeholder="+7 921 553 53 53"> <br>
		<br><input type="submit" value="OK">
	</form>
    <form action="auth.php" method="POST">
        <button class="" rel="stylesheet">Авторизация</button>
    </form>
	</body>
</html>

<?php
    //$dbconn = mysqli_connect("localhost", "root", 12345, "park", 3303);
	$conn = mysqli_connect("localhost", "root", 12345, "park", 3304);

	$select = "select login from park.users WHERE '$_POST[t1]' = login and '$_POST[t3]' = mail and $_POST[t4] = phone ;";
	$re = mysqli_query($conn, $select);
	$num_row= mysqli_num_rows($re);
	if($num_row != 0){
	    echo "$_POST[t1] login taken";
    }
	else{
        $insert = "insert into park.users(password, login, mail, phone) value ('$_POST[t2]', '$_POST[t1]','$_POST[t3]','$_POST[t4]');";
        $result = mysqli_query($conn, $insert) or die('8');
    }
?>

