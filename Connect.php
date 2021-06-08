<?php
include_once "Constantes.php"; // inclut le fichier constantes

//fonction de connexion
 function ConnexionServ()
 {
                
    //script de connexion 
    $dsn=SERVEUR.";dbname=".BASE;

    echo $dsn;
            
    //connexion à la base de données
    try
    {
        $connexion=new PDO($dsn,USER,MDP);
        $connexion->exec("set names utf8");
    }
            
       //affichage en cas d'erreur
    catch(PDOExecption $e)
    {
        printf("Echec de la connexion : %s\n", $e->getMessage());
        exit();
    }
            
    //retourne de la connexion
    return $connexion;
}

//fonction deconnexion
function DecoServ()
{
    $dsn = null;
}
?>
