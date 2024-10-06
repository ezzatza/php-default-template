<?php

class CSRF
{
    public static function csrf()
    {
        $token = md5(time());
        $_SESSION['token'] = $token;

        echo "<input name='_token' value='$token' type= 'hidden'>";
    }

    public static function csrf_check($token)
    {
        return isset($_SESSION['token']) && $_SESSION['token'] == $token;
    }
}
