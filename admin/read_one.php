<!DOCTYPE HTML>
<html>

<head>

	<!-- Метатеги страниц -->
    <?php	include '../elements/toper.php'; ?>

    <title>Планировщик - Прочтение задачи</title>
 
    <!-- Стили CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/style.css" />
   
	<!-- jQuery самая последняя версия на 20.09.2018 -->
    <script src="../js/jquery-3.3.1.min.js"></script>
	
    <!-- Bootstrap JavaScript-->
    <script src="../js/bootstrap.min.js"></script>
 
</head>

<body>
 
 
    <!-- Форма вывода данных на странице -->
    <div class="container">
        <div class="page-header">
            <h1>Карточка задачи</h1>
        </div>
         
    <?php
	// Подключаемся к базе
    include '../config/database.php';
	
    // Выборка сс учетом ID
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    try {
    // Делаем запрос на экспорт данных
	$query = "SELECT id, name, email, description, value, image FROM tasks WHERE id = ? LIMIT 0,1";

    $stmt = $con->prepare( $query );
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // Добавляем данные
    $name = $row['name'];
	$email = $row['email'];
    $description = $row['description'];
    $value = $row['value'];
	$image = htmlspecialchars($row['image'], ENT_QUOTES);
    }
 
    // Если есть ошибки, то будет сообщение об их форме
    catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
    }
    ?>
 
     <!-- Отображаем данные в таблице-->
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Имя</td>
            <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
        </tr>
    	    <tr>
            <td>Email</td>
            <td><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Описание</td>
            <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Статус</td>
            <td><?php echo htmlspecialchars($value, ENT_QUOTES);  ?></td>
        </tr>
    	<tr>
            <td>Изображение</td>
            <td>
            <?php echo $image ? "<img src='../uploads/{$image}' style='width:200px;' />" : "Здесь нет картинки.";  ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
            <a href='index.php' class='btn btn-primary'>Вернуться к списку</a>
            </td>
        </tr>
    </table>
 
    </div>
	<!-- конец формы сортировки данных -->
     
    <!-- Footer страниц -->
    <?php	include '../elements/footer.php'; ?>
	 
</body>

</html>