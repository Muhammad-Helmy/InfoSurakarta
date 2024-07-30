<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $position = filter_var($_POST['position'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // validate form data
    if(!$fullname) {
        $_SESSION['add-profile'] = "Please enter a full name";
    } elseif(!$position) {
        $_SESSION['add-profile'] = "Please enter a position";
    } elseif(!$city) {
        $_SESSION['add-profile'] = "Please enter a city";
    } elseif(!$country) {
        $_SESSION['add-profile'] = "Please enter a country";
    } elseif(!$body) {
        $_SESSION['add-profile'] = "Please enter a body";
    } elseif (!$avatar['name']) {
        $_SESSION['add-profile'] = "Choose an avatar";
    } else {
        // WORK ON AVATAR
        // rename the image
        $time = time(); // make each image name unique using current time
        $avatar_name = $time . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = '../images/' . $avatar_name;

        // make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)) {
            // make sure image is not too large (2mb+)
            if($avatar['size'] < 2_000_000) {
                // upload the image
                move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
            } else {
                $_SESSION['add-profile'] = "File size should be less than 2mb";
            }
        } else {
            $_SESSION['add-profile'] = "File should be in png, jpg, or jpeg format.";
        }
    }

    // redirect back (with form data) to add-profile page if there is any problem
    if(isset($_SESSION['add-profile'])) {
         $_SESSION['add-profile-data'] = $_POST;
         header('location: ' . ROOT_URL . 'admin/add-profile.php');
         die();
    } else {
        // insert profile into database
        $query = "INSERT INTO profiles (fullname, position, city, country, body, avatar) VALUES ('$fullname', '$position', '$city', '$country', '$body', '$avatar_name')";
        $result = mysqli_query($connection, $query);

        if(!mysqli_errno($connection)) {
            $_SESSION['add-profile-succes'] = "Profile added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-profile.php');
            die();
        }
    }
}

header('location: ' . ROOT_URL . 'admin/add-profile.php');

