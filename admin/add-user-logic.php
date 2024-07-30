<?php
require 'config/database.php';

// GET signup from data if signup button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    
    // validate input values
    if (!$firstname) {
        $_SESSION['add-user'] = "Please enter your First name!";
    } elseif (!$lastname) {
        $_SESSION['add-user'] = "Please enter your Last name!";
    } elseif (!$username) {
        $_SESSION['add-user'] = "Please enter your Username!";
    } elseif (!$email) {
        $_SESSION['add-user'] = "Please enter your Email!"; 
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = "Password should be 8+ characters!";
    } elseif ($createpassword !== $confirmpassword) {
        $_SESSION['add-user'] = "Passwords don't match!";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Please upload your avatar!";
    } else {
        // Check file type
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['add-user'] = "File type not allowed, it must be JPG, JPEG, or PNG only!";
        } elseif ($avatar['size'] > 1000000) { // 1MB
            $_SESSION['add-user'] = "File size too big! Should be less than 1MB";
        } else {
            // Proceed with file upload
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exist in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username or Email already exist!";
            } else {
                // Work on avatar
                // rename avatar
                $time = time(); // make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // upload avatar
                move_uploaded_file($avatar_tmp_name, $avatar_destination_path);

                // insert new user into users table
                $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=$is_admin";
                $insert_user_result = mysqli_query($connection, $insert_user_query);

                if (!mysqli_errno($connection)) {
                    // redirect to login page with succes message
                    $_SESSION['add-user-succes'] = "New user $firstname $lastname added successfully.";
                    header('location: '. ROOT_URL .  'admin/manage-users.php');
                    die();
                }
            }
        }
    }

    // redirect back to add-user page if there was any problem 
    if (isset($_SESSION['add-user'])) {
        // pass form data back to add-user page
        $_SESSION['add-user-data'] = $_POST;
        header('location: '.ROOT_URL . 'admin/add-user.php');
        die(); 
    }
} else {
    // if button wasn't clicked, bounce back to signup page
    header('location:' .ROOT_URL . 'admin/add-user.php');
    die();
}
