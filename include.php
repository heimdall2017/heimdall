<?php

/* Paramètres pour la base de données MySQL */
define('HOSTNAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '123soleil');
define('DBNAME', 'gestion_des_morgues');

/* On lance la session de l'utilisateur */
session_start();

/* Connexion à la base de données MySQL */
try 
{
	$bdd = new PDO('mysql:host='.HOSTNAME.'; dbname='.DBNAME.'; charset=utf8', USERNAME, PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
/* affiche un message en cas d'erreur */
catch(Exception $exception) 
{
	die('Erreur: '.$exception->getMessage());
}


/* Vérifie que l'utilisateur est bien connecté */
function verifie_si_connecte()
{
	if (!isset($_SESSION['login_emp']) or !isset($_SESSION['statut_emp']) ) 
	{
		header('Location: connexion.php');
		exit;// Important!
	}
}


/* Vérifie que l'utilisateur connecté à les droits sur les corps */
function verifie_droits_sur_corps()
{
	verifie_si_connecte();
	if ($_SESSION['statut_emp'] != 'employe' and $_SESSION['statut_emp'] != 'administrateur') 
	{
		header('Location: erreur403.php');
		exit;
	}
}


/* Vérifie que l'utilisateur à les droits sur les employés */
function verifie_droits_sur_employe()
{
	verifie_si_connecte();
	if($_SESSION['statut_emp'] != 'super_utilisateur' and $_SESSION['statut_emp'] != 'administrateur' )
	{
		header('Location: erreur403.php');
		exit;
	}
}

/* Vérifie que l'utilisateur à les droits sur les corps et les employés */
function verifie_droit_sur_corps_employe()
{
	verifie_si_connecte();
	if($_SESSION['statut_emp'] != 'employe' and $_SESSION['statut_emp'] != 'administrateur' and $_SESSION['statut_emp'] != 'super_utilisateur')
	{
		header('Location: erreur403.php');
		exit;
	}
}

function verifie_tous_statuts()
{
	verifie_si_connecte();
	if($_SESSION['statut_emp'] != 'simple_lecteur' && $_SESSION['statut_emp'] != 'employe' && $_SESSION['statut_emp'] != 'administrateur' && $_SESSION['statut_emp'] != 'super_utilisateur')
	{
		header('Location: erreur403.php');
		exit;
	}
}
function verifie_droits_sur_box()
{
	verifie_si_connecte();
	if ($_SESSION['statut_emp'] != 'administrateur')
	{
		header('Location: erreur403.php');
		exit;
	}
}