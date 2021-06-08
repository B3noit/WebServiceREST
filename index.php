<?php

//Connexion à la base
required_once('connection.php');

$sql ='SELECT * FROM `client`';

//Preparation de la requête
$query = $db->prepare($sql);

//Execution de la requête
$query->execute();

//Stockage du résultat dans un tableau associatif
$result = $query->fetchAll();

var_dump($result);

?>

https://nouvelle-techno.fr/actualites/live-coding-creer-un-crud-en-php
https://nouvelle-techno.fr/actualites/live-coding-creer-une-api-rest