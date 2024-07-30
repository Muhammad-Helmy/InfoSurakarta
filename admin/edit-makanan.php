<?php
include 'partials/header.php';

// get edit post data
if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id AND category_id=1";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
    } else {
        header('location: ' . ROOT_URL . 'admin/manage-makanan.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/manage-makanan.php');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Makanan</h2>
        <form action="<?= ROOT_URL ?>admin/edit-makanan-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title">
            <input type="text" name="harga" value="<?= $post['harga'] ?>" placeholder="Harga">            
            <textarea rows="10" name="body" placeholder="Body"><?= $post['body'] ?></textarea>
            <?php if(isset($_SESSION['user_is_admin'])) : ?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" <?= $post['is_featured'] ? 'checked' : '' ?>>
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>
            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
                <!-- Add a hidden input field to store the existing thumbnail name -->
                <input type="hidden" name="existing_thumbnail" value="<?= $post['thumbnail'] ?>">
            </div>
            <button type="submit" name="submit" class="btn">Update Makanan</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
