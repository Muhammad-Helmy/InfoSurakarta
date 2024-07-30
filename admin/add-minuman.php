<?php
include 'partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories WHERE id = 20";
$categories = mysqli_query($connection, $query);

// get back form data if form was invalid
$title = $_SESSION['add-minuman-data']['title'] ?? null;
$harga = $_SESSION['add-makanan-data']['harga'] ?? null;
$body = $_SESSION['add-minuman-data']['body'] ?? null;

// delete form data session
unset($_SESSION['add-minuman-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Minuman</h2>
        <?php if(isset($_SESSION['add-minuman'])) : ?>
        <div class="alert__massage error">
            <p>
                <?= $_SESSION['add-minuman']; 
                unset($_SESSION['add-minuman']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-minuman-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
            <input type="text" name="harga" value="<?= $harga ?>" placeholder="Harga">
            <select name="category" hidden>
                <option value="20">Makanan</option>
            </select>
            <textarea rows="10" name="body" placeholder="Body"><?= $body ?></textarea>
            <?php if(isset($_SESSION['user_is_admin'])) : ?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>
            <div class="form__control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Add Makanan</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
