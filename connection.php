<?php
try{
	//Connexion à la base

	$db = new PDO('mysql:host=localhost;dbname=cli_com_light', 'root', '');
	$db->exec('SET NAMES "UTF-8"');

} catch (PDOException $e){

	echo 'Erreur : '. $e->getMessage();
	die();
}