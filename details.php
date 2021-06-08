<?php
// On démarre une session
session_start();

// Est-ce que le NCLI existe et n'est pas vide dans l'URL
if(isset($_GET['NCLI']) && !empty($_GET['NCLI'])){
    require_once('connection.php');

    // On nettoie le NCLI envoyé
    $NCLI = strip_tags($_GET['NCLI']);

    $sql = 'SELECT * FROM `client` WHERE `NCLI` = :NCLI;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (NCLI)
    $query->bindValue(':NCLI', $NCLI, PDO::PARAM_STR);

    // On exécute la requête
    $query->execute();


    // On vérifie si le client existe
    if(!$client){
        $_SESSION['erreur'] = "Cet NCLI n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du profile client</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Numéro client: <?= $client['NCLI'] ?></h1>
                <p>Nom: <?= $client['NOM'] ?></p>
                <p>Adresse : <?= $client['ADRESSE'] ?></p>
                <p>Ville : <?= $client['LOCALITE'] ?></p>
                <p>Catégorie : <?= $client['CAT'] ?></p>
                <p>Solde du compte : <?= $client['COMPTE'] ?></p>
                <p><a href="index.php">Retour</a> <a href="edit.php?NCLI=<?= $client['NCLI'] ?>">Modifier</a></p>
            </section>
        </div>
    </main>
</body>
</html>