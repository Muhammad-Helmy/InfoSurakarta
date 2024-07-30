<?php
include 'partials/header.php';

// Fetch posts from the database
$current_user_id = $_SESSION['user-id'];

// Check if the user is admin
if (isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] == 1) {
    $query = "SELECT posts.id, posts.title, posts.category_id, categories.title as category_title 
              FROM posts 
              JOIN categories ON posts.category_id = categories.id 
              ORDER BY posts.id DESC";
} else {
    $query = "SELECT posts.id, posts.title, posts.category_id, categories.title as category_title 
              FROM posts 
              JOIN categories ON posts.category_id = categories.id 
              WHERE posts.author_id = $current_user_id 
              ORDER BY posts.id DESC";
}

$posts = mysqli_query($connection, $query);
?>

<section class="dashboard">
    <?php if (isset($_SESSION['add-post-succes'])) : ?>
        <div class="alert__massage succes container">
            <p>
                <?= $_SESSION['add-post-succes'];
                unset($_SESSION['add-post-succes']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-succes'])) : ?>
        <div class="alert__massage succes container">
            <p>
                <?= $_SESSION['edit-post-succes'];
                unset($_SESSION['edit-post-succes']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])) : ?>
        <div class="alert__massage error container">
            <p>
                <?= $_SESSION['edit-post'];
                unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-succes'])) : ?>
        <div class="alert__massage succes container">
            <p>
                <?= $_SESSION['delete-post-succes'];
                unset($_SESSION['delete-post-succes']);
                ?>
            </p>
        </div>
    <?php endif ?>

    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li><a href="add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Posts</h5>
                    </a>
                </li>
                <li><a href="index.php" class="active"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>
                <?php if (!isset($_SESSION['user_is_admin'])): ?>
                    <li><a href="add-daerah.php"><i class="uil uil-info-circle"></i>
                            <h5>Add Daerah</h5>
                        </a>
                    </li>
                    <li><a href="manage-daerah.php"><i class="uil uil-document-info"></i>
                            <h5>Manage Daerah</h5>
                        </a>
                    </li>
                    <li><a href="add-makanan.php"><i class="uil uil-utensils"></i>
                            <h5>Add Makanan</h5>
                        </a>
                    </li>
                    <li><a href="manage-makanan.php"><i class="uil uil-utensils-alt"></i>
                            <h5>Manage Makanan</h5>
                        </a>
                    </li>
                    <li><a href="add-minuman.php"><i class="uil uil-glass-tea"></i>
                            <h5>Add Minuman</h5>
                        </a>
                    </li>
                    <li><a href="manage-minuman.php"><i class="uil uil-coffee"></i>
                            <h5>Manage Minuman</h5>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_is_admin'])): ?>
                    <li><a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li><a href="manage-users.php"><i class="uil uil-user-md"></i>
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li><a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li><a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                    <li><a href="add-profile.php"><i class="uil uil-user-arrows"></i>
                            <h5>Add Profile</h5>
                        </a>
                    </li>
                    <li><a href="manage-profile.php"><i class="uil uil-user-check"></i>
                            <h5>Manage Profile</h5>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Post</h2>
            <?php if (mysqli_num_rows($posts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $post['category_title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id']?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id']?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__massage error lg"><?= "No posts found" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
