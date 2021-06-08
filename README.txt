-Constantes.php contient les constantes nécessaires à la connexion.
-DbConnect.php permet la connexion à la bdd
-Les différentes opérations sont répartie dans 4 fichiers :
	-add.php (permet d'ajouter des clients àà la bdd)
	-details.php (permet d'avoir plsu de détails sur un client)
	-edit.php (permet de modifier un clientdans la bdd)
	-delete.php (permet de suprimer un client dans la bdd)
-Lorsque qu'un client est ajouté, modifié ou suprimer, un journal de log est créé
selon le jour, si il en existe déjà alors, les logs s'écrivent à la suite.
-La nomencalture du journal de log est la suivante : [date]Logs.txt.
