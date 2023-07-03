<?php

session_start(
    [
        'cookie_lifetime' => 86400,
    ]
);

include './app/db.php';
include './app/functions.php';
include './app/config.php';
include './helpers/logger.php';

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
//require_once 'function/bd.php';
require_once 'core/route.php';

Route::run();
?>