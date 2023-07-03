<?php
/**

 * @return PDO

*/
$_MYSQL_SETTINGS = array(); 
$_MYSQL_SETTINGS['DB_HOST'] = 'localhost'; 
$_MYSQL_SETTINGS['DB_PASS'] = 'root'; 
$_MYSQL_SETTINGS['DB_USER'] = 'root';  
$_MYSQL_SETTINGS['DB_NAME'] = 'registration';

function get_connection()
{
    return new PDO('mysql:host=localhost;dbname=registration', 'root', 'root');
}

function insertComment(array $data)
{
    $query = 'INSERT INTO comment (name, image, comment, created_at) VALUES(?, ?, ?, ?)';
    $db = get_connection();
    $stmt = $db->prepare($query);
    return $stmt->execute($data);
}

function insert(array $data)
{
    $query = 'INSERT INTO users (name, email, password, created_at) VALUES(?, ?, ?, ?)';
    $db = get_connection();
    $stmt = $db->prepare($query);
    return $stmt->execute($data);
}

function getUserByEmail(string $email)
{
    $query = 'SELECT * FROM users WHERE email = ?';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return $result;
    }
    return false;
}

function getUserByName(string $name)
{
    
    $query = 'SELECT * FROM users WHERE name = ?';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$name]);    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        return $result;
    }
    return false;
}

function getUsersList()
{
    $query = 'SELECT * FROM users ORDER BY id DESC';
    $db = get_connection();
    return $db->query($query, PDO::FETCH_ASSOC);
}

function getComments($image_name)
{
    $query = 'SELECT * FROM comment WHERE image = ?';
    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$image_name]);    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($result) {
        return $result;
    }
}
