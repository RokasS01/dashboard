<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=dashboard;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

if (isset($_POST['signup'])) {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = hashPassword($_POST['password']);

    $checkUser = $pdo->prepare("SELECT * FROM `user` WHERE `email` = ?");
    $checkUser->execute([$email]);

    if ($checkUser->rowCount() == 0) {
        $insertUser = $pdo->prepare("INSERT INTO `user` (`pseudo`, `email`, `mdp`) VALUES (?, ?, ?)");
        $insertUser->execute([$pseudo, $email, $password]);
    
        $newUserId = $pdo->lastInsertId();
    
        $getPseudo = $pdo->prepare("SELECT `pseudo` FROM `user` WHERE `ID` = ?");
        $getPseudo->execute([$newUserId]);
        $userData = $getPseudo->fetch(PDO::FETCH_ASSOC);
    
        $_SESSION['user_id'] = $newUserId;
        $_SESSION['pseudo'] = $userData['pseudo'];
    
        $getCompte = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? ORDER BY ID ASC;");
        $getCompte->execute([$newUserId]);
        
        $comptesArray = array();
        
        while ($compte = $getCompte->fetch(PDO::FETCH_ASSOC)) {
            $comptesArray[] = $compte;
        }
        
        $_SESSION['comptes_array'] = $comptesArray;
        
    
        header('Location: ../index.php');
        exit;
    } else {
        echo "L'utilisateur existe déjà.";
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $getUser = $pdo->prepare("SELECT * FROM `user` WHERE `email` = ?");
    $getUser->execute([$email]);

    if ($getUser->rowCount() > 0) {
        $user = $getUser->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['mdp'])) {
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['pseudo'] = $user['pseudo'];

            $getCompte = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? ORDER BY ID ASC;");
            $getCompte->execute([$_SESSION['user_id']]);
            
            $comptesArray = array();
            
            while ($compte = $getCompte->fetch(PDO::FETCH_ASSOC)) {
                $comptesArray[] = $compte;
            }
            
            $_SESSION['comptes_array'] = $comptesArray;
            
            header('Location: ../index.php');
            exit;
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }
}


if(isset($_POST['confInac'])) {
    $update_user_id = $_SESSION['user_id'];
    $update_compte_id = $_POST['confInac'];

    $requete_confirmer = "UPDATE compte
                        SET etat = CASE
                            WHEN etat = 'Actif' THEN 'Inactif'
                            WHEN etat = 'Inactif' THEN 'Actif'
                            ELSE etat
                        END
                        WHERE user_id = :user_id
                        AND ID = :ID;";
    $execute_confirmer = $pdo->prepare($requete_confirmer);
    $execute_confirmer->execute(array('user_id' => $update_user_id,
                                    'ID' => $update_compte_id
    ));

    $getCompte = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? ORDER BY ID ASC;");
    $getCompte->execute([$update_user_id]);
    
    $comptesArray = array();
    
    while ($compte = $getCompte->fetch(PDO::FETCH_ASSOC)) {
        $comptesArray[] = $compte;
    }
    
    $_SESSION['comptes_array'] = $comptesArray;

    echo '<script>
        window.location.href = "../index.php";
    </script>';
}

if(isset($_POST['confSuppr'])) {
    $update_user_id = $_SESSION['user_id'];
    $update_compte_id = $_POST['confSuppr'];

    $requete_confirmer = "DELETE FROM `compte`
                        WHERE `user_id` = ?
                        AND `ID` = ?;";
    $execute_confirmer = $pdo->prepare($requete_confirmer);
    $execute_confirmer->execute([$update_user_id,$update_compte_id]);

    $getCompte = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? ORDER BY ID ASC;");
    $getCompte->execute([$update_user_id]);
    
    $comptesArray = array();
    
    while ($compte = $getCompte->fetch(PDO::FETCH_ASSOC)) {
        $comptesArray[] = $compte;
    }
    
    $_SESSION['comptes_array'] = $comptesArray;

    echo '<script> 
        window.location.href = "../index.php";
    </script>';
}

if(isset($_POST['nom_compte']) && isset($_POST['somme_depart'])) {
    $update_user_id = $_SESSION['user_id'];
    $nom_compte = $_POST["nom_compte"];
    $somme_depart = $_POST["somme_depart"];

    $requete_confirmer = "INSERT INTO `compte` (`user_id`, `etat`, `nom_compte`, `fonds`, `mois_preced`, `creation`)
                            VALUES (?, 'Actif', ?, ?, ?, NOW());";
    $execute_confirmer = $pdo->prepare($requete_confirmer);
    $execute_confirmer->execute([$update_user_id,$nom_compte,$somme_depart,$somme_depart]);

    $getCompte = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? ORDER BY ID ASC;");
    $getCompte->execute([$update_user_id]);
    
    $comptesArray = array();
    
    while ($compte = $getCompte->fetch(PDO::FETCH_ASSOC)) {
        $comptesArray[] = $compte;
    }
    
    $_SESSION['comptes_array'] = $comptesArray;

    echo '<script> 
        window.location.href = "../index.php";
    </script>';
}

if(isset($_POST['somme']) && isset($_POST['idcompte'])) {
    $update_user_id = $_SESSION['user_id'];
    $somme = $_POST["somme"];
    $idcompte = $_POST["idcompte"];

    $requete_confirmer = "UPDATE `compte`
                            SET `fonds` = fonds + ?
                            WHERE `user_id` = ?
                            AND `ID` = ?;";
    $execute_confirmer = $pdo->prepare($requete_confirmer);
    $execute_confirmer->execute([$somme,$update_user_id,$idcompte]);

    $getCompte = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? ORDER BY ID ASC;");
    $getCompte->execute([$update_user_id]);
    
    $comptesArray = array();
    
    while ($compte = $getCompte->fetch(PDO::FETCH_ASSOC)) {
        $comptesArray[] = $compte;
    }
    
    $_SESSION['comptes_array'] = $comptesArray;

    echo '<script> 
        window.location.href = "../index.php";
    </script>';
}

if(isset($_POST['confUpdate'])) {
    $update_user_id = $_SESSION['user_id'];

    $requete_confirmer = "UPDATE compte
                        SET mois_preced = fonds
                        WHERE user_id = :user_id;";
    $execute_confirmer = $pdo->prepare($requete_confirmer);
    $execute_confirmer->execute(array('user_id' => $update_user_id));

    $getCompte = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? ORDER BY ID ASC;");
    $getCompte->execute([$update_user_id]);
    
    $comptesArray = array();
    
    while ($compte = $getCompte->fetch(PDO::FETCH_ASSOC)) {
        $comptesArray[] = $compte;
    }
    
    $_SESSION['comptes_array'] = $comptesArray;

    echo '<script>
        window.location.href = "../index.php";
    </script>';
}

?>


