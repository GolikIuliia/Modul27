<?php

/**
 * Interface of Controller 
 * Для того, чтобы было немного понятнее, я реализую класс Controller через интерфейс (легче описать функцию)
 */

interface IController { 
    public function index(); // Объявим функцию index, как событие, что мы просто перешли на страницу.  
}

/**
 * Class Controller  
 * 
 */

class Controller implements IController { 
    public $model, $view; 

    function __construct() 
    {  
        $this->view = new View();   
    } 

    public function index() 
    { 

    }
}