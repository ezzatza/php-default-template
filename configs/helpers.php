<?php

// Get the base URL of the website
function base_url()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = "{$protocol}://{$host}";
    return $baseUrl;
}

// Query database
function query($query)
{
    global $con;
    return mysqli_query($con, $query);
}

// Check user inputs
function check_input($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Fetch query assoc
function fetch($query)
{
    return mysqli_fetch_assoc($query);
}

// Redirect to url
function redirect($link)
{
    header("Location: {$link}");
    exit;
}

// Show message
function message()
{
    if (isset($_SESSION['msg'])) {
        $output = "<div id='popup' class='popup-message'>{$_SESSION['msg']}</div>";
        $_SESSION['msg'] = null;
        return $output;
    } else {
        return null;
    }
}

// Generate string (default length is 10)
function generate_string($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

// Generate hashed token, for user account or something else (50 char)
function generate_user_token()
{
    return bin2hex(random_bytes(25));
}

// Get user by ID
function get_user($id)
{
    global $con;
    $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
    $query = mysqli_query($con, $sql);
    return $query;
}

// Encryption functions in OpenSSL
function encrypt($data)
{
    $key = $_ENV['APP_KEY'];
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt($data)
{
    $key = $_ENV['APP_KEY'];
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

// Slug the string
function slugify($string)
{
    $slug = strtolower($string);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

// Update visit counter
function update_view($id)
{
    if (isset($_SESSION['viewed_content'][$id])) {
        $lastViewTime = $_SESSION['viewed_content'][$id];
        $timeElapsed = time() - $lastViewTime;
        return $timeElapsed > 60 * 5; // 5 Minutes
    }
    return true;
}
