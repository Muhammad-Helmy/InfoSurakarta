<?php
include 'partials/header.php';
// Fetch current user posts from the database
$current_user_id = $_SESSION['user-id'];
$query = "SELECT id, title, category_id FROM posts WHERE author_id = $current_user_id AND category_id = 20 ORDER BY id DESC";
$posts = mysqli_query($connection, $query);
?>

<section class="dashboard">
<?php if (isset($_SESSION['add-minuman-succes'])) : // shows if post was succesful 
        ?> 
        <div class="alert__messagmassage succes container">
            <p>
                <?= $_SESSION['add-minuman-succes'];
                unset($_SESSION['add-minuman-succes']);
                ?>
            </p>
        </div>
<?php elseif (isset($_SESSION['edit-minuman-succes'])) : // shows if edit post was succesful 
        ?> 
        <div class="alert__massage succes container">
            <p>
                <?= $_SESSION['edit-minuman-succes'];
                unset($_SESSION['edit-minuman-succes']);
                ?>
            </p>
        </div>
<?php elseif (isset($_SESSION['edit-minuman'])) : // shows if delete post was succesful 
        ?> 
        <div class="alert__massage error container">
            <p>
                <?= $_SESSION['edit-minuman'];
                unset($_SESSION['edit-minuman']);
                ?>
            </p>
        </div>
<?php elseif (isset($_SESSION['delete-minuman-succes'])) : // shows if edit post was NOT succesful 
        ?> 
        <div class="alert__massage succes container">
            <p>
                <?= $_SESSION['delete-minuman-succes'];
                unset($_SESSION['delete-minuman-succes']);
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
                <li><a href="index.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>
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
                <li><a href="manage-makanan.php" ><i class="uil uil-utensils-alt"></i>
                        <h5>Manage Makanan</h5>
                    </a>
                </li>
                <li><a href="add-minuman.php"><i class="uil uil-glass-tea"></i>
                        <h5>Add Minuman</h5>
                    </a>
                </li>
                <li><a href="manage-minuman.php" class="active"><i class="uil uil-coffee"></i>
                        <h5>Manage Minuman</h5>
                    </a>
                </li>
            </ul>
        </aside>
        <main>
            <h2>Manage Makanan</h2>
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
                    <?php
                        // fetch category from categories table using category_id of the post
                        $category_id = $post['category_id'];
                        $category_query = "SELECT title FROM categories WHERE id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                    ?>
                    <tr>
                        <td><?= $post['title'] ?></td>
                        <td><?= $category['title'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-minuman.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-minuman.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert__massage error"><?= "No Makanan found" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>
<?php
include '../partials/footer.php';
?>
