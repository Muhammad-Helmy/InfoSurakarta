<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    
    // set is_featured to 0 if it's not checked
    $is_featured = $is_featured == 1 ? 1 : 0;

    // validate form data
    if(!$title) {
        $_SESSION['edit-daerah'] = "Please enter a title";
    } elseif(!$body) {
        $_SESSION['edit-daerah'] = "Please enter a body";
    } else {
        // WORK ON THUMBNAIL
        if($thumbnail['name']) {
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
                    $_SESSION['edit-daerah'] = "File size should be less than 2mb";
                }
            } else {
                $_SESSION['edit-daerah'] = "File should be in png, jpg, or jpeg format.";
            }
        }
    }

    // redirect back (with form data) to edit-daerah page if there is any problem
    if(isset($_SESSION['edit-daerah'])) {
        header('location: ' . ROOT_URL . 'admin/edit-daerah.php?id=' . $id);
        die();
    } else {
        // set is_featured of all post to 0 if is_featured for this post is 1
        if($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // update post in the database
        $query = "UPDATE posts SET title='$title', body='$body', is_featured=$is_featured";
        if($thumbnail['name']) {
            $query .= ", thumbnail='$thumbnail_name'";
        }
        $query .= " WHERE id=$id AND category_id=19";
        $result = mysqli_query($connection, $query);

        if(!mysqli_errno($connection)) {
            $_SESSION['edit-daerah-succes'] = "Daerah post updated successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-daerah.php');
die();
