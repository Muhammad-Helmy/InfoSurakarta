<?php
include 'partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories WHERE id=1"; // Only fetch category with id=1
$categories = mysqli_query($connection, $query);

// get back form data if form was invalid
$title = $_SESSION['add-makanan-data']['title'] ?? null;
$harga = $_SESSION['add-makanan-data']['harga'] ?? null;
$body = $_SESSION['add-makanan-data']['body'] ?? null;

// delete form data session
unset($_SESSION['add-makanan-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Makanan</h2>
        <?php if(isset($_SESSION['add-makanan'])) : ?>
        <div class="alert__massage error">
            <p>
                <?= $_SESSION['add-makanan']; 
                unset($_SESSION['add-makanan']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-makanan-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
            <input type="text" name="harga" value="<?= $harga ?>" placeholder="Harga">
            <select name="category" disabled>
                <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                <option value="<?= $category['id']?>" selected><?= $category['title'] ?></option>
                <?php endwhile; ?>
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
