<?php
// On démarre une session
session_start();

// Est-ce que le NCLI existe et n'est pas vide dans l'URL
if(isset($_GET['NCLI']) && !empty($_GET['NCLI'])){
    require_once('connection.php');

    // On nettoie l'NCLI envoyé
    $NCLI = strip_tags($_GET['NCLI']);

    $sql = 'SELECT * FROM `client` WHERE `NCLI` = :NCLI;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (NCLI)
    $query->bindValue(':NCLI', $NCLI, PDO::PARAM_STR);

    // On exécute la requête
    $query->execute();


    //Inscription des changements dans les logs

    $fileDate = date('Y-m-d');
    $fileDate .= "Logs.txt";

    if(!file_exists($fileDate)){
        $file = fopen($fileDate, "w");
        fclose($file);
    }

    $file = $fileDate;

    //On récupère le fichier des logs et son contenu
    $fileContent = file_get_contents($file);

    //On récupère la date
    $date = date('H:i:s');
            
    //On ajoute l'action aux anciens logs
    $fileContent .= "\n[" . $date . "] : suppression du client : " . $NCLI;
            
    //On inscrits les nouveaux logs dans le fichier des logs.
    file_put_contents($file, $fileContent);
    


    // On récupère le produit
    $produit = $query->fetch();

    // On vérifie si le produit existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet NCLI n'existe pas";
        header('Location: index.php');
        die();
    }

    $sql = 'DELETE FROM `client` WHERE `NCLI` = :NCLI;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (NCLI)
    $query->bindValue(':NCLI', $NCLI, PDO::PARAM_STR);

    // On exécute la requête
    $query->execute();
    $_SESSION['message'] = "Client supprimé";
    header('Location: index.php');


}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}