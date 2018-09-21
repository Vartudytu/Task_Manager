<?php

// Функционал страниц

    //Открытие формы
    echo "<ul class='pagination pull-left margin-zero mt0'>";
    // Кнопка первой страницы
    if($page>1){
        $prev_page = $page - 1;
            echo "<li>";
            echo "<a href='{$page_url}page={$prev_page}'>";
            echo "<span style='margin:0 .5em;'>&laquo;</span>";
            echo "</a>";
            echo "</li>";
    }
 
 
    // Всего страниц и соответсвенно кнопок.
    $total_pages = ceil($total_rows / $records_per_page);
 
    // На сколько страниц переключать
    $range = 1;
     
    // Сколько ближайших страниц отобразится в меню, в данном случае 1 страница слева и одна справа
    $initial_num = $page - $range;
    $condition_limit_num = ($page + $range)  + 1;
 
    for ($x=$initial_num; $x<$condition_limit_num; $x++) {
    if (($x > 0) && ($x <= $total_pages)) {
 
        // current page
        if ($x == $page) {
            echo "<li class='active'>";
                echo "<a href='javascript::void();'>{$x}</a>";
            echo "</li>";
        }
 
        // not current page
        else {
            echo "<li>";
                echo " <a href='{$page_url}page={$x}'>{$x}</a> ";
            echo "</li>";
        }
      }
    }
 
 
    // Кнопка последней страницы
    if($page<$total_pages){
        $next_page = $page + 1;
            echo "<li>";
            echo "<a href='{$page_url}page={$next_page}'>";
            echo "<span style='margin:0 .5em;'>&raquo;</span>";
            echo "</a>";
            echo "</li>";
    }
    // Закрытие формы
    echo "</ul>";
	
?>