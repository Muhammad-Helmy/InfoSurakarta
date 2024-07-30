<?php
require 'config/database.php';

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch profile from database to delete avatar from images folder
    $query = "SELECT * FROM profiles WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $profile = mysqli_fetch_assoc($result);
    $avatar_name = $profile['avatar'];
    $avatar_path = '../images/' . $avatar_name;
    if($avatar_path) {
        unlink($avatar_path);
    }

    // delete profile from database
    $delete_profile_query = "DELETE FROM profiles WHERE id=$id LIMIT 1";
    $delete_profile_result = mysqli_query($connection, $delete_profile_query);
    if(mysqli_errno($connection)) {
        $_SESSION['delete-profile'] = "Couldn't delete '{$profile['fullname']}'";
    } else {
        $_SESSION['delete-profile-succes'] = "'{$profile['fullname']}' deleted successfully.";
    }
}

header('location: ' . ROOT_URL . 'admin/manage-profile.php');