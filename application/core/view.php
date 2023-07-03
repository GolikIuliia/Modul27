<?php
/**
 * Interface of View class
 */

interface IView { 
    public function generate($content_view, $data=null); // Генерирует нашу страницу
}

class View implements IView
{
    public static $template_view = 'head_view.php';     // здесь можно указать общий вид по умолчанию.
    
    function generate($content_view, $data = null)
    {
        include 'application/views/'.self::$template_view;
    }
}
?>