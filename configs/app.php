<?php

// session info
// session_name(''); // set static session name
session_set_cookie_params(604800); // session lifetime in seconds
session_start();

// include all requirements
require __DIR__ . "/libraries.php";
require __DIR__ . "/database.php";
require __DIR__ . "/helpers.php";
require __DIR__ . "/csrf.php";

// track visited content per user
if (!isset($_SESSION['viewed_content'])) {
    $_SESSION['viewed_content'] = [];
}

// track language (default is arabic)
$language = "ar";
if (isset($_SESSION['lang']) && $_SESSION['lang'] == "ar") {
    require __DIR__ . "/../languages/ar.php";
} else {
    $language = "en";
    require __DIR__ . "/../languages/en.php";
}

$isLogged = false;
if (isset($_SESSION['login'])) {
    $sql = "SELECT * FROM `users` WHERE `id` = '$_SESSION[login]'";
    $result = query($sql);

    if (mysqli_num_rows($result) > 0) {
        $isLogged = true;
        $user_data = fetch($result);

        $userId = $user_data['id'];
        $userName = $user_data['username'];
        $userRole = $user_data['role'];
        $isAdmin = false;

        if ($userRole == 1) {
            $isAdmin = true;
        }
    }
}

$app_name = $_ENV['APP_NAME'];
$app_ver = $_ENV['APP_VER'];