<?php
 
include 'config/lib.php';
 
$pages = include 'config/pages.php';
 
$page = getPage($pages);
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <ul>
          <li>
            <a href="?page=1">Main</a>
          </li>
          <li>
            <a href="?page=2">About</a>
          </li>
          <li>
            <a href="?page=3">Contact</a>
          </li>
        </ul>
        <?php
 
include 'pages/' . $page;

if (issert($_REQUEST[submit])){
    echo "Спасибо за Вашу обратную связь";
    else {echo "Упс, что-то пошло не так";}
 }     
 
?> 
   
   <form>
     
      <textarea cols="32" name="massage" rows="5"><br>
      <input type="submit" value="Отправить" />
   </form>
     
      
      </body>
    </html>