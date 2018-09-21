<?php

// Подключаемся к базе для авторизации
session_start();

include '../config/adminbase.php';

mysql_connect($host_ad,$username_ad,$password_ad) or die ("Не получается подключиться к базе");
@mysql_select_db($db_name_ad) or die( "Такой базы не существует");
$user=$_POST['user'];
$pwd=$_POST['pwd'];
$_SESSION['user']= $user;
$_SESSION['pwd']= $pwd;
$sessuser= $_SESSION['user'];
$sesspwd= $_SESSION['pwd'];
$query="SELECT * FROM users WHERE username ='$sessuser' and password ='$sesspwd' "; $dbresult = mysql_query($query);
$num = mysql_num_rows($dbresult);

if($_POST['submit']!="")
{
	
// Доступ по ссылке в случае успеха
if($num>0)
{
header("Location:index.php");
exit();
}
}
else
{
}

?>

<html>
<head>

	<!-- Метатеги страниц -->
    <?php	include '../elements/toper.php'; ?>

    <title>Авторизация</title>
	
       <!-- Стили CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/style.css" />
 
    <!-- jQuery самая последняя версия на 20.09.2018 -->
    <script src="../js/jquery-3.3.1.min.js"></script>
	
    <!-- Bootstrap JavaScript-->
    <script src="../js/bootstrap.min.js"></script>
   
</head>
   
<body>
     <div class="login-box">
     <!-- Сообщение об ошибке пароля или логина -->
     <?php
      if($_POST['submit']!="")
      {
      if($num==0)
      {
	 	 echo "<div class=\"alert alert-danger error-login\">Неправильный логин или пароль</div>";
	  }
     }
     ?>
	 
     <!-- Таблица с формой запроса к базе -->

         <form name="myform" action="" method="POST" style="table-login">
             <table class='table-login-sel'>
	 			
                   <tr>
	 			   <td width="43%" class="lefter-table">Логин:</td>
	 			   <td width="57%"><input class="righter-table" name="user" size="25"></td>
	 			   </tr>
	 			   
                    <tr>
					<td width="43%" class="lefter-table">Пароль:</td>
	 			   <td width="57%"><input  class="righter-table"  name= "pwd" type="password" size="25"></td>
	 			   </tr>
	 			   
                    <tr style="text-align:center;"><td colspan="2" rowspan="1"> 
                    <input type="submit" name="submit" value="Войти" class="btn btn-primary m-r-1em"></td></tr>
					
             </table>
         </form>
     </div>

    <!-- Footer страниц -->
    <?php	include '../elements/footer.php'; ?>

</body>
</html>