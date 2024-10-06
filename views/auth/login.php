<?php
$to = "/../..";
require __DIR__ . $to . "/controllers/auth.php";
?>
<!DOCTYPE html>
<html lang="<?= $language; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?= $app_name . " - " . $lang['login']; ?></title>
    <?php include __DIR__ . $to . "/includes/styles.php"; ?>
</head>

<body>

    <?php include __DIR__ . $to . "/includes/navbar.php"; ?>

    <div class="container">

        <?= message(); ?>

        <form action="" method="POST" enctype="multipart/form-data" class="custom-form">
            <h2>Login</h2>

            <div class="input-group">
                <label for="username">Username or Email</label>
                <input type="text" name="username" id="username-input" placeholder="Username or Email.." required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password-input" placeholder="Password.." required>
            </div>

            <?php CSRF::csrf(); ?>

            <div class="input-group">
                <p>You don't have an account? <a href="/signup" style="color: var(--main-color);">Signup</a></p>
                <p>Go back to <a href="/" style="color: var(--main-color);">Home</a></p>
            </div>

            <div class="input-group">
                <button type="submit" name="login" class="btn">Login</button>
            </div>

        </form>
    </div>

    <?php include __DIR__ . $to . "/includes/scripts.php"; ?>

</body>

</html>