<?php
include 'partials/header.php';

// fetch categories from database (if applicable)
$query = "SELECT * FROM profiles";
$categories = mysqli_query($connection, $query);

// get back form data if form was invalid
$fullname = $_SESSION['add-profile-data']['fullname'] ?? null;
$position = $_SESSION['add-profile-data']['position'] ?? null;
$city = $_SESSION['add-profile-data']['city'] ?? null;
$country = $_SESSION['add-profile-data']['country'] ?? null;
$body = $_SESSION['add-profile-data']['body'] ?? null;

// delete form data session
unset($_SESSION['add-profile-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Profile</h2>
        <?php if(isset($_SESSION['add-profile'])) : ?>
        <div class="alert__massage error">
            <p>
                <?= $_SESSION['add-profile']; 
                unset($_SESSION['add-profile']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-profile-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="fullname" value="<?= $fullname ?>" placeholder="Full Name">
            <input type="text" name="position" value="<?= $position ?>" placeholder="Position">
            <input type="text" name="city" value="<?= $city ?>" placeholder="City">
            <input type="text" name="country" value="<?= $country ?>" placeholder="Country">
            <textarea rows="10" name="body" placeholder="Body"><?= $body ?></textarea>
            <div class="form__control">
                <label for="avatar">Add Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Add Profile</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
