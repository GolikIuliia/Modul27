<head>
    <title>ГЛАВНАЯ</title>

</head>
<body>
    
    <h1>Добро пожаловать!</h1>
     
    <div class="text">Привет, это модуль 27</div>
    
   
    <?
if(isset($_SESSION) && is_array($_SESSION) && isset($_SESSION['role']) 
    $UserRole = $_SESSION['role']; 
else 
    $UserRole = 'unknown';

echo "<p>".$UserRole."</p>"; 
?> 

<?if($UserRole === 'simple_user'):?> 
    <p>Вам доступен контент только для simple_user</p> 
    <main> 

        <h2>Это просто абзац текста для модуля 27</h2>   
            
    </main>
<?endif;?> 

<?if($UserRole === 'vk_user'):?> 
<p>Вам доступен контент для simple_user и для vk_user</p> 
    <main> 

        <h2>Это просто абзац текста для модуля 27</h2>   
    <?php
    if($_SESSION['role'] !== "simple_user") : 
    ?>             
        <img src="/Modul27/images/girl.jfif">
    <? endif; ?>
    </main>  

<?endif;?> 
</body>
