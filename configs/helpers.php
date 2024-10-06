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
    global $conn;
    return mysqli_query($conn, $query);
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

// Check if user logged in
function check_login()
{
    if (isset($_SESSION['login'])) {
        return true;
    } else {
        return false;
    }
}

// Show message
function message()
{
    if (isset($_SESSION['msg'])) {
        $output = "
        <div id='message' class='message'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 16 16'>
                <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2'/>
            </svg>
            {$_SESSION['msg']}
            <svg xmlns='http://www.w3.org/2000/svg' class='remove' id='remove' fill='currentColor' viewBox='0 0 16 16'>
                <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708'/>
            </svg>
        </div>";
        $_SESSION['msg'] = null;
        return $output;
    } else {
        return null;
    }
}

// Show alert
function alert()
{
    if (isset($_SESSION['alert'])) {
        $output = "<div id='popup' class='popup'>{$_SESSION['alert']}</div>";
        $_SESSION['alert'] = null;
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
