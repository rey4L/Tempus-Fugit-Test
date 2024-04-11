<?php
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $urlPath);
$currentPage = implode('/', array_slice($segments, 2));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=CSS_URL."main.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."navbar.css"?>>
    <style>
        .navigation-bar .nav-button.active {
            background-color: white;
            color: black;
        }
    </style>
    <title>Navigation Bar</title>
</head>

<body>
    <div class="navigation-bar">
        <div class="profile-info-container">
            <?php if (isset($_SESSION['employee_image_url'])) : ?>
                <img class="profile-picture" src="<?=RESOURCE_URL . $_SESSION['employee_image_url']?>" alt="Profile Picture">
            <?php else: ?>
                <img class="profile-picture" src="<?=RESOURCE_URL . "default_profile.png"?>" alt="Default Profile Picture">
            <?php endif; ?>

            <div class="profile-details">
                <?php if (isset($_SESSION['employee_name'])) : ?>
                    <p class="profile-username"><?=$_SESSION['employee_name']?></p>
                <?php else: ?>
                    <p class="profile-username">USERNAME HERE</p>
                <?php endif; ?>

                <form action="<?=BASE_URL."/user/logout"?>">
                    <button type="submit">Log Out</button>
                </form>
            </div>
        </div>
        
        <!-- Single .navigation-bar div -->
        <a class="nav-button <?= stripos($currentPage, 'Register') !== false ? 'active' : '' ?>" href="<?= BASE_URL."/Register"?>">Register</a> 
        <a class="nav-button <?= stripos($currentPage, 'MenuItem') !== false ? 'active' : '' ?>" href="<?= BASE_URL."/MenuItem" ?>">Menu</a>
        <a class="nav-button <?= stripos($currentPage, 'Employee') !== false ? 'active' : '' ?>" href="<?= BASE_URL."/Employee" ?>">Employees</a> 
        <a class="nav-button <?= stripos($currentPage, 'Bill') !== false ? 'active' : '' ?>" href="<?= BASE_URL."/Bill" ?>">Bills</a>
    </div>
</body>
</html>
