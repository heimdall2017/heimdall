<?php
	/* On lance la session de l'utilisateur */
	  require 'include.php';
	  verifie_droits_sur_employe();

// Vérification de la validité des informations


//Si la variable $_POST['truc'] existe, alors $truc = $_POST['truc']  sinon elle vaut NULL
$login_emp = isset($_POST['login_employe']) ? $_POST['login_employe'] : NULL;

$nom_emp = isset($_POST['nom_employe']) ? $_POST['nom_employe'] : NULL;

$prenom_emp = isset($_POST['prenom_employe']) ? $_POST['prenom_employe'] : NULL;

$email_emp = isset($_POST['email_employe']) ? $_POST['email_employe'] : NULL;

$mdp_emp = isset($_POST['mdp_employe']) ? $_POST['mdp_employe'] : NULL;

$statut_emp = isset($_POST['statut_employe']) ? $_POST['statut_employe'] : NULL;

$valider = isset($_POST['valider']) ? header('Location: http://localhost/2016-l2t1/src/accueil.php') : header('Location: http://localhost/2016-l2t1/src/entrer_employe.php');

// Hachage du mot de passe pour plus de securite

//$mdp_emp = password_hash("mdp_emp", PASSWORD_DEFAULT);

// Insertion d'un nouvel employe dans la table employe de la base de données

$req = $bdd->prepare('INSERT INTO employe(login_emp, nom_emp, prenom_emp, email_emp, mdp_emp, statut_emp) VALUES(:login_emp, :nom_emp, :prenom_emp, :email_emp, :mdp_emp, :statut_emp, :NOW())');

$req->execute(array(

    'login_emp' => $login_emp,

    'nom_emp' => $nom_emp,

    'prenom_emp' => $prenom_emp,

    'email_emp' => $email_emp,

    'mdp_emp' => $mdp_emp,

    'statut_emp' =>$statut_emp

    ));



?>
