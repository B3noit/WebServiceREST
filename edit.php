<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['NCLI']) && !empty($_POST['NCLI'])
    && isset($_POST['NOM']) && !empty($_POST['NOM'])
    && isset($_POST['ADRESSE']) && !empty($_POST['ADRESSE'])
    && isset($_POST['LOCALITE']) && !empty($_POST['LOCALITE'])
    && isset($_POST['CAT']) && !empty($_POST['CAT'])
    && isset($_POST['COMPTE']) && !empty($_POST['COMPTE'])){

        // On inclut la connexion à la base
        require_once('connection.php');

        // On nettoie les données envoyées
        $NCLI = strip_tags($_POST['NCLI']);
        $NOM = strip_tags($_POST['NOM']);
        $ADRESSE = strip_tags($_POST['ADRESSE']);
        $LOCALITE = strip_tags($_POST['LOCALITE']);
        $CAT = strip_tags($_POST['CAT']);
        $COMPTE = strip_tags($_POST['COMPTE']);

        $sql = 'UPDATE `client` SET `NOM`=:NOM, `ADRESSE`=:ADRESSE, `LOCALITE`=:LOCALITE, `CAT`=:CAT, `COMPTE`=:COMPTE, WHERE `NCLI`=:NCLI;';

        $query = $db->prepare($sql);

        $query->bindValue(':NCLI', $NCLI, PDO::PARAM_STR);
        $query->bindValue(':NOM', $NOM, PDO::PARAM_STR);
        $query->bindValue(':ADRESSE', $ADRESSE, PDO::PARAM_STR);
        $query->bindValue(':LOCALITE', $LOCALITE, PDO::PARAM_STR);
        $query->bindValue(':CAT', $CAT, PDO::PARAM_STR);
		$query->bindValue(':COMPTE', $COMPTE, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Profile client modifié";
        require_once('Close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}


// Est-ce que l'id existe et n'est pas vide dans l'URL
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

    //On récupère le fichier des logs et son contenu
    $file = file_get_contents('logs.txt');

    //On récupère la date
    $date = date('H:i:s');
            
    //On ajoute l'action aux anciens logs
    $file .= "\n[" . $date . "] : modification du client : " . $NCLI;
            
    //On inscrits les nouveaux logs dans le fichier des logs.
    file_put_contents('logs.txt', $file);

    // On récupère le client
    $client = $query->fetch();
    // On récupère le client
    $client = $query->fetch();

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
    <title>Modifier un profile client</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>Modifier un profile client</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="NCLI">NCLI</label>
                        <input type="text" NCLI="NCLI" name="NCLI" class="form-control" value="<?= $client['NCLI']?>">
                    </div>
                    <div class="form-group">
                        <label for="NOM">NOM</label>
                        <input type="text" NCLI="NOM" name="NOM" class="form-control" value="<?= $client['NOM']?>">

                    </div>
                    <div class="form-group">
                        <label for="ADRESSE">ADRESSE</label>
                        <input type="text" NCLI="ADRESSE" name="ADRESSE" class="form-control" value="<?= $client['ADRESSE']?>">
                    </div>
                    <div class="form-group">
                        <label for="LOCALITE">LOCALITE</label>
                        <input type="text" NCLI="LOCALITE" name="LOCALITE" class="form-control" value="<?= $client['LOCALITE']?>">
                    </div>
                    <div class="form-group">
                        <label for="CAT">CAT</label>
                        <input type="text" NCLI="CAT" name="CAT" class="form-control" value="<?= $client['CAT']?>">
                    </div>
                    <div class="form-group">
                        <label for="COMPTE">COMPTE</label>
                        <input type="number" NCLI="COMPTE" name="COMPTE" class="form-control" value="<?= $client['COMPTE']?>">
                    </div>
                    <input type="hidden" value="<?= $client['NCLI']?>" name="NCLI">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>