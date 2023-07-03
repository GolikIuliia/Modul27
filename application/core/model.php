<?php
/**
 * Interface of Model 
 * 
 */

interface IModel { 
    public function indexData(); // Пусть объявлена функция, которая возвращает информацию о событии index из контроллера
}

class Model implements IModel
{
    public function indexData() 
    {

    }
}