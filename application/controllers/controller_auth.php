<?php
require_once 'helpers/bd_user.php';

//$logger = new MyLogger("././logs/mylogs.txt");

class Controller_Auth extends Controller
{
    public $callback;

    function index()
    { 
        $data = array(); 
        $data['title'] = 'Авторизация';  

        $this->view->generate('auth_view.php', $data);
    }
    
    function authorize() 
    { 
       
        if($_SERVER['REQUEST_METHOD'] !== "POST") die('Invalid method');

        $logger = new MyLogger("logs/mylogs.txt");

        if(isset($_POST['act']) && $_POST['act'] === 'authorize')
        {
            if($_POST["token"] == $_SESSION["CSRF"])
            {
                if((isset($_POST["login"])) && (isset($_POST["pass"])))
                {
                    $role = isset($_POST["role"]) ? $_POST["role"] : null;
                    $user = new db_user($_POST["login"], $_POST["pass"], $_POST["token"], $role);
                    $user->auth();

                    if(isset($user->response['auth.error']) && $user->response['auth.error'] !== false)
                    {
                        $logger->WriteLog("Неверный пароль", "Warning");
                        $logger->WriteLog($user->response, 'Array');
                    }

                    echo(json_encode($user->response));
                    // header('Location: http://localhost');
                    // exit;
        
                }
                if(isset($_POST["token"]) && (isset($_POST["save_token"])))
                {
                    setcookie("localhost_token", $_POST["token"], time()+3600);  
                }
        
            }
        } 
    }

    function vk_auth() 
    { 
        if($_POST["token"] == $_SESSION["CSRF"])
	    {
            $app_id = '51685017';
            $protected_key = 'aqu1LtQSXJYz4DikIo1t';
            $service_key = '3db493923db493923db49392fc3ea0350b33db43db4939259266a21f2b53e8ecfd50252';
            $url_vk = "https://oauth.vk.com/authorize";
            $redirect_url = "https://localhost/vk_auth.php";
            $params = [ 'client_id' => $app_id, 'redirect_uri'  => $redirect_url, 'response_type' => 'code'];

            if(isset($_POST["token"]) && (isset($_POST["save_token"])))
            {
                setcookie("localhost_token", $_POST["token"], time()+3600);  /* срок действия 1 час */
            }
	    }
    }

    function register()
    { 
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') die('Invalid method'); 
        
        $logger = new MyLogger("logs/mylogs.txt");
        if((isset($_POST["login"])) && (isset($_POST["pass"])))
        {
            $role = isset($_POST["role"]) ? $_POST["role"] : null;
            $user = new db_user($_POST["login"], $_POST["pass"], null, 'simple_user');
            $user->reg();

            if(isset($user->response['reg.error']) && $user->response['reg.error'] !== false)
            {
                $logger->WriteLog("Ошибка регистрации", "Warning");
                $logger->WriteLog($user->response, 'Array');
            }

            echo json_encode($user->response);
        }
        if(isset($_POST["token"]) && (isset($_POST["save_token"])))
        {
            setcookie("localhost_token", $_POST["token"], time()+3600);  /* срок действия 1 час */
        }
    }
}
