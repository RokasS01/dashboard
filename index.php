<?php 
    include 'php/header.php';
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../page/login.php');
    }

    function verifEtat($etat) {
        if ($etat === "Actif") {
            return 1;
        } else if ($etat === "Inactif"){
            return 0;
        }
    }

    function isIdValid($id) {
        if (isset($_SESSION['comptes_array'])) {
            $comptesArray = $_SESSION['comptes_array'];
            $premiersIDs = array();
    
            foreach ($comptesArray as $compte) {
                $currentID = $compte['ID'];
                if (count($premiersIDs) < 3) {
                    $premiersIDs[] = $currentID;
                    if ($id == $currentID) {
                        return true;
                    }
                }
            }
    
            return false;
        } else {
            return false;
        }
    }
?>

<head>
    <link rel="stylesheet" href="../css/index.css">
</head>

<section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-bitcoin-circle"></i>
                    <span class="text">Banque</span>
                </div>
            </div>
        </div>

        <div class="blocks">
        <?php 
            $getCompteCC = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? AND nom_compte = 'Compte Courant'");
            $getCompteCC->execute([$_SESSION['user_id']]);
            $affichage_cc = $getCompteCC->fetch(PDO::FETCH_ASSOC);
            $etatCC = $affichage_cc['etat'];
            $nomCC = $affichage_cc['nom_compte'];
            $fondsCC = $affichage_cc['fonds'];
            $moisCC = $affichage_cc['mois_preced'];
            $creaCC = $affichage_cc['creation'];
            $pourcentCC = round((($fondsCC - $moisCC) / $moisCC)*100,2); 

        ?>
            <div class="block compte">
                <h1><?php echo "$nomCC";?></h1>
                <h2 <?php echo "class= 'fondCCJS'"; ?>><?php echo "$fondsCC €";?></h2>
                <p><span class="<?php if ($pourcentCC > 0) { echo "pos"; } else if ($pourcentCC == 0) { echo "null"; } else { echo "neg"; } ?>"><?php echo "$pourcentCC %"; ?></span>&nbsp;depuis le mois dernier</p>
                <div class="wave"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#BB86FC" fill-opacity="1" d="M0,160L21.8,181.3C43.6,203,87,245,131,224C174.5,203,218,117,262,74.7C305.5,32,349,32,393,37.3C436.4,43,480,53,524,74.7C567.3,96,611,128,655,160C698.2,192,742,224,785,240C829.1,256,873,256,916,234.7C960,213,1004,171,1047,176C1090.9,181,1135,235,1178,256C1221.8,277,1265,267,1309,229.3C1352.7,192,1396,128,1418,96L1440,64L1440,320L1418.2,320C1396.4,320,1353,320,1309,320C1265.5,320,1222,320,1178,320C1134.5,320,1091,320,1047,320C1003.6,320,960,320,916,320C872.7,320,829,320,785,320C741.8,320,698,320,655,320C610.9,320,567,320,524,320C480,320,436,320,393,320C349.1,320,305,320,262,320C218.2,320,175,320,131,320C87.3,320,44,320,22,320L0,320Z"></path></svg></div>
            </div>
            <?php 
                $getCompteLA = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? AND nom_compte = 'Livret A'");
                $getCompteLA->execute([$_SESSION['user_id']]);
                $affichage_la = $getCompteLA->fetch(PDO::FETCH_ASSOC);
                $etatLA = $affichage_la['etat'];
                $nomLA = $affichage_la['nom_compte'];
                $fondsLA = $affichage_la['fonds'];
                $moisLA = $affichage_la['mois_preced'];
                $creaLA = $affichage_la['creation'];
                $pourcentLA = round((($fondsLA - $moisLA) / $moisLA)*100,2);
            ?>
            <div class="block livretA">
                <h1><?php echo "$nomLA";?></h1>
                <h2 <?php echo "class= 'fondLAJS'"; ?>><?php echo "$fondsLA €";?></h2>
                <p><span class="<?php if ($pourcentLA > 0) { echo "pos"; } else if ($pourcentLA == 0) { echo "null"; } else { echo "neg"; } ?>"><?php echo "$pourcentLA %"; ?></span>&nbsp;depuis le mois dernier</p>
                <div class="wave"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#03DAC5" fill-opacity="1" d="M0,0L21.8,42.7C43.6,85,87,171,131,197.3C174.5,224,218,192,262,197.3C305.5,203,349,245,393,218.7C436.4,192,480,96,524,85.3C567.3,75,611,149,655,176C698.2,203,742,181,785,192C829.1,203,873,245,916,229.3C960,213,1004,139,1047,138.7C1090.9,139,1135,213,1178,208C1221.8,203,1265,117,1309,101.3C1352.7,85,1396,139,1418,165.3L1440,192L1440,320L1418.2,320C1396.4,320,1353,320,1309,320C1265.5,320,1222,320,1178,320C1134.5,320,1091,320,1047,320C1003.6,320,960,320,916,320C872.7,320,829,320,785,320C741.8,320,698,320,655,320C610.9,320,567,320,524,320C480,320,436,320,393,320C349.1,320,305,320,262,320C218.2,320,175,320,131,320C87.3,320,44,320,22,320L0,320Z"></path></svg></div>
            </div>
            <?php 
                $getCompteLJ = $pdo->prepare("SELECT * FROM `compte` WHERE `user_id` = ? AND nom_compte = 'Livret Jeune'");
                $getCompteLJ->execute([$_SESSION['user_id']]);
                $affichage_lj = $getCompteLJ->fetch(PDO::FETCH_ASSOC);
                $etatLJ = $affichage_lj['etat'];
                $nomLJ = $affichage_lj['nom_compte'];
                $fondsLJ = $affichage_lj['fonds'];
                $moisLJ = $affichage_lj['mois_preced'];
                $creaLJ = $affichage_lj['creation'];
                $pourcentLJ = round((($fondsLJ - $moisLJ) / $moisLJ)*100,2);
            ?>
            <div class="block livretJeune">
                <h1><?php echo "$nomLJ";?></h1>
                <h2 <?php echo "class= 'fondLJJS'"; ?>><?php echo "$fondsLJ €";?></h2>
                <p><span class="<?php if ($pourcentLJ > 0) { echo "pos"; } else if ($pourcentLJ == 0) { echo "null"; } else { echo "neg"; } ?>"><?php echo "$pourcentLJ %"; ?></span>&nbsp;depuis le mois dernier</p>
                <div class="wave"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#448AFF" fill-opacity="1" d="M0,288L21.8,266.7C43.6,245,87,203,131,160C174.5,117,218,75,262,74.7C305.5,75,349,117,393,133.3C436.4,149,480,139,524,160C567.3,181,611,235,655,234.7C698.2,235,742,181,785,186.7C829.1,192,873,256,916,245.3C960,235,1004,149,1047,144C1090.9,139,1135,213,1178,245.3C1221.8,277,1265,267,1309,240C1352.7,213,1396,171,1418,149.3L1440,128L1440,320L1418.2,320C1396.4,320,1353,320,1309,320C1265.5,320,1222,320,1178,320C1134.5,320,1091,320,1047,320C1003.6,320,960,320,916,320C872.7,320,829,320,785,320C741.8,320,698,320,655,320C610.9,320,567,320,524,320C480,320,436,320,393,320C349.1,320,305,320,262,320C218.2,320,175,320,131,320C87.3,320,44,320,22,320L0,320Z"></path></svg></div>
            </div>
        </div>

        <div class="canvas">
            <div class="courbeCompte">
                <h1>Graphique</h1>
                <canvas id="myCourbe"></canvas>
            </div>

            <div class="donutCompte">
                <h1>Beignet</h1>
                <canvas id="myDonut"></canvas>
            </div>

            <div class="traitCompte">
                <h1>Bar</h1>
                <canvas id="myTrait"></canvas>
            </div>
        </div>
          

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-calculator-alt"></i>
                    <span class="text">Comptabilité</span>
                </div>
            </div>
        </div>

        <div class="create">
            <button class="openModalCreate"><i class="uil uil-plus"></i>Créer</button>
        </div>

        <div class="tableau">
            <div class="tableau-data">
            <div class="data inactif">
                <span class="data-title">Inactif</span>
                <?php
                    if (isset($_SESSION['comptes_array'])) {
                        $comptesArray = $_SESSION['comptes_array'];

                        foreach ($comptesArray as $compte) {
                            $etat = $compte['etat'];
                            $id = $compte['ID'];
                    ?>
                            <div data-id ="<?php echo $id; ?>" class="data-list <?php if (verifEtat($etat) == 0) { echo "in"; } else { echo "ac"; } ?> openModalInac"><button><?php if (verifEtat($etat) == 0) { echo "Inactif"; } else { echo "Actif"; } ?></button></div>
                    <?php
                        }
                    }
                ?>
            </div>
                <div class="data nom">
                    <span class="data-title">Nom</span>
                    <?php
                        if (isset($_SESSION['comptes_array'])) {
                            $comptesArray = $_SESSION['comptes_array'];

                            foreach ($comptesArray as $compte) {
                                $nom = $compte['nom_compte'];
                        ?>
                                <span class="data-list"><?php echo "$nom"; ?></span>
                        <?php
                            }
                        }
                    ?>
                </div>
                <div class="data fonds">
                    <span class="data-title">Fond</span>
                    <?php
                        if (isset($_SESSION['comptes_array'])) {
                            $comptesArray = $_SESSION['comptes_array'];

                            foreach ($comptesArray as $compte) {
                                $fonds = $compte['fonds'];
                        ?>
                                <span class="data-list"><?php echo "$fonds"; ?> €</span>
                        <?php
                            }
                        }
                    ?>
                </div>
                <div class="data pourcentage">
                    <span class="data-title">Pourcentage</span>


                    <?php
                        if (isset($_SESSION['comptes_array'])) {
                            $comptesArray = $_SESSION['comptes_array'];

                            foreach ($comptesArray as $compte) {
                                $fonds = $compte['fonds'];
                                $mois = $compte['mois_preced'];
                                $pourcent = round((($fonds - $mois) / $mois) * 100, 2);

                        ?>
                                <span class="data-list <?php if ($pourcent > 0) { echo "pos"; } else if ($pourcent == 0) { echo "null"; } else { echo "neg"; } ?>"> <?php echo "$pourcent %"; ?> </span>
                        <?php
                            }
                        }
                    ?>
                </div>
                <div class="data fonds">
                    <span class="data-title openMonth">Mois dernier <i class="uil uil-sync"></i></span>


                    <?php
                        if (isset($_SESSION['comptes_array'])) {
                            $comptesArray = $_SESSION['comptes_array'];

                            foreach ($comptesArray as $compte) {
                                $mois = $compte['mois_preced'];
                        ?>
                                <span class="data-list"> <?php echo "$mois"; ?> €</span>
                        <?php
                            }
                        }
                    ?>
                </div>
                <div class="data creation">
                    <span class="data-title">Création</span>
                    <?php
                        if (isset($_SESSION['comptes_array'])) {
                            $comptesArray = $_SESSION['comptes_array'];

                            foreach ($comptesArray as $compte) {
                                $crea = $compte['creation'];
                        ?>
                                <span class="data-list"><?php echo "$crea"; ?></span>
                        <?php
                            }
                        }
                    ?>
                </div>
                <div class="data ajouter">
                    <span class="data-title">Ajouter</span>
                    <?php
                        if (isset($_SESSION['comptes_array'])) {
                            $comptesArray = $_SESSION['comptes_array'];

                            foreach ($comptesArray as $compte) {
                                $id = $compte['ID'];
                        ?>
                                <div data-id ="<?php echo $id; ?>" class="data-list openModalAdd"><i class="uil uil-plus-circle"></i></div>
                        <?php
                            }
                        }
                    ?>
                </div>

                <div class="data supprimer">
                    <span class="data-title">Supprimer</span>
                    <?php
                        if (isset($_SESSION['comptes_array'])) {
                            $comptesArray = $_SESSION['comptes_array'];

                            foreach ($comptesArray as $compte) {
                                $id = $compte['ID'];
                        ?>
                                <div data-id ="<?php echo $id; ?>" class="data-list <?php if(isIdValid($id)) { echo "openModalSupprBlocked";} else {echo "openModalSuppr";} ?>"><i class="uil uil-trash-alt"></i></div>
                        <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>


        <div class="back" id="modal">

            <div class="page-inactif">
                <h1>Confirmez-vous le changement ?</h1>
                <p>Si vous confirmez, votre compte sera mis à jour automatiquement</p>
                <form class="button" action="../php/requete.php" method="post" >
                    <input type="hidden" name="confInac" value="" id="inputInac">
                    <button type="submit" class="confirmButton">Je confirme</button>
                    <button type="button" class="cancelButton">Annuler</button>
                </form>
            </div>

            <div class="page-update">
                <h1>Confirmez-vous le changement ?</h1>
                <p>Si vous confirmez, votre compte sera mis à jour automatiquement</p>
                <form class="button" action="../php/requete.php" method="post" >
                    <input type="hidden" name="confUpdate">
                    <button type="submit" class="confirmButton">Je confirme</button>
                    <button type="button" class="cancelButton">Annuler</button>
                </form>
            </div>

            <div class="page-suppr">
                <h1>Confirmez-vous la suppression ?</h1>
                <p>Si vous confirmez, votre compte sera définitivement effacé</p>
                <form class="button" action="../php/requete.php" method="post" >
                    <input type="hidden" name="confSuppr" value="" id="inputSuppr">
                    <button type="submit" class="confirmButton">Je confirme</button>
                    <button type="button" class="cancelButton">Annuler</button>
                </form>
            </div>
            
            <div class="page-ajouter">
                <h1>Ajout du nouveau mois</h1>
                <form class="button" action="../php/requete.php" method="post">
                    <div class="fusion">
                        <h2>Somme du mois</h2>
                        <div class="search-box">
                            <i class="uil uil-search"></i>
                            <input name="somme" type="text" placeholder="Somme de départ ici ...">
                            <input type="hidden" name="idcompte" value="" id="inputAdd">
                        </div>
                    </div>
                    <div class="button">
                        <button type="submit" class="confirmButton">Je confirme</button>
                        <button type="button" class="cancelButton">Annuler</button>
                    </div>
                </form>
            </div>

            <div class="page-argent">
                <h1>Ajout d'un nouveau compte</h1>
                <form action="../php/requete.php" method="post">
                    <h2>Nom du compte</h2>
                    <div class="search-box">
                        <i class="uil uil-search"></i>
                        <input name="nom_compte" id="nom_compte" type="text" placeholder="Nom du compte ici ..." required>
                    </div>
                    <h2>Somme de départ</h2>
                    <div class="search-box">
                        <i class="uil uil-search"></i>
                        <input name="somme_depart" id="somme_depart" type="text" placeholder="Somme de départ ici ..." required>
                    </div>
                    <div class="button">
                        <button type="submit" class="confirmButton">Je confirme</button>
                        <button type="button" class="cancelButton">Annuler</button>
                    </div>
                </form>
            </div>

        </div>



    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/script.js"></script>
<script src="../js/index.js"></script>
<script src="../js/popup.js"></script>

<script>

/*----------------------------------------------------*/

const PourColor = [
    '#BB86FC', '#03DAC5', '#448AFF', '#FFD700', '#32CD32',
    '#FF6347', '#8A2BE2', '#00FFFF', '#FFA500', '#808080',
    '#FF1493', '#00CED1', '#FF4500', '#800080', '#00FF00',
    '#FF00FF', '#008000', '#FFFF00', '#D2691E'
];

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function getMonthNames(startMonth) {
    const months = [];
    const date = new Date();
    
    for (let i = startMonth - 1; i < startMonth + 11; i++) {
        date.setMonth(i % 12);
        const monthName = new Intl.DateTimeFormat('fr-FR', { month: 'long' }).format(date);
        months.push(capitalizeFirstLetter(monthName));
    }
    return months;
}

const startingMonth = 2; // Par exemple, pour commencer par octobre, utilisez 10 pour octobre

const monthLabels = getMonthNames(startingMonth);

const dataCourbe = {
    labels: monthLabels,
    datasets: [

        <?php 
            
        if (isset($_SESSION['comptes_array'])) {
            $comptesArray = $_SESSION['comptes_array']; 
        
            foreach ($comptesArray as $compte) {
                $nomDuCompte = $compte['nom_compte'];
                $fondsDuCompte = $compte['fonds'];
                $moisDuCompte = $compte['mois_preced']; // Ajout du signe $ ici
                $indiceColor = count($comptesArray) - array_search($compte, $comptesArray) - 1; 
        ?>
                {
                    label: '<?php echo $nomDuCompte; ?> €',
                    data: [<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte + rand(-10, 10); ?>,<?php echo $moisDuCompte; ?>, <?php echo $fondsDuCompte; ?>],
                    borderColor: PourColor[<?php echo $indiceColor; ?>],
                    tension: 0.3,
                },

        <?php
            }
        }
        ?>
    ]
};






const optionsCourbe = {
    responsive: false,
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        y: {
            ticks: {
                callback: function(value) {
                    return value + ' €';
                },
                stepSize: 20, // Définit l'intervalle entre chaque graduation
                min: 0, // Définit la valeur minimale sur l'axe y
                max: 600 // Définit la valeur maximale sur l'axe y
            }
        }
    }
};


const courbe = document.getElementById('myCourbe');

new Chart(courbe, {
    type: 'line',
    data: dataCourbe,
    options: optionsCourbe
});

/*----------------------------------------------------*/

const donut = document.getElementById('myDonut');
const PourLabels = [];
const PourData = [];

<?php 
if (isset($_SESSION['comptes_array'])) {
    $comptesArray = $_SESSION['comptes_array'];

    foreach ($comptesArray as $compte) {
        $fondsJS = $compte['fonds'];
        $nomJSLabels = $compte['nom_compte'];
        $nomJS = str_replace(' ', '_', $compte['nom_compte']);
?>

        const <?php echo $nomJS;?> = <?php echo $fondsJS; ?>;

        PourLabels.push('<?php echo $nomJSLabels; ?>');
        PourData.push(<?php echo $nomJS; ?>);
<?php 
    }
}
?>

const dataDonut = {
    labels: PourLabels,
    datasets: [
        {
        label: 'Patrimoine € ',
        data: PourData,
        backgroundColor: PourColor,
        borderWidth: 1,
        tension: 0.2,
        }
    ]
};

const optionsDonut = {
    responsive: true,
    plugins: {
        legend: {
            display: false
        }
    },
};

new Chart(donut, {
    type: 'doughnut',
    data: dataDonut,
    options: optionsDonut
});

/*----------------------------------------------------*/

const trait = document.getElementById('myTrait');

const dataTrait = {
    labels: PourLabels,
    datasets: [
        {
        label: 'Patrimoine € ',
        data: PourData,
        backgroundColor: [
                '#BB86FC',
                '#03DAC5',
                '#448AFF',
                '#FFD700',
                '#32CD32',
                '#FF6347',
                '#8A2BE2',
                '#00FFFF',
                '#FFA500',
                '#808080',
                '#FF1493',
                '#00CED1',
                '#FF4500',
                '#800080',
                '#00FF00',
                '#FF00FF',
                '#008000',
                '#FFFF00',
                '#D2691E'
            ],
        borderWidth: 1,
        tension: 0.2,
        }
    ]
};

const optionsTrait = {
    responsive: true,
    scales: {
        x: {
            display: false, // Masque l'axe x
        },
        y: {
            ticks: {
                callback: function(value) {
                    return value + ' €';
                }
            }
        }
    },
    plugins: {
        legend: {
            display: false,
        },
    },
};

new Chart(trait, {
    type: 'bar',
    data: dataTrait,
    options: optionsTrait,
});

</script>

</html>