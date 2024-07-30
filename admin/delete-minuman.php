<?php
require 'config/database.php';

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch post from database to delete thumbnail from images folder
    $query = "SELECT * FROM posts WHERE id=$id AND category_id=20";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) == 1) {
        $thumbnail_path = '../images/' . $post['thumbnail'];
        if(file_exists($thumbnail_path)) {
            unlink($thumbnail_path);
        }

        // delete post from database
        $delete_post_query = "DELETE FROM posts WHERE id=$id AND category_id=20";
        $delete_post_result = mysqli_query($connection, $delete_post_query);
        if(!mysqli_errno($connection)) {
            $_SESSION['delete-minuman-success'] = "Makanan deleted successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-minuman.php');
?>
