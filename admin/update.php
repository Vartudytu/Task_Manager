<!DOCTYPE HTML>

<html>

<head>

	<!-- Метатеги страниц -->
    <?php	include '../elements/toper.php'; ?>
    
	<title>Обновить задачу</title>
     
    <!-- Стили CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/style.css" />
 
    <!-- jQuery самая последняя версия на 20.09.2018 -->
    <script src="../js/jquery-3.3.1.min.js"></script>
	
    <!-- Bootstrap JavaScript-->
    <script src="../js/bootstrap.min.js"></script>
	
	<!-- Картинка в форме предосмотра-->
    <script src="../js/getimage.js"></script>
	
</head>

<body>
 
    <!-- Форма длявнесения изменений в базу -->
    <div class="container">  
        <div class="page-header">
            <h1>Изменить условия задачи</h1>
        </div>
     
    <?php
	 
	error_reporting(0); 
	 
	// подключаем базу
    include '../config/database.php';
	 
    // Достаем строку по ID
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
 

 
    // Подготавливаем запрос и читаем строку
    try {
    $query = "SELECT id, name, email, image, description, value FROM tasks WHERE id = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
    $name = $row['name'];
	$email = $row['email'];
    $description = $row['description'];
    $value = $row['value'];
	$image = htmlspecialchars($row['image'], ENT_QUOTES);
    }
 
    // Сообщения об ошибках
    catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
    }
    ?>


    <?php
     
    // Запрос на обновление данных
    if($_POST){
        try{
            $query = "UPDATE tasks 
                      SET name=:name, email=:email, description=:description, value=:value, image=:image
                      WHERE id = :id";
 
            $stmt = $con->prepare($query);
 
        // Используемые значения
        $name=htmlspecialchars(strip_tags($_POST['name']));
		$email=htmlspecialchars(strip_tags($_POST['email']));
        $description=htmlspecialchars(strip_tags($_POST['description']));
        $value=htmlspecialchars(strip_tags($_POST['value']));
		
		
		
		
		
		
	
        // Отдельно обрабатываем изображение
        $image=!empty($_FILES["image"]["name"])
             ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
             : "";
        $image=htmlspecialchars(strip_tags($image));
		
		
	    // Редактируем размер изображения
        $maxIncHeight = 320;
        $maxIncWidth = 240;
          $file_name = $_FILES['image']['tmp_name'];
          list($width, $height, $type, $attr) = getimagesize( $file_name );
          if ( $width > $maxIncWidth || $height > $maxIncHeight ) {
              $target_filename = $file_name;
              $selectori = $width/$height;
              if( $selectori > 1) {
                  $new_width = $maxIncWidth;
                  $new_height = $maxIncHeight;
              } else {
                  $new_width = $maxIncWidth;
                  $new_height = $maxIncHeight;
              }
        $src = imagecreatefromstring( file_get_contents( $file_name ) );
        $dst = imagecreatetruecolor( $new_width, $new_height );
        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
        imagedestroy( $src );
        imagepng( $dst, $target_filename );
        imagedestroy( $dst );
        }
		
 
        // Подгоняем параметры
        $stmt->bindParam(':id', $id);       
	    $stmt->bindParam(':name', $name);
		$stmt->bindParam(':email', $email);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':value', $value);
		$stmt->bindParam(':image', $image);
         
        // Конечный результат
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Задача обновлена.</div>";
			
        // Попытка загрузки пустого изображения
          if($image){
           
          // Переименование файла
          $target_directory = "../uploads/";
          $target_file = $target_directory . $image;
          $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
          
          $file_upload_error_messages="";
           
          }

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check!==false){
        }else{
            $file_upload_error_messages.="<div>Предложенный файл не является изображением или отсутствует.</div>";
        }
        
        // Допустимые расширения файлов
        $allowed_file_types=array("jpg", "jpeg", "png", "gif");
        if(!in_array($file_type, $allowed_file_types)){
           $file_upload_error_messages.="<div>JPG, JPEG, PNG, GIF допустимые расширения файлов.</div>";
        }
        
        if(empty($file_upload_error_messages)){
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
            }else{
                echo "<div class='alert alert-danger'>";
                echo "<div>Не получается загрузить.</div>";
                echo "<div>Обновите, чтобы загрузить.</div>";
                echo "</div>";
            }
        }
         
        // Сообщение об ошибке
        else{
            echo "<div class='alert alert-danger'>";
            echo "<div>{$file_upload_error_messages}</div>";
            echo "<div>Выберите файл изображения.</div>";
            echo "</div>";
        }
         }else{
             echo "<div class='alert alert-danger'>не получается загрузить.</div>";
         }
         
        }
     
         // Возможные ошибки
         catch(PDOException $exception){
             die('ERROR: ' . $exception->getMessage());
         }
    }
    ?>
 
    <!-- Форма для отправки в базу-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' id="preview_name" /></td>
        </tr>
		<tr>
            <td>Email</td>
            <td><input type='text' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' id="preview_email" /></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control' id="preview_description"><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
        </tr>
		<tr>
            <td>Value</td>
            <td>
			   <select name='value' class='form-control' id="preview_value"> 
			   <option value="Активно">Активно</option>
			   <option value="Выполнено">Выполнено</option>
			   <select/>
			</td>
        </tr>
		<tr>
            <td>Изображение</td>
            <td>
            <?php echo $image ? "<img src='../uploads/{$image}' style='width:200px;' />" : "No image found.";  ?>
            </td>
        </tr>
		<tr>
            <td>Photo</td>
            <td><input type="file" name="image" class='btn btn-primary' accept="image/*" onchange="loadFile(event)" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Сохранить' class='btn btn-success'/>
                <a href='index.php' class='btn btn-primary'>Вернуться к списку</a>
				<a class="btn btn-info" href="#popup1">Предосмотр</a>
            </td>
        </tr>
    </table>
    </form>
         
    </div> 
	<!-- Конец формы -->
	
	
	<!-- Форма предосмотра-->
    <div id="popup1" class="overlay">
    	<div class="popup-show">
    		<h2>Предосмотр</h2>
    		<a class="close" href="#">&times;</a>
            <!-- Показ текста-->
    		<div id="preview" class="show-inputs">
                <div>Имя - <span class="preview_name"><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></span></div><br/>
    	        <div>Email - <span class="preview_email"><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></span></div><br/>
                <div>Описание задачи - <span class="preview_description"><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></span></div><br/>
                <div>Статус - <span class="preview_value"><?php echo htmlspecialchars($value, ENT_QUOTES);  ?></span></div>
            </div>
    		<!-- Показ картинки-->
    		<div class="content">
    		    <p>Изображение для загрузки</p>
    			<img id="outputimage" class="show-image-preview" />
    		</div>
    	</div>
    </div>
	
    <!-- Скрипт под поля ввода данных на формате предосмотра, размещен в самом внизу так как событе onload не работает в IE ближе к версии 8.-->
    <script>
    $('.form-control').keyup(function(){
       var $this = $(this);
       $('.'+$this.attr('id')+'').html($this.val());
    });
    </script> 
     
    <!-- Footer страниц -->
    <?php	include '../elements/footer.php'; ?>
 
</body>

</html>