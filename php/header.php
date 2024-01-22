<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/logo.jpg" type="image/jpg">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Dashboard - Mathys DC</title> 
</head>
<body>

<?php
    require_once 'requete.php';

    if (isset($_SESSION['user_id'])) {
        $pseudo = $_SESSION["pseudo"];
    }
?>

<nav>
    <div class="logo-name">
        <div class="logo-image">
            <img src="../assets/img/logo.jpg" alt="">
        </div>

        <span class="logo_name">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo $pseudo;
            } else {
                echo "DASHBOARD";
            }
            ?>
        </span>


    </div>

    <div class="menu-items">
        <ul class="nav-links">
            <li><a href="../index.php">
                <i class="uil uil-bitcoin-circle"></i>
                <span class="link-name">Banque</span>
            </a></li>
            <li><a href="#">
                <i class="uil uil-dumbbell"></i>
                <span class="link-name">Musculation</span>
            </a></li>
            <li><a href="#">
                <i class="uil uil-heart-medical"></i>
                <span class="link-name">Santé</span>
            </a></li>
            <li><a href="#">
                <i class="uil uil-clipboard-notes"></i>
                <span class="link-name">Tâches</span>
            </a></li>
            <li><a href="#">
                <i class="uil uil-english-to-chinese"></i>
                <span class="link-name">Portugais</span>
            </a></li>
        </ul>
        
        <?php
            $isLoggedIn = isset($_SESSION['user_id']);
            if (isset($_GET['logout']) && $_GET['logout'] == 1) {
                session_destroy();
                header('Location: ../page/login.php');
                exit;
            }
        ?>

        <ul class="logout-mode">
            <li>
                <a href="<?php echo ($isLoggedIn) ? '../page/login.php?logout=1' : '../page/login.php'; ?>">
                    <i class="uil <?php echo ($isLoggedIn) ? 'uil-signout' : 'uil-signin'; ?>"></i>
                    <span class="link-name"><?php echo ($isLoggedIn) ? 'Se déconnecter' : 'Se connecter'; ?></span>
                </a>
            </li>
            
            <li class="mode">
                <a href="#">
                    <i class="uil uil-moon"></i>
                    <span class="link-name">Thème nuit</span>
                </a>

                <div class="mode-toggle">
                    <span class="switch"></span>
                </div>
            </li>
        </ul>
    </div>
</nav>