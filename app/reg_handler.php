<?php
require_once "db.php";

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

register($_POST);