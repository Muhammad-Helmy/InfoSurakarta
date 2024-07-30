<?php
include 'partials/header.php';

// Fetch current user posts from database
// fetch users from database but not current user
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM profiles WHERE NOT id=$current_admin_id";
$profiles = mysqli_query($connection, $query);
?>

<section class="dashboard">
<?php if (isset($_SESSION['add-profile-succes'])) : // shows if profile was succesful 
        ?> 
        <div class="alert__massage succes container">
            <p>
                <?= $_SESSION['add-profile-succes'];
                unset($_SESSION['add-profile-succes']);
                ?>
            </p>
        </div>
<?php elseif (isset($_SESSION['edit-profile-succes'])) : // shows if edit profile was succesful 
        ?> 
        <div class="alert__massage succes container">
            <p>
                <?= $_SESSION['edit-profile-succes'];
                unset($_SESSION['edit-profile-succes']);
                ?>
            </p>
        </div>
<?php elseif (isset($_SESSION['edit-profile'])) : // shows if delete profile was succesful 
        ?> 
        <div class="alert__massage error container">
            <p>
                <?= $_SESSION['edit-profile'];
                unset($_SESSION['edit-profile']);
                ?>
            </p>
        </div>
<?php elseif (isset($_SESSION['delete-profile-succes'])) : // shows if edit profile was NOT succesful 
        ?> 
        <div class="alert__massage succes container">
            <p>
                <?= $_SESSION['delete-profile-succes'];
                unset($_SESSION['delete-profile-succes']);
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
                <?php if(isset($_SESSION['user_is_admin'])): ?>
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
                 <li><a href="manage-profile.php" class="active"><i class="uil uil-user-check"></i>
                        <h5>Manage Profile</h5>
                    </a>
                </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Profile</h2>
            <?php if (mysqli_num_rows($profiles) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Position</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($profile = mysqli_fetch_assoc($profiles)) : ?>
                    <tr>
                        <td><?= $profile['fullname'] ?></td>
                        <td><?= $profile['position'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-profile.php?id=<?= $profile['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-profile.php?id=<?= $profile['id'] ?>" class="btn sm danger">Delete</a></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert__massage error"><?= "No posts found" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
