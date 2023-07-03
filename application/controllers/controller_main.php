<?php
class Controller_Main extends Controller
{
    function index()
    {   
        $data = array(); 
        $data['title'] = 'Главная странициа';  
        
        $this->view->generate('main_view.php', $data);
    }
}