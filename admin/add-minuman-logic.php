<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $harga = filter_var($_POST['harga'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = 20; // Category ID for Minuman
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to 0 if it's not checked
    $is_featured = $is_featured == 1 ?: 0;

    // validate form data
    if(!$title) {
        $_SESSION['add-minuman'] = "Please enter a title";
    } elseif(!$harga) {
        $_SESSION['add-minuman'] = "Please enter a harga";
    } elseif(!$body) {
        $_SESSION['add-minuman'] = "Please enter a body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-minuman'] = "Choose post thumbnail";
    } else {
        // WORK ON THUMBNAIL
        // rename the image
        $time = time(); // make each image name unique using current time
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)) {
            // make sure image is not too large (2mb+)
            if($thumbnail['size'] < 2_000_000) {
                // upload the image
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-minuman'] = "File size should be less than 2mb";
            }
        } else {
            $_SESSION['add-minuman'] = "File should be in png, jpg, or jpeg format.";
        }
    }

    // redirect back (with form data) to add-minuman page if there is any problem
    if(isset($_SESSION['add-minuman'])) {
         $_SESSION['add-minuman-data'] = $_POST;
         header('location: ' . ROOT_URL . 'admin/add-minuman.php');
         die();
    } else {
        // Insert post into database only if all fields are filled
        // set is_featured of all post to 0 if is_featured for this post is 1
        if($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // insert post into database
        $query = "INSERT INTO posts (title, harga, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$harga' , '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);

        if(!mysqli_errno($connection)) {
            $_SESSION['add-minuman-succes'] = "Minuman added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-minuman.php');
            die();
        }
    }
}

// Redirect to add-minuman.php if accessed directly without submitting the form
header('location: ' . ROOT_URL . 'admin/add-minuman.php');
