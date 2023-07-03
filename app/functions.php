<?php
// var_dump($_POST);
//
function register(array $data)
{
    $values = [
        $data['name'],
        $data['email'],
        password_hash($data['password'], PASSWORD_ARGON2ID),
        (new DateTime())->format('Y-m-d H:i:s')
    ];
    return insert($values);
}

function authtorization(array $data)
{
    $values = [
        $data['name'],
        password_hash($data['password'], PASSWORD_ARGON2ID)
       //(new DateTime())->format('Y-m-d H:i:s')
    ];
    return getUserByName($values);
}

function getimages (){
    $images=[];
    $images_dir="././images";
    $files=scandir($images_dir);
    return $files;
}

function deleteImage($image)
{
    $response = array(); 
    $image = explode("/", $image);
    $filename = $image[count($image)-1]; //filename

    if( file_exists('./images/'.$filename) )
    { 
        $db = get_connection(); 
        try { 
            $response['deletedComments'] = $db->query("DELETE FROM comment WHERE image = '".$filename."'", PDO::FETCH_ASSOC); 
        } 
        catch (PDOException $e) { 
            $response['deletedComments'] = 'no comment found';
        } 

        unlink('./images/'.$filename); 

        $response['success'] = true; 
    }
    else 
    { 
        $response['success'] = false; 
    }
    
    return $response; 
}

function deleteComments($id)
{
    $query = 'DELETE FROM comment WHERE id = \''.$id.'\''; 
    $db = get_connection();
    return $db->query($query, PDO::FETCH_ASSOC);
}

function validate(array $request)
{
    $errors = [];
    if (!isset($request['email']) || strlen($request['email']) == 0) {
        $errors[]['email'] = 'Email не указан';
    } elseif (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[]['email'] = 'Неправильный формат email';
    } elseif (strlen($request['email']) < 4) {
        $errors[]['email'] = 'Email должен быть больше 4х символов';
    } elseif (isEmailAlreadyExists($request['email'])) {
        $errors[]['email'] = 'Email уже используется';
    }
    if (!isset($request['name']) || empty($request['name'])) {
        $errors[]['name'] = 'Имя не указано';
    }
    if (!isset($request['password']) || empty($request['password'])) {
        $errors[]['password'] = 'Пароль не указан';
    }
    if (!isset($request['repeat-password']) || empty($request['repeat-password'])) {

        $errors[]['repeat-password'] = 'Нужно повторить пароль';

    } elseif ((isset($request['password']) && isset($request['repeat-password'])) && ($request['password'] != $request['repeat-password'])) {

        $errors[]['repeat-password'] = 'Пароли не совпадают';
    }
    return $errors;
}

function isEmailAlreadyExists(string $email)
{
    if (getUserByEmail($email)) {
        return true;
    }
    return false;
}

function isNameAlreadyExists(string $name)
{
    if (getUserByName($name)) {
        return true;
    }
    return false;
}