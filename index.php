<?php
session_start([
    'cookie_lifetime' => 86400,
]);
if(isset($_SESSION) && isset($_SESSION['role']) && ($_SESSION['role'] !== "simple_user")) die("Недостаточно прав");
var_dump($_SESSION);
?>
<html>
    <head>
        <title>Страница</title>
        <link rel="stylesheet" href="css.css">
    </head>
    <body>        
        <header>
            <h1>Модуль 27</h1>            
        </header>
        <main> 

                <h2>Это просто абзац текста для модуля 27</h2>   
                <?php
                if($_SESSION['role'] !== "simple_user") : 
                ?>             
                    <img src="/Modul27/images/girl.jfif">
                <? endif; ?>
        </main>            
    </body>
</html> 		 
