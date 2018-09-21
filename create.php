<!DOCTYPE HTML>
<html>

<head>

    <!-- Метатеги страниц -->
    <?php	include 'elements/toper.php'; ?>
    
	<title>Запланировать задачу</title>
     
    <!-- Стили CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/style.css" />
 
    <!-- jQuery самая последняя версия на 20.09.2018 -->
    <script src="js/jquery-3.3.1.min.js"></script>
	
    <!-- Bootstrap JavaScript-->
    <script src="js/bootstrap.min.js"></script>
	
    <!-- Картинка в форме предосмотра-->
    <script src="js/getimage.js"></script>

</head>

<body>
  
    <!-- Форма планировки задачи -->
    <div class="container">
        <div class="page-header">
            <h1>Запланировать задачу</h1>
        </div>
		
    <!-- PHP вставка с базой и формированием запроса -->  
     <?php
     if($_POST){
         // подключаем базу
         include 'config/database.php';
         try{
          
            // Выборка из базы
            $query = "INSERT INTO tasks
                      SET name=:name, email=:email, description=:description,
                      value=:value, image=:image";
            $stmt = $con->prepare($query);
             
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
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':image', $image);
      
              
            // Конечный результат
            if($stmt->execute()){
                echo "<div class=\"alert alert-success\">Задача сохранена.</div>";
     			
     		// Попытка загрузки пустого изображения
            if($image){

            // Переименование файла
            $target_directory = "uploads/";
            $target_file = $target_directory . $image;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
           
            $file_upload_error_messages="";		
				
			
            }
			
            // Проверка файла изображения
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
			
            
			// В принципе здесь можна добавить и дугие переменные с условиями:
			// размер файла в мб., размер изображения, цветовой режим...
            
			// Последняя проверка
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
             }  else{
                echo "<div class='alert alert-danger'>не получается загрузить.</div>";
             }

            }
          
         // Возможные ошибки
         catch(PDOException $exception){
             die('ERROR: ' . $exception->getMessage());
         }
     }
	 
     ?>
	 
 
    <!-- Форма для заполнения -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Имя</td>
                <td><input type='text' name='name' class='form-control' id="preview_name"/></td>
            </tr>
    		<tr>
                <td>Email</td>
                <td><input type='email' name='email' class='form-control' id="preview_email"/></td>
            </tr>
            <tr>
                <td>Описание задачи</td>
                <td><textarea name='description' class='form-control' id="preview_description"></textarea></td>
            </tr>
            <tr>
                <td>Статус - по умолчанию</td>
                <td><span>Активно</span><input type="hidden" name='value' class='form-control' id="preview_value" value="Активно" /></td>
            </tr>
    		<tr>
                <td>Изображение</td>
                <td><input type="file" name="image" class='btn btn-primary' accept="image/*" onchange="loadFile(event)" /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Сохранить' class='btn btn-success' onclick="img_resize()" />
                    <a href='index.php' class='btn btn-primary'>Вернуться к списку</a>
    	            <a class="btn btn-info" href="#popup1">Предосмотр</a>
                </td>
            </tr>
        </table>
    </form>
          
    </div> 

	<!-- Форма предосмотра-->
    <div id="popup1" class="overlay">
    	<div class="popup-show">
    		<h2>Предосмотр</h2>
    		<a class="close" href="#">&times;</a>
            <!-- Показ текста-->
    		<div id="preview" class="show-inputs">
                <div>Имя - <span class="preview_name"></span></div><br/>
    	        <div>Email - <span class="preview_email"></span></div><br/>
                <div>Описание задачи - <span class="preview_description"></span></div><br/>
                <div>Статус - <span class="preview_value">Активно</span></div>
            </div>
    		<!-- Показ картинки-->
    		<div class="content">
    		    <p>Изображение для загрузки</p>
    			<img id="outputimage" class="show-image-preview"/>
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
    <?php	include 'elements/footer.php'; ?>
	
</body>

</html>