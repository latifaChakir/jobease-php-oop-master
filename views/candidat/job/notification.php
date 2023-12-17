<?php
include('postuler.php');
session_start();

if (isset($_SESSION["id"])) {
    $user_id = $_SESSION["id"];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		JobEase
	</title>
	<link rel="stylesheet" href="../../../styles/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
		integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
		integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
		integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
		crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<header>


<nav class="navbar navbar-expand-md navbar-dark">
    <div class="container">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="#">
            <i class="fas fa-code"></i>
            <h1>JobEase &nbsp &nbsp</h1>
        </a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../../../public/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <?php if (isset($_SESSION['id'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="../views/candidat/job/notification.php">Notifications</a>
                    
                </li>
                <?php 
                }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        language
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">FR</a>
                        <a class="dropdown-item" href="#">EN</a>
                    </div>
                </li>
                <span class="nav-item active">
                    <a class="nav-link" href="#">EN</a>
                </span>
                <li class="nav-item">
                    <?php if (isset($_SESSION['id'])) { ?>
                        <a class="nav-link" href="../../auth/logout.php">Logout</a>
                    <?php } else { ?>
                        <a class="nav-link" href="../views/auth/login.php">Login</a>
                    <?php } ?>
                </li>

            </ul>
        </div>
    </div>
</nav>
</header>

<h3>
    <?php
    if (isset($_SESSION["username"])) {
        $user_name = $_SESSION["username"];
        echo "Hello " . $user_name;
    }
    ?>
</h3>


    <?php 
    $notifications = new Candidature($conn);
    $notificationsArray = $notifications->getNotificationsForUser($user_id);
    
    foreach ($notificationsArray as $notification) {
        echo '<div class="notification">';
        echo '<p>' . $notification['message'] . '</p>';
        echo '</div>';
    }
    ?>

<footer>
		<p>© 2023 JobEase </p>
	</footer>

    <style>
        .notification {
            border: 1px solid #4CAF50; 
            background-color: #DFF2BF; 
            color: #4CAF50; 
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px; 
        }
    </style>
</body>
</html>
