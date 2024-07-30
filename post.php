<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT p.*, c.id as category_id FROM posts p JOIN categories c ON p.category_id = c.id WHERE p.id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);

    // Check if category ID is not 1, then don't display the price
    if ($post['category_id'] != 1 && $post['category_id'] != 20) {
        $post['harga'] = ""; // Set harga to empty if category is not ID 1
    } 
} else {
    header('Location: ' . ROOT_URL . 'index.php');
    die();
}
?>

<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?= $post['title'] ?></h2>
        <?php if (!empty($post['harga'])) : ?>
            <h3>Rp : <?= $post['harga'] ?></h3>
        <?php endif; ?>
        <div class="post__author">
            <?php
            $author_id = $post['author_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($connection, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            ?>
            <div class="post__author-avatar">
                <img src="./images/<?= $author['avatar'] ?>">
            </div>
            <div class="post__author-info">
                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="./images/<?= $post['thumbnail'] ?>">
        </div>
        <div class="post__content">
            <?= nl2br($post['body']) ?>
        </div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
