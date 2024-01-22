<?php 
    include '../php/header.php';
?>

<head>
    <link rel="stylesheet" href="../css/login.css">
</head>

<section class="dashboard">
    <section class="wrapper">
        <div class="form signup">
            <header style="color: #fff;">Inscription</header>
            <form action="../php/requete.php" method="post">
                <input type="text" name="pseudo" placeholder="Pseudo" required />
                <input type="text" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Mot de passe" required />
                <input type="submit" name="signup" value="S'inscrire" />
            </form>
        </div>

        <div class="form login">
            <header>Se connecter</header>
            <form action="../php/requete.php" method="post">
                <input type="text" name="loginEmail" placeholder="Email" required />
                <input type="password" name="loginPassword" placeholder="Mot de passe" required />
                <input type="submit" name="login" value="Se connecter" />
            </form>
        </div>
    </section>
</section>


<?php if (isset($_GET['success'])): ?>
    <script>
        alert("Connexion/inscription réussie !");
    </script>
<?php endif; ?>

<script>
    const wrapper = document.querySelector(".wrapper"),
    signupHeader = document.querySelector(".signup header"),
    loginHeader = document.querySelector(".login header");

    loginHeader.addEventListener("click", () => {
        wrapper.classList.add("active");
    });
    signupHeader.addEventListener("click", () => {
        wrapper.classList.remove("active");
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/script.js"></script>

