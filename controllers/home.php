<?php

if (isset($_GET['logout'])) {
    $_SESSION['login'] = null;
    $_SESSION['msg'] = "Logged out successfully.";
    redirect('/');
}
