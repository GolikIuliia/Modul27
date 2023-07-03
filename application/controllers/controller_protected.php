<?php
class Controller_Protected extends Controller
{
    function index()
    {   
        $data = array(); 
        $data['title'] = 'Защищённая страница';  
        

        if(!isset($_SESSION['user.authed']) || $_SESSION['user.authed'] !== true) die('Недостаточно доступа');

        $this->view->generate('protected_view.php', $data);
    }
}