<?
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
		$result = mysqli_fetch_all(mysqli_query($link, "SELECT * FROM users WHERE LOGIN='". $this->login. "'"), MYSQLI_ASSOC);
		$this->response['db.result'] = $result; 
		$this->response['io.login'] = $this->login; 
		$this->response['io.pass'] = $this->pass;
		$this->response['sql.query'] = "SELECT * FROM users WHERE LOGIN='". $this->login. "'"; 
		
		
		if(count($result) > 0)
		{
			$result = $result[0];
			if(password_verify($this->pass, $result['PASSWORD'])) 
			{ 
				file_put_contents('userout.txt', var_export($result, true), FILE_APPEND | LOCK_EX);
				$this->role = $result['ROLE'];
				$this->session_start();
				file_put_contents('userout.txt', var_export($result, true), FILE_APPEND | LOCK_EX);
			}
			else 
			{ 
				$this->response['auth.error'] = true;
				$this->response['auth.error_msg'] = "Неверные данные пользователя"; 
			}
			
		}
		else
		{
			$this->response['auth.error'] = true;
			echo ("Пароль и логин не найдены");		
		}
	}

	public function session_start()
	{
		$_SESSION['role'] =	$this->role;
		$_SESSION["user.authed"] = true;
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
			$result = mysqli_query($link, "INSERT INTO users (LOGIN, PASSWORD, TOKEN, ROLE) VALUES('". $this->login ."', '". password_hash($this->pass, PASSWORD_ARGON2I, ) ."', '". $this->token ."', '". $this->role ."')");
		}
	}
	public function vk_auth()
	{

	}
}