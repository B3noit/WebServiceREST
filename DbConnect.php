<?php
include_once "Constantes.php"; // inclut le fichier constantes
try{
	//Connexion à la base

	$db = new PDO(SERVEUR.";dbname=".BASE, USER, MDP);
	$db->exec('SET NAMES "UTF-8"');

} catch (PDOException $e){

	echo 'Erreur : '. $e->getMessage();
	die();
}