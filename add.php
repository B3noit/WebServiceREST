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

        $sql = 'INSERT INTO `client` (`NCLI`, `NOM`, `ADRESSE`, `LOCALITE`, `CAT`, `COMPTE`) VALUES (:NCLI, :NOM, :ADRESSE, :LOCALITE, :CAT, :COMPTE);';

        $query = $db->prepare($sql);

        $query->bindValue(':NCLI', $NCLI, PDO::PARAM_STR);
        $query->bindValue(':NOM', $NOM, PDO::PARAM_STR);
        $query->bindValue(':ADRESSE', $ADRESSE, PDO::PARAM_STR);
        $query->bindValue(':LOCALITE', $LOCALITE, PDO::PARAM_STR);
        $query->bindValue(':CAT', $CAT, PDO::PARAM_STR);
		$query->bindValue(':COMPTE', $COMPTE, PDO::PARAM_INT);


        $query->execute();

        //On récupère le fichier des logs et son contenu
    	$file = file_get_contents('logs.txt');

    	//On récupère la date
    	$date = date('H:i:s');
            
    	//On ajoute l'action aux anciens logs
    	$file .= "\n[" . $date . "] : ajout du client : " . $NCLI;
            
    	//On inscrits les nouveaux logs dans le fichier des logs.
    	file_put_contents('logs.txt', $file);

        $_SESSION['message'] = "Client ajouté";
        require_once('Close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajouter un client</title>
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
				<h1>Ajouter un client</h1>
				<form method="post">
					<div class="form-group">
						<label for="client">NCLI</label>
						<input type="text" id="NCLI" name="NCLI" class="form-control">
					</div>
					<div class="form-group">
						<label for="client">NOM</label>
						<input type="text" id="NOM" name="NOM" class="form-control">
					</div>
					<div class="form-group">
						<label for="client">ADRESSE</label>
						<input type="text" id="ADRESSE" name="ADRESSE" class="form-control">
					</div>
					<div class="form-group">
						<label for="client">LOCALITE</label>
						<input type="text" id="LOCALITE" name="LOCALITE" class="form-control">
					</div>
					<div class="form-group">
						<label for="client">CAT</label>
						<input type="text" id="CAT" name="CAT" class="form-control">
					</div>
						<label for="client">COMPTE</label>
						<input type="number" id="COMPTE" name="COMPTE" class="form-control">
					<div class="form-group">
					</div>
					<button class="btn btn-primary">Envoyer</button>
				</form>
			</section>
		</div>
	</main>
</body>
</html>