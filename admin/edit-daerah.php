<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM posts WHERE id = $id AND category_id = 19";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
    } else {
        header('location: ' . ROOT_URL . 'admin/manage-daerah.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'admin/manage-daerah.php');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Daerah Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-daerah-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title">
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
            </div>
            <button type="submit" name="submit" class="btn">Update Daerah Post</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
