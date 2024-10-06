<?php

function send_active_email($email, $username, $token)
{
    $website_title = "Website Name";
    $website_url = "https://example.com";
    $subject = "Account Activation";
    $message = "
        <html>
        <head>
        <title>Account Activate</title>
        </head>
        <body>
        <p>Hi, $username</p>
        <p>You have signed up on the our website</p>
        <p>Please click on the following link to activate your account</p>
        <p><a href='$website_url/login?key=$token&action=active_account'>Activate Account</a></p>
        <p>If you did not request this email, please ignore it</p>
        <p>- $website_title</p>
        </body>
        </html>
    ";

    // Headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $website_title <noreply@example.com>" . "\r\n";

    return mail($email, $subject, $message, $headers);
}

// Check if the user is already logged in
if (check_login()) {
    // If logged in, redirect to the home page
    redirect('/');
}

// Handle the login form submission
if (isset($_POST['login'])) {

    // Check if the CSRF token is valid
    if (CSRF::csrf_check($_POST['_token'])) {

        // Ensure both username and password fields are not empty
        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            // Validate the minimum length of username and password
            if (strlen($_POST['username']) >= 4 && strlen($_POST['password']) >= 6) {
                // Sanitize the username or email input
                $username_or_email = check_input($_POST['username']);

                // Check if the input is a valid email address
                if (filter_var($username_or_email, FILTER_VALIDATE_EMAIL)) {
                    // Query the database using the email address
                    $sql = "SELECT * FROM `users` WHERE `email` = '$username_or_email'";
                } else {
                    // Query the database using the username
                    $sql = "SELECT * FROM `users` WHERE `username` = '$username_or_email'";
                }

                // Execute the query to search for the user
                $query = query($sql);

                // If a user record is found
                if (mysqli_num_rows($query) > 0) {
                    // Fetch the user's data from the database
                    $data = fetch($query);
                    $password = $data['password'];

                    // Verify if the password provided matches the stored hashed password
                    if (password_verify($_POST['password'], $password)) {

                        // Set the session login with the user ID and redirect to the home page
                        $_SESSION['msg'] = "Logged in succesfully, Welcome $data[fullname]";
                        $_SESSION['login'] = $data['id'];
                        redirect('/');
                    } else {
                        $_SESSION['msg'] = "Incorrect information";
                    }
                } else {
                    $_SESSION['msg'] = "Account not fount";
                }
            } else {
                $_SESSION['msg'] = "Password should be 6 characters, Username should be 4 chracters";
            }
        } else {
            $_SESSION['msg'] = "Enter valid username or password";
        }
    } else {
        $_SESSION['msg'] = "Invalid CSRF Token, Reload the page";
    }

    redirect('/login');
}

// Handle the signup form submission
if (isset($_POST['signup'])) {

    // Check if the CSRF token is valid
    if (CSRF::csrf_check($_POST['_token'])) {

        // Ensure that all required fields are filled out
        if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['fullname']) && !empty($_POST['email'])) {

            // Validate the minimum length for username and password
            if (strlen($_POST['username']) >= 4 && strlen($_POST['password']) >= 6) {

                // Ensure that the password and re-entered password match
                if ($_POST['password'] == $_POST['re_password']) {

                    // Sanitize the email input
                    $email = check_input($_POST['email']);

                    // Check if the email is a valid format
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                        // Sanitize the username input
                        $username = check_input($_POST['username']);

                        // Query the database to check if the username or email already exists
                        $sql = "SELECT * FROM `users` WHERE `username` = '$username' OR `email` = '$email'";
                        $query = query($sql);

                        // If no existing user is found with the same username or email
                        if (mysqli_num_rows($query) <= 0) {

                            // Generate a token for the new user
                            $token = generate_user_token();

                            // Sanitize the fullname input
                            $fullname = check_input($_POST['fullname']);

                            // Hash the password using the default hashing algorithm
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                            // Send email for account activation
                            send_active_email($email, $username, $token);

                            // Insert the new user data into the database
                            $sql = "INSERT INTO `users` (`fullname`, `email`, `username`, `password`, `token`) VALUES ('$fullname', '$email', '$username', '$password', '$token')";
                            query($sql);

                            $_SESSION['msg'] = "Account created successfully";

                            // Redirect to the home page after successful signup
                            redirect('/');
                        }
                    }
                }
            }
        }
    }
}

// Active account
if (isset($_GET['action']) && $_GET['action'] == "active_account" && !empty($_GET['key']) && strlen($_GET['key']) == 50) {
    $user_token = check_input($_GET['key']);
    $sql = "SELECT * FROM `users` WHERE `token` = '$user_token'";
    $query = query($sql);

    if (mysqli_num_rows($query) > 0) {
        $update = "UPDATE `users` SET `status` = 1 WHERE `token` = '$user_token'";
        query($update);

        redirect('/login');
    }
}
