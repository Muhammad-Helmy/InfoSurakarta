<?php
include 'partials/header.php';

// fetch post data if id is set
if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id AND category_id=20";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/manage-minuman.php');
    die();
}

// get back form data if form was invalid
$title = $_SESSION['edit-minuman-data']['title'] ?? $post['title'];
$body = $_SESSION['edit-minuman-data']['body'] ?? $post['body'];

// delete form data session
unset($_SESSION['edit-minuman-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Makanan</h2>
        <form action="<?= ROOT_URL ?>admin/edit-minuman-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
            <input type="text" name="harga" value="<?= $post['harga'] ?>" placeholder="Harga">            
            <textarea rows="10" name="body" placeholder="Body"><?= $body ?></textarea>
            <?php if(isset($_SESSION['user_is_admin'])) : ?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" <?= $post['is_featured'] ? 'checked' : '' ?>>
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>
            <div class="form__control">
                <label for="thumbnail">Change Thumbnail (optional)</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Update Makanan</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
