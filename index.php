<?php
// On démarre une session
session_start();

//Connexion à la base
require_once('DbConnect.php');

$sql ='SELECT * FROM `client`';

//Preparation de la requête
$query = $db->prepare($sql);

//Execution de la requête
$query->execute();

//Stockage du résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('Close.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Liste des clients</title>
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
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
				<h1>Liste des clients</h1>
				<table class="table">
					<thead>
						<th>NCLI</th>
						<th>NOM</th>
						<th>ADRESSE</th>
						<th>LOCALITE</th>
						<th>CAT</th>
						<th>COMPTE</th>
						<th>Actions</th>
					</thead>
					<tbody>
						<?php
						foreach($result as $client)
						{?>
							<tr>
								<td><?= $client['NCLI'] ?></td>
								<td><?= $client['NOM'] ?></td>
								<td><?= $client['ADRESSE'] ?></td>
								<td><?= $client['LOCALITE'] ?></td>
								<td><?= $client['CAT'] ?></td>
								<td><?= $client['COMPTE'] ?></td>
								<td>
									<a href="details.php?NCLI=<?= $client['NCLI'] ?>">Détails</a> 
									<a href="edit.php?NCLI=<?= $client['NCLI'] ?>">Modifier</a>
									<a href="delete.php?NCLI=<?= $client['NCLI'] ?>">Supprimer</a>
								</td>

							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<a href="add.php" class="btn btn-primary">Ajouter un client</a>
			</section>
		</div>
	</main>
</body>
</html>