<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <?echo "<title>".$data['title']."</title>";?> 

       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body> 
        <?php
            if(isset($_SESSION['user.authed']) && $_SESSION['user.authed'] === true) 
                echo "<p>Вы авторизованы</p>"; 
            else 
                echo "<p>Вы не авторизованы</p>"; 
                
            include 'application/views/'.$content_view; 
        ?>
    </body> 
</html> 