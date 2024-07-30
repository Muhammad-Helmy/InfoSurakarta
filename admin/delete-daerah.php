<?php
require 'config/database.php';

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch post from database in order to delete thumbnail from images folder
    $query = "SELECT * FROM posts WHERE id=$id AND category_id=19";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
        $thumbnail_path = '../images/' . $post['thumbnail'];
        if($thumbnail_path) {
            unlink($thumbnail_path); // delete thumbnail from images folder if it exists
        }

        // delete post from database
        $delete_post_query = "DELETE FROM posts WHERE id=$id AND category_id=19";
        $delete_post_result = mysqli_query($connection, $delete_post_query);

        if(!mysqli_errno($connection)) {
            $_SESSION['delete-daerah-succes'] = "Daerah post deleted successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-daerah.php');
die();
