<?php
include 'partials/header.php';

// Your query and fetch logic here
$query = "SELECT * FROM profiles ORDER BY id";
$result = mysqli_query($connection, $query);

$profiles = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $profiles[] = $row;
    }
}
?>

<section class="profile__system">
    <?php foreach ($profiles as $profile) : ?>
        <div class="ava">
            <div class="ava__img"><img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($profile['avatar']) ?>" alt="Profile Picture"></div>
            <h1><?= htmlspecialchars($profile['fullname']) ?></h1>
            <div class="ava__text"><?= htmlspecialchars($profile['position']) ?> from <strong><?= htmlspecialchars($profile['city']) ?>, <?= htmlspecialchars($profile['country']) ?></strong></div>
            <p><?= htmlspecialchars($profile['body']) ?></p>
        </div>
    <?php endforeach; ?>
</section>

<?php
include 'partials/footer.php';
?>
