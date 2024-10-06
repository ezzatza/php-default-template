<!DOCTYPE html>
<html lang="<?= $language; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?= $app_name; ?></title>
    <?php include __DIR__ . "/../includes/styles.php"; ?>
</head>

<body>

    <div style="display: flex; align-items: center; justify-content: center; height: 100vh; flex-direction: column;">
        <h1>Welcome to FrameZil PHP!</h1>
        <p>This is version 1.0, ALPHA</p>
        <p>FrameZil is just a very simple PHP Template to use it for simple projects</p>
        <p><a class="btn" href="https://github.com/ezzatza/php-default-template" target="_blank">Github</a></p>
    </div>

    <?php include __DIR__ . "/../includes/scripts.php"; ?>

</body>

</html>