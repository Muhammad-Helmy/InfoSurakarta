<?php
include 'partials/header.php';

// fetch profiles from database (if applicable)
$profile_query = "SELECT * FROM profiles";
$profile = mysqli_query($connection, $profile_query);

// fetch profiles from database
if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM profiles WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $profile = mysqli_fetch_assoc($result);
} else {
    header('location:'. ROOT_URL. 'admin/');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Profile</h2>
        <form action="<?= ROOT_URL ?>admin/edit-profile-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $profile['id'] ?>">
            <input type="hidden" name="previous_avatar_name" value="<?= $profile['avatar'] ?>">
            <input type="text" name="fullname" value="<?= $profile['fullname'] ?>" placeholder="Full Name">
            <input type="text" name="position" value="<?= $profile['position'] ?>" placeholder="Position">
            <input type="text" name="city" value="<?= $profile['city'] ?>" placeholder="City">
            <input type="text" name="country" value="<?= $profile['country'] ?>" placeholder="Country">
            <textarea rows="10" name="body" placeholder="Body"><?= $profile['body'] ?></textarea>
            <div class="form__control">
                <label for="avatar">Change Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Update Profile</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
