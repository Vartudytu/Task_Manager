<?php

// Отдельныя сессия к базе данных за логином, сделано таким образом, чтобы присекать доступ к странице даже по прямой ссылке

session_start();

include '../config/adminbase.php';

mysql_connect($host_ad,$username_ad,$password_ad) or die ("Не получается подключиться к базе");
@mysql_select_db($db_name_ad) or die( "Такой базы не существует");
$sessuser= $_SESSION['user'];
$sesspwd= $_SESSION['pwd'];
$query="SELECT * FROM users WHERE username ='$sessuser' AND password ='$sesspwd'";
$dbresult = mysql_query($query);
$num = mysql_num_rows($dbresult);
if($num>0)
{
	


// Продолжаем код php чуть ниже открыв строку на формировании страницы
?>
	
<!DOCTYPE HTML>

<html>

<head>

	<!-- Метатеги страниц -->
    <?php	include '../elements/toper.php'; ?>

    <title>Планировщик Версия 1.6 - Админ. панель</title>
     
    <!-- Стили CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/style.css" />
 
    <!-- jQuery самая последняя версия на 20.09.2018 -->
    <script src="../js/jquery-3.3.1.min.js"></script>
	
    <!-- Bootstrap JavaScript-->
    <script src="../js/bootstrap.min.js"></script>
 
</head>

<body>
 

    <!-- Форма сортировки данніх на странице -->
    <div class="container">
        <div class="page-header">
            <h1>Планировщик задач - Админ. панель</h1>
        </div>
     
        <div>	 
           <span></span><a href='create.php' class='btn btn-primary m-b-1em'>Создать задачу</a>
           <span></span><a href='../index.php' class='btn btn-success m-b-1em'>Вернуться к обычному меню</a>
        
           <form name="Email Header" class="sorter-line" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
               <span><strong>УПОРЯДОЧИТЬ:</strong></span>
               <button type="submit" name="sorter" class="btn btn-info" value="ORDER BY name ASC">ПО ИМЕНИ</button>
               <button type="submit" name="sorter" class="btn btn-info" value="ORDER BY email ASC">ПО EMAIL</button>
               <button type="submit" name="sorter" class="btn btn-info" value="ORDER BY value ASC">ПО СТАТУСУ</button>
           </form>
        </div>
     
        <?php
        // Подключаемся к базе
        include '../config/database.php';
        
        //Достаем условие для сортировки
        $select_order = ($_POST['sorter']);
        
        // Делаем страницы
        // по умолчанию страница 1 как первая
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
         
        // Всего строк на страницу
        $records_per_page = 3;
         
        $from_record_num = ($records_per_page * $page) - $records_per_page;
        
        // Выбираем данне для страницы
        $query = "SELECT id, name, email, description, value FROM tasks $select_order
        LIMIT :from_record_num, :records_per_page";
 
        $stmt = $con->prepare($query);
        $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
 
        // Формируем таблицу
        $num = $stmt->rowCount();
        if($num>0){
            echo "<table class='table table-hover table-responsive table-bordered'>";//start table
            echo "<tr>";
            echo "<th width=\"3%\">ID </th>";
            echo "<th width=\"10%\">Имя</th>";
		    echo "<th width=\"7%\">Email</th>";
            echo "<th width=\"42%\">Задача</th>";
            echo "<th width=\"5%\">Статус</th>";
            echo "<th width=\"33%\">Функции</th>";
            echo "</tr>";
     
        // На структуре PDO получаем таблицу

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
     
           // Данные для таблицы
            echo "<tr>";
            echo "<td>{$id}</td>";
            echo "<td>{$name}</td>";
	        echo "<td>{$email}</td>";
            echo "<td>{$description}</td>";
            echo "<td>{$value}</td>";
            echo "<td>";
            echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Просмотреть</a>";
            echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Изменить</a>";
            echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Удалить</a>";
            echo "</td>";
            echo "</tr>";
        }
		
        // конец формирования таблицы
        echo "</table>";


        // Формирование страниц
        $query = "SELECT COUNT(*) as total_rows FROM tasks";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_rows = $row['total_rows'];
        $page_url="index.php?";
        include_once "paging.php";          
        }
         
        // Если данных нет
        else{
            echo "<div class='alert alert-danger'>Данных нет в базе.</div>";
        }
        ?>
         
    </div> 
	<!-- конец формы сортировки данных -->
     
         
    <!-- Скрипт для удаления данных, вызывает страницу под чистку, размещен в самом внизу так как фсобыте onload не работает в IE близкм к версии 8.-->
    <script type='text/javascript'>
       function delete_user( id ){
           var answer = confirm('Вы уверены?');
           if (answer){
               window.location = 'delete.php?id=' + id;
           } 
       }
    </script>
 
    <!-- Footer страниц -->
    <?php	include '../elements/footer.php'; ?>
 
</body>

</html>


<?php 

}
else
{
header("Location:login.php ");
}

// Закрытие самой верхней сессии и перенаправление на авторизацию

?>