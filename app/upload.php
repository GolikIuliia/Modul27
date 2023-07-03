<?php
include 'config.php'; 
//if(!isset($_SESSION["user.authed"]) || !$_SESSION["user.authed"]) die;

// Название <input type="file">
$input_name = 'file';
 
// Разрешенные расширения файлов.
$allow = array();
 
// Запрещенные расширения файлов.
$deny = $cfg::getConfig('fileExtensionsDeny'); 
 
// Директория куда будут загружаться файлы.
$path = '../images/'; // .. - выйти из директории app (аналогично cd ..)

file_put_contents("log_send_images.txt", "отправлено", FILE_APPEND | LOCK_EX);

$error = '';
if (!isset($_FILES[$input_name])) 
{
    $error = 'Файл не загружен.';
} 
else 
{
    $file = $_FILES[$input_name];

    if (!empty($file['error']) || empty($file['tmp_name'])) 
    {
        $error = 'Не удалось загрузить файл.';
    } 
    elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) 
    {
        $error = 'Не удалось загрузить файл.';
    } 
    // elseif($file['size'] > 1024*1024*$cfg::getConfig('maxFileSize')) 
    // { 
    //     $error = "Слишком большой фаил";
    // }
    else 
    { 

        $pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
        $name = mb_eregi_replace($pattern, '-', $file['name']);
        $name = mb_ereg_replace('[-]+', '-', $name);
        $parts = pathinfo($name);
        if (empty($name) || empty($parts['extension'])) {
            $error = 'Недопустимый тип файла';
        } elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
            $error = 'Недопустимый тип файла';
        } elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
            $error = 'Недопустимый тип файла';
        } else {
        // Перемещаем файл в директорию.
            if (move_uploaded_file($file['tmp_name'], $path . $name)) {
            // Далее можно сохранить название файла в БД и т.п.
            } else {
                $error = 'Не удалось загрузить файл.';
            }
        }
    }

    echo $error; 
}