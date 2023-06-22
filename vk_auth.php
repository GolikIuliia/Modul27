<?php

if(isset($_GET['code'])) {
    $app_id = '51685017';
    $protected_key = 'aqu1LtQSXJYz4DikIo1t';
    $service_key = '3db493923db493923db49392fc3ea0350b33db43db4939259266a21f2b53e8ecfd50252';
    $url_vk = "https://oauth.vk.com/authorize";
    $redirect_url = "http://localhost/vk_auth.php";
    $params = [ 'client_id' => $app_id, 'client_secret'  => $protected_key, 'code' => $_GET['code'], 'redirect_uri' => $redirect_url];
 
    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
    if (isset($token['access_token'])) {
        $params = ['uids' => $token['user_id'],
        'fields' => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
        'access_token' => $token['access_token'],
        'v' => '5.101'];
        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['response'][0]['id'])) {
            $userInfo = $userInfo['response'][0];
            $result = true;
       }
    }
    if(isset($_SESSION["token"]))
		{
			setcookie("localhost_token", $_SESSION["token"], time()+3600);  /* срок действия 1 час */
		}
    echo "ID пользователя: " . $userInfo['id'] . '<br />';
    echo "Имя пользователя: " . $userInfo['first_name'] . '<br />';
    echo "Ссылка на профиль: " . $userInfo['screen_name'] . '<br />';
    echo "Пол: " . $userInfo['sex'] . '<br />';
    echo "День Рождения: " . $userInfo['bdate'] . '<br />';
    echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";

    require_once ('bd.php');
    $user = new db_user($userInfo['id'], '', $_SESSION["token"],'vk_user');
    $user->reg();
    if ($user->response['auth.error'] == true)
    {
        $user->auth();
    }
}