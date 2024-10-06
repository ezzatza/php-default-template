<?php
$to = "/..";
require __DIR__ . $to . "/controllers/home.php";
?>
<!DOCTYPE html>
<html lang="<?= $language; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?= $app_name; ?></title>
    <?php include __DIR__ . $to . "/includes/styles.php"; ?>
</head>

<body>

    <?php include __DIR__ . $to . "/includes/navbar.php"; ?>

    <div style="display: flex; align-items: center; justify-content: center; height: 100vh; flex-direction: column;" class="container">
        <?= message(); ?>
        <h1>Welcome to FrameZai PHP!</h1>
        <p>Version <?= $app_ver; ?></p>
        <p>Just a lightweight and simple PHP Template for simple projects</p>
        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1rem;">
            <p>
                <button id="theme" class="btn">
                    Color
                </button>
            </p>
            <p><a class="btn" href="https://github.com/ezzatza/php-default-template" target="_blank">Github</a></p>

            <?php
            if (!check_login()) {
            ?>
                <p><a class="btn" href="/login">Login</a></p>
                <p><a class="btn" href="/signup">Signup</a></p>
            <?php
            } else {
            ?>
                <p><a class="btn" href="/?logout">Logout</a></p>
            <?php
            }
            ?>
        </div>
    </div>

    <?php include __DIR__ . $to . "/includes/scripts.php"; ?>

</body>

</html>