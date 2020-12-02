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
        <br>Телефон: <input type="phone" name="t4" maxlength="12" placeholder="+79216064053"> <br>
		<br><input type="submit" value="OK">
	</form>
    <form action="auth.php" method="POST">
        <button class="" rel="stylesheet">Авторизация</button>
    </form>
	</body>
</html>

<?php if(isset($_POST["t1"]) and isset($_POST["t2"]) and isset($_POST["t3"]) and isset($_POST["t4"])){
    //$dbconn = mysqli_connect("localhost", "root", 12345, "park", 3303);
	$conn = mysqli_connect("localhost", "root", 1234, "park", 3306);
	$select = "select login from park.users WHERE '$_POST[t1]' = login or ifnull(('$_POST[t3]'),'!') = mail or ifnull(('$_POST[t4]'),'!') = phone ;";
	$re = mysqli_query($conn, $select);
	$numr = mysqli_num_rows($re);
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
	if($numr > 1){
		echo"the row num is $numr \n";
	    echo "$_POST[t1] login taken";
    }
	else{
        $insert = "insert into park.users(password, login, mail, phone) value ('$_POST[t2]', '$_POST[t1]', ".$p3.", ".$p4.");";
        $result = mysqli_query($conn, $insert) or die('8');
		$select1 = "select login from park.users WHERE '$_POST[t1]' = login;";
		$re1 = mysqli_query($conn, $select1);
		$numr1 = mysqli_num_rows($re1);
		echo"the row num is $numr1 \n";
		
    }
}
?>

