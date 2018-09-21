<?php

// Подключение к базе с конструктором PDO
$host = "localhost";
$db_name = "DBNAME";
$username = "USER";
$password = "PASSWORD";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}
  
// Сообщение об ошибке
catch(PDOException $exception){
    echo "Произошла ошибка: " . $exception->getMessage();
}


?>

