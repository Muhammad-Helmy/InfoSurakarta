<?php
require './config/database.php';

// fetch current user from database 
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="web-icon" href="<?= ROOT_URL ?>images/Logo_solo.png">
    <title>Info Surakarta | Fakta Menarik Surakarta</title>
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL; ?>css/style.css">
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- GOOGLE FONT (MONSERRAT)-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body>
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL; ?>" class="nav__logo">INFO SURAKARTA</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL; ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL; ?>category-posts.php?id=19">Daerah</a></li>
                <li><a href="<?= ROOT_URL ?>category-posts.php?id=1">Makanan</a></li>
                <li><a href="<?= ROOT_URL; ?>category-posts.php?id=20">Minuman</a></li>
                <li><a href="<?= ROOT_URL; ?>profile.php">Profile</a></li>
                <li><a href="<?= ROOT_URL; ?>contact.php">Contact</a></li>
                <div class="avastop">
                <?php if (isset($_SESSION['user-id'])) : ?>
                    <li class="nav__profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL; ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Log-out</a></li>
                        </ul>
                    </li>
                <?php ?>
                    <li><a href="<?= ROOT_URL; ?>signin.php" class="signin">Sign-in</a></li>
                <?php endif ?>
                </div>
            </ul>

            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!--========== END OF NAV ==========-->