<?php
require 'config/database.php';

// Ensure the form was submitted
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_avatar_name = filter_var($_POST['previous_avatar_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $position = filter_var($_POST['position'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Validate input values
    if (!$fullname) {
        $_SESSION['edit-profile'] = "Edit profile was INVALID, Please enter a full name.";
    } elseif (!$position) {
        $_SESSION['edit-profile'] = "Edit profile was INVALID, Please enter a position.";
    } elseif (!$city) {
        $_SESSION['edit-profile'] = "Edit profile was INVALID, Please enter a city.";
    } elseif (!$country) {
        $_SESSION['edit-profile'] = "Edit profile was INVALID, Please enter a country.";
    } elseif (!$body) {
        $_SESSION['edit-profile'] = "Edit profile was INVALID, Please enter a body.";
    } else {
        // Handle avatar upload if a new file is provided
        if ($avatar['name']) {
            $previous_avatar_path = '../images/' . $previous_avatar_name;
            if (file_exists($previous_avatar_path)) {
                unlink($previous_avatar_path);
            }

            $time = time(); // Unique timestamp for the avatar name
            $avatar_name = $time . '_' . $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination_path = '../images/' . $avatar_name;

            // Validate avatar file type and size
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
            if (in_array($extension, $allowed_files)) {
                if ($avatar['size'] < 2_000_000) {
                    move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                } else {
                    $_SESSION['edit-profile'] = "File size too large. Should be less than 2MB.";
                }
            } else {
                $_SESSION['edit-profile'] = "File should be png, jpg, or jpeg.";
            }
        }

        // If no validation errors, proceed to update the profile
        if (!isset($_SESSION['edit-profile'])) {
            $avatar_to_insert = $avatar_name ?? $previous_avatar_name;
            $query = "UPDATE profiles SET fullname='$fullname', position='$position', city='$city', country='$country', body='$body', avatar='$avatar_to_insert' WHERE id=$id LIMIT 1";
            $result = mysqli_query($connection, $query);

            if (!mysqli_errno($connection)) {
                $_SESSION['edit-profile-succes'] = "Profile updated successfully.";
            }
        }
    }

    // Redirect back to the edit profile page if there was an error
    if (isset($_SESSION['edit-profile'])) {
        header('Location: ' . ROOT_URL . 'admin/edit-profile.php?id=' . $id);
        exit();
    } else {
        // Redirect to profile page on success
        header('Location: ' . ROOT_URL . 'admin/manage-profile.php');
        exit();
    }
} else {
    header('Location: ' . ROOT_URL . 'admin/');
    exit();
}
