<!DOCTYPE HTML>

<html>

<body>

<?php
    // Подключаемся к базе
    include '../config/database.php';
 
    // Находим строку по ID
    try {
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
 
    // Делаем запрос на удаление
    $query = "DELETE FROM tasks WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
     
    if($stmt->execute()){
    }else{
        die();
    }
    }
 
    // Если ошибки будут, то их высветит
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
?>

   <script>
   someTimeout = 10; // Скрипт возвращения на главную страницу списка, вернуться через header в данном случае не получиться
   window.setTimeout("document.location = 'index.php';", someTimeout);
   </script>

</body>

</html>

