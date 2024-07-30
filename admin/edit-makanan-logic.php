<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $harga = filter_var($_POST['harga'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    $existing_thumbnail = $_POST['existing_thumbnail']; // Retrieve the existing thumbnail name

    // set is_featured to 0 if it's not checked
    $is_featured = $is_featured == 1 ? 1 : 0;

    // validate form data
    if(!$title) {
        $_SESSION['edit-makanan'] = "Title is MISSING";
    } elseif(!$harga) {
        $_SESSION['edit-makanan'] = "Harga is MISSING";
    } elseif(!$body) {
        $_SESSION['edit-makanan'] = "Body is MISSING";
    } else {
        if ($thumbnail['name']) {
            // WORK ON THUMBNAIL
            // rename the image
            $time = time(); // make each image name unique using current time
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
            if(in_array($extension, $allowed_files)) {
                // make sure image is not too large (2mb+)
                if($thumbnail['size'] < 2_000_000) {
                    // upload the image
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);

                    // remove old thumbnail if a new one is uploaded
                    if ($existing_thumbnail) {
                        unlink('../images/' . $existing_thumbnail); // Unlink the existing thumbnail
                    }
                } else {
                    $_SESSION['edit-makanan'] = "File size should be less than 2mb";
                }
            } else {
                $_SESSION['edit-makanan'] = "File should be in png, jpg, or jpeg format.";
            }
        } else {
            $thumbnail_name = $existing_thumbnail; // Use the existing thumbnail name if no new thumbnail is uploaded
        }

        // redirect back (with form data) to edit-makanan page if there is any problem
        if(isset($_SESSION['edit-makanan'])) {
             header('location: ' . ROOT_URL . 'admin/edit-makanan.php?id=' . $id);
             die();
        } else {
            // set is_featured of all post to 0 if is_featured for this post is 1
            if($is_featured == 1) {
                $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
                $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
            }

            // update post in database
            $query = "UPDATE posts SET title='$title', harga='$harga' , body='$body', thumbnail='$thumbnail_name', is_featured=$is_featured WHERE id=$id AND category_id=1";
            $result = mysqli_query($connection, $query);

            if(!mysqli_errno($connection)) {
                $_SESSION['edit-makanan-succes'] = "Makanan updated successfully";
                header('location: ' . ROOT_URL . 'admin/manage-makanan.php');
                die();
            }
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-makanan.php');
?>
