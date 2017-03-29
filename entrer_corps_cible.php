<?php

	require 'include.php';
	verifie_droits_sur_corps();

	if (!isset($_POST['submit']) ) 
	{
	  header('Location: entrer_corps.php');
		exit;
	}

	$recherche_nb = $bdd->query('SELECT * FROM gestion_des_morgues.box WHERE statut_box=0');
	$count = $recherche_nb->rowCount();
	$nb_place = $count;
	
	if ($nb_place< 1) 
	{
		$_SESSION['morgue_pleine']=true;
		header('Location: entrer_corps.php');
		exit;
	}


	/* Si la variable $_POST['variale'] existe, alors $variable = $_POST['variable'] sinon elle vaut '' */
    $nom_acc = !empty($_POST['nomAcc']) ? $_POST['nomAcc'] : '';
    $prenom_acc = !empty($_POST['prenomAcc']) ? $_POST['prenomAcc'] : '';
    $telephone_acc = !empty($_POST['ntel']) ? $_POST['ntel'] : '';


	/* Requête pour Insérer les données de l'Accompagnateur */

	/* Vérifier si l'accompagnateur n'est pas déjà enregistré dans la Base de données */
	$cherche_accompagnateur = $bdd->prepare("SELECT * FROM accompagnateur WHERE nom_acc = ? AND prenom_acc = ? AND telephone_acc = ?");
	$cherche_accompagnateur->execute(array($nom_acc, $prenom_acc, $telephone_acc));
	$count = $cherche_accompagnateur->rowCount();
	
	if($count == 0)
	{
		$creer_acc = $bdd->prepare('INSERT INTO accompagnateur(nom_acc, prenom_acc, telephone_acc) VALUES (?, ?, ?)');
		$creer_acc->execute(array($nom_acc, $prenom_acc, $telephone_acc));
		$creer_acc->closeCursor();
	}
	
	$cherche_accompagnateur->closeCursor();


	/* Création du numero du corps composé d'un numéro aléatoire et d'un numero incrémenté stocké dans la table entrer_corps */
	$recherche_nb_corps = $bdd->query('SELECT * FROM corps');
	$nb_corps = $recherche_nb_corps->rowCount();
	
	$recherche_nb_corps->closeCursor();
	
	/* Création du numéro aléatoire */
	$numero_aleatoire = rand(0,9999);
	
	/* On concatène les deux */
	$numero_corps = $numero_aleatoire . $nb_corps;

	/*Recherche de l'ID de la morgue où travaille l'employé */
	$login_emp = $_SESSION['login_emp'];


	$req = $bdd->prepare('SELECT * FROM employe WHERE login_emp = ?');
	$req->execute(array($_SESSION['login_emp']));
	$recupere_id = $req->fetch();
	$id_morgue = $recupere_id['id_morgue'];

	/* Recherche du numéro de l'Accompagnateur */
	$recherche_numero_acc = $bdd->prepare('SELECT * FROM accompagnateur WHERE telephone_acc = ?');
	$recherche_numero_acc->execute(array($telephone_acc));
	$recupere_numero_acc = $recherche_numero_acc->fetch();
	$numero_acc = $recupere_numero_acc['numero_acc'];

	/* Création du numéro de ticket */

	do 
	{
		$numero_aleatoire_ticket = rand(0,99999);
		$recherche_unique = $bdd->prepare('SELECT * from entrer_corps WHERE numero_ticket = ?');
		$recherche_unique->execute(array($numero_aleatoire_ticket));
		$nb = $recherche_unique->rowCount();

		$recherche_unique->closeCursor();
		if($nb ==0) 
		{
			$numero_ticket = $numero_aleatoire_ticket;
			$unique = true;
		}
	} while (!$unique);


	/* Chercher un box vide */
	$recherche_box_vide = $bdd->query('SELECT * FROM box WHERE statut_box = 0 LIMIT 1');
	$box = $recherche_box_vide->fetch();
	$numero_box = $box['numero_box'];
	$recherche_box_vide->closeCursor();

	$nom_corps = !empty($_POST['nom']) ? $_POST['nom'] : '';
    $prenom_corps = !empty($_POST['prenom']) ? $_POST['prenom'] : '';
    $adresse_corps = !empty($_POST['adresse']) ? $_POST['adresse'] : '';
    $d_naissance_corps = !empty($_POST['dateNaissance']) ? $_POST['dateNaissance'] : NULL;
    $l_naissance_corps = !empty($_POST['lieuNaissance']) ? $_POST['lieuNaissance'] : '';
    $d_mort_corps = !empty($_POST['dateDeces']) ? $_POST['dateDeces'] : NULL;
    $l_mort_corps = !empty($_POST['lieuDeces']) ? $_POST['lieuDeces'] : '';
    
	
	/* On vérifie si une cause de décès est entrée et si elle existe déjà dans la bdd */
	if(!empty($_POST['cause_deces_corps']) && $_POST['cause_deces_corps'] != "null")
	{
		$cause_deces_corps = $_POST['cause_deces_corps'];
	}
	elseif(!empty($_POST['nouvelle_cause_deces']) )
	{
		$cause_deces_corps = $_POST['nouvelle_cause_deces'];
	}
	else
	{
		$cause_deces_corps = '';
	}


	if(isset($_FILES['certificatDeces']))
	{
		$dossier = 'upload/';
		$fichier = basename($_FILES['certificatDeces']['name']);
		$taille_maxi = 100000;
		$taille = filesize($_FILES['certificatDeces']['tmp_name']);
		$extensions = array('.png', '.gif', '.jpg', '.jpeg');
		$extension = strrchr($_FILES['certificatDeces']['name'], '.');
		//On formate le nom du fichier ici...
		$fichier = strtr($fichier,
		 	'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
		 	'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
		if(move_uploaded_file($_FILES['certificatDeces']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
		{
			$certif_deces = '/upload/'. $fichier;
		} else {
			$certif_deces = '';
		}
	}

	/* Requête pour Insérer les Informations sur le Corps */
	if (!empty($_POST['AdministrationTer']) )
	{
		$reconnu_corps = 0;
	} 
	else 
	{
		$reconnu_corps = 1;
	}
	
	
	do 
	{
		$numero_aleatoire_bracelet = rand(0,99999);
		
		$recherche_unique_br = $bdd->prepare('SELECT * from corps WHERE numero_bracelet_corps = ?');
		$recherche_unique_br->execute(array($numero_aleatoire_bracelet));
		$nb = $recherche_unique_br->rowCount();
		
		$recherche_unique_br->closeCursor();

		if($nb ==0) 
		{
			$numero_bracelet_corps = $numero_aleatoire_bracelet;
			$unique_br = true;
		}
	} while (!$unique_br);
	
	/* On crée le corps dans la table corps */
	$creer_corps = $bdd->prepare
	('
		INSERT INTO corps
		(
			numero_corps,
			numero_bracelet_corps,
			nom_corps,
			prenom_corps,
			adresse_corps,
			d_naissance_corps,
			l_naissance_corps,
			d_mort_corps,
			l_mort_corps,
			cause_deces_corps,
			certif_deces,
			reconnu_corps
		)
		VALUES
		(
			:numero_corps,
			:numero_bracelet_corps,
			:nom_corps,
			:prenom_corps,
			:adresse_corps,
			:d_naissance_corps,
			:l_naissance_corps,
			:d_mort_corps,
			:l_mort_corps,
			:cause_deces_corps,
			:certif_deces,
			:reconnu_corps
		)
	');

	$creer_corps->execute(array
	(
		':numero_corps' => $numero_corps,
		':numero_bracelet_corps' => $numero_bracelet_corps,
		':nom_corps' => $nom_corps,
		':prenom_corps' => $prenom_corps,
		':adresse_corps'=> $adresse_corps,
		':d_naissance_corps' => $d_naissance_corps,
		':l_naissance_corps' => $l_naissance_corps,
		':d_mort_corps' => $d_mort_corps,
		':l_mort_corps' => $l_mort_corps,
		':cause_deces_corps' => $cause_deces_corps,
		':certif_deces' => $certif_deces,
		':reconnu_corps' => $reconnu_corps,
	) );

	$creer_corps->closeCursor();


	/* Requête pour Insérer les informations dans entrer_corps */
	$creer_entrer_corps = $bdd->prepare
	('
		INSERT INTO entrer_corps
		(
			id_morgue,
			numero_corps,
			login_emp,
			numero_acc,
			numero_ticket,
			numero_box
		) 
		VALUES 
		(
			:id_morgue,
			:numero_corps,
			:login_emp,
			:numero_acc,
			:numero_ticket,
			:numero_box 
		)
	');

	$creer_entrer_corps->execute(array
	(
		'id_morgue' => $id_morgue,
		'numero_corps' => $numero_corps,
		'login_emp' => $login_emp,
		'numero_acc' => $numero_acc,
		'numero_ticket' => $numero_ticket,
		'numero_box' => $numero_box
	) );

	$creer_entrer_corps->closeCursor();
	
	
	/* Une fois que le corps a pu être entré dans la base, on modifie le statut du Box utilisé */
	$modifier_box = $bdd->prepare('UPDATE box SET statut_box=1 WHERE numero_box = ?');
	$modifier_box->execute(array($numero_box));
	$modifier_box->closeCursor();

	$_SESSION['id_morgue'] = (int)$id_morgue;
	$_SESSION['numero_corps'] = (int)$numero_corps;
	$_SESSION['n_box'] = (int)$numero_box;
	$_SESSION['corps_ajoute'] = true;
	
	header('Location: entrer_corps.php');
	exit;
