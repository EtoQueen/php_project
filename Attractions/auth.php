<html>
<title>
    Авторизация
</title>
	<head>
        Авторизация---
	</head>
	<body>
	<form action="" method="POST" >
		<br>Логин: <input type="text" name="t1" maxlength="35" placeholder="Ivanov43"><br>
		<br>Пароль: <input type="password" name="t2" maxlength="21"><br>
		<br><input type="submit" value="OK">
	</form>
    <form action="regist.php" method="POST">
        <button class="" rel="stylesheet">Регистрация</button>
    </form>

	</body>
</html>

<?php
	$conn = mysqli_connect("localhost", "root", 12345, "park", 3304);
    $select = "select login, password from park.users WHERE '$_POST[t1]' = login and '$_POST[t2]' = password;";
    $re = mysqli_query($conn, $select);
    $num_row= mysqli_num_rows($re);
    if($num_row != 0){
        echo "Welcome $_POST[t1]";
    }
    else{
        echo "Логин или Пароль неправельные";
    }
?>

