<script src="assets/js/auth_form.js"></script>
<?
$token = hash('gost-crypto', random_int(0,999999));
$_SESSION["CSRF"] = $token;

$app_id = '51685017';
$protected_key = 'aqu1LtQSXJYz4DikIo1t';
$service_key = '3db493923db493923db49392fc3ea0350b33db43db4939259266a21f2b53e8ecfd50252';
$url_vk = "https://oauth.vk.com/authorize";
$redirect_url = "http://localhost/Modul27/vk_auth.php";
$params = [ 'client_id' => $app_id, 'redirect_uri'  => $redirect_url, 'response_type' => 'code'];
echo $link = '<p><a href="' . $url_vk . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a></p>';
?>

<form id='auth'>
  <input type="hidden" name="act" value="authorize">Аутентификация<br/>
  <input type="text" name="login" placeholder="Логин"><br/>
  <input type="password" name="pass"> <br/>
  <input type="hidden" name="token" value="<?=$token?>"><br/>
  <input type="submit" value="Войти">
  <div class="first-checkbox">
    <label class="label">
      <input type="checkbox" name="save_token" class="checkbox"  placeholder="Запомнить меня">
      <span class="fake"></span>
      <span class="text">Запомнить меня</span>
    </label>
  </div>
</form>

<form id='register'>
  <input type="hidden" name="act" value="registraton">Регистрация<br/>
  <input type="text" name="login" placeholder="Логин"><br/>
  <input type="password" name="pass"> <br/>
  <input type="submit" value="Зарегистрироваться">
</form>

<?
  $logger = new MyLogger("logs/mylogs.txt");

  echo $logger->ReadLog();
