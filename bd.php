<?
session_start([
    'cookie_lifetime' => 86400,
]);
/**

 * @return PDO

*/
$_MYSQL_SETTINGS = array(); 
$_MYSQL_SETTINGS['DB_HOST'] = 'localhost'; 
$_MYSQL_SETTINGS['DB_PASS'] = 'root'; 
$_MYSQL_SETTINGS['DB_USER'] = 'root';  
$_MYSQL_SETTINGS['DB_NAME'] = '27';

class db_user {
private $login, $pass, $token, $role;
public $response = [];

	public function __construct($login, $pass, $token, $role) 
    { 
        $this->login = $login;
        $this->pass = $pass;
		$this->token = $token;
		$this->role = $role;
	}
	public function auth()
	{
		$link = mysqli_connect('localhost', 'root', 'root', '27');
		$result = mysqli_query($link, "SELECT * FROM users WHERE LOGIN='". $this->login. "' AND PASSWORD='". password_hash($this->pass, PASSWORD_ARGON2I) . "'");
		if(mysqli_num_rows($result) >0)
		{
			file_put_contents('userout.txt', var_export($result, true), FILE_APPEND | LOCK_EX);
			$this->role = $result[0]['ROLE'];
			$this->session_start();
			file_put_contents('userout.txt', var_export($result, true), FILE_APPEND | LOCK_EX);
			
		}
		else
		{
			$this->response['auth.error'] = true;
			echo ("Пароль и логин не найдены");		}
	}
	public function session_start($auth_type)
	{
		$_SESSION['role'] =$this->role;
		$_SESSION["isauth"] = true;
	}

	public function reg()
	{
		$link = mysqli_connect('localhost', 'root', 'root', '27');
		$result = mysqli_query($link, "SELECT * FROM users WHERE LOGIN='". $this->login. "'");
		if(mysqli_num_rows($result) >0)
		{
			$this->response['reg.error'] = true;
			
		}
		else
		{
			$result = mysqli_query($link, "INSERT INTO users (LOGIN, PASSWORD, TOKEN, ROLE) VALUES('". $this->login ."', '". password_hash($this->pass, PASSWORD_ARGON2I) ."', '". $this->token ."', '". $this->role ."')");
		}
	}
	public function vk_auth()
	{

	}
}
if($_SERVER['REQUEST_METHOD'] !== "POST") die();
if(isset($_POST['act']) && $_POST['act'] === 'authorize')
{
	if($_POST["token"] == $_SESSION["CSRF"])
	{
		if((isset($_POST["login"])) && (isset($_POST["pass"])))
		{
			$role = isset($_POST["role"]) ? $_POST["role"] : null;
			$user = new db_user($_POST["login"], $_POST["pass"], $_POST["token"], $role);
			$user->auth();
			echo(json_encode($user->response));
			//$_SESSION['role'] = $role;
			header('Location: http://localhost/Modul27/index.php');

		}
		if(isset($_POST["token"]) && (isset($_POST["save_token"])))
		{
			setcookie("localhost_token", $_POST["token"], time()+3600);  /* срок действия 1 час */
		}

	}
}

if(isset($_POST['act']) && $_POST['act'] === 'vk_auth')
{
	if($_POST["token"] == $_SESSION["CSRF"])
	{
		$app_id = '51685017';
		$protected_key = 'aqu1LtQSXJYz4DikIo1t';
		$service_key = '3db493923db493923db49392fc3ea0350b33db43db4939259266a21f2b53e8ecfd50252';
		$url_vk = "https://oauth.vk.com/authorize";
		$redirect_url = "http://localhost/vk_auth.php";
		$params = [ 'client_id' => $app_id, 'redirect_uri'  => $redirect_url, 'response_type' => 'code'];

		if(isset($_POST["token"]) && (isset($_POST["save_token"])))
		{
			setcookie("localhost_token", $_POST["token"], time()+3600);  /* срок действия 1 час */
		}

	}
}
if(isset($_POST['act']) && $_POST['act'] === 'registraton')
{
	//if($_POST["token"] == $_SESSION["CSRF"])
	{
		if((isset($_POST["login"])) && (isset($_POST["pass"])))
		{
			$role = isset($_POST["role"]) ? $_POST["role"] : null;
			$user = new db_user($_POST["login"], $_POST["pass"], null, 'simple_user');
			$user->reg();
			echo(json_encode($user->response));

		}
		if(isset($_POST["token"]) && (isset($_POST["save_token"])))
		{
			setcookie("localhost_token", $_POST["token"], time()+3600);  /* срок действия 1 час */
		}

	}
}
?>