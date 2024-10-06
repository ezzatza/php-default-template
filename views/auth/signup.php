<?php
$to = "/../..";
require __DIR__ . $to . "/controllers/auth.php";
?>
<!DOCTYPE html>
<html lang="<?= $language; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?= $app_name . " - " . $lang['signup']; ?></title>
    <?php include __DIR__ . $to . "/includes/styles.php"; ?>
</head>

<body>

    <?php include __DIR__ . $to . "/includes/navbar.php"; ?>

    <div class="container">

        <?= message(); ?>

        <form action="" method="POST" enctype="multipart/form-data" class="custom-form">
            <h2>New Account</h2>

            <div class="input-group">
                <label for="fullname-input">Full Name</label>
                <input minlength="4" type="text" name="fullname" id="fullname-input" placeholder="Fullname.." required>
            </div>

            <div class="input-group">
                <label for="username-input">Username</label>
                <input minlength="4" type="text" name="username" id="username-input" placeholder="Username.." required>
            </div>

            <div class="input-group">
                <label for="email-input">Email</label>
                <input type="email" name="email" id="email-input" placeholder="Email.." required>
            </div>

            <div class="input-group">
                <label for="password-input">Password</label>
                <input minlength="6" type="password" name="password" id="password-input" placeholder="Password.." required>
            </div>

            <div class="input-group">
                <label for="re-password-input">Retpye Password</label>
                <input minlength="6" type="password" name="re_password" id="re-password-input" placeholder="Password.." required>
            </div>

            <?php CSRF::csrf(); ?>

            <div class="input-group">
                <p>You already have account? <a href="/login" style="color: var(--main-color);">Login</a></p>
                <p>Go back to <a href="/" style="color: var(--main-color);">Home</a></p>
            </div>

            <div class="input-group">
                <button type="submit" name="signup" class="btn">Sign Up</button>
            </div>
        </form>
    </div>

    <?php include __DIR__ . $to . "/includes/scripts.php"; ?>

</body>

</html>