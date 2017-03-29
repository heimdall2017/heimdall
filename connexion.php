<?php

	require 'include.php';

	if(!empty($_POST['username']) && !empty($_POST['password']) )
	{
		$tous_employe = $bdd->prepare('SELECT * FROM employe WHERE login_emp = ? AND mdp_emp = ?');
		$tous_employe->execute(array($_POST['username'], $_POST['password']));
		$un_employe = $tous_employe->fetch();
		$tous_employe->closeCursor();

		/* On vérifie que le login entré existe et que le mot de passe entré est bien le mot de passe pour ce login*/
		if($un_employe !== false and $un_employe['statut_emp'] != 'blackliste')
		{
			/* Le login est juste donc on identifie l'employé */
			$_SESSION['login_emp'] = $un_employe['login_emp'];
			$_SESSION['statut_emp'] = $un_employe['statut_emp'];

			/* L'employé est dirigé vers la page d'accueil de l'application */
			header('Location: accueil.php');
			exit;
		}
		else
		{
			$erreur_connexion = true;
		}
  }

	/* On le déconnecte s'il l'était déjà */
	session_destroy();
?>
<!doctype php>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" type="text/css" href="modele.css"/>
		<link rel="stylesheet" type="text/css" href="connexion.css">

		<title>Authentification</title>
	</head>

	<body>
		<div class="page-header">
			<h1>
				Heimdall <br />
				<small>Application Web de gestion de Morgues</small>
			</h1>

		</div>


		<!-- Formulaire de saisie de l'identifiant et du mot de passe par l'utilisateur pour se connecter à l'application-->
		<form method="post" action="connexion.php">
			<fieldset>
				<legend id="id_autho">Authentification</legend>
				<table>
					<tr>
						<td><label for="username"><span class="glyphicon glyphicon-user"></span>Identifiant </label></td>
						<td><input type="text" name="username" id="username" placeholder="Votre identifiant" size="30" autofocus required autocomplete="off" /></td>
					</tr>

					<tr>
						<td><label for="password"><span class="glyphicon glyphicon-lock"></span>Mot de passe </label></td>
						<td><input type="password" name="password" id="password" placeholder="Votre mot de passe" minlength="8" size="30" required autocomplete="off" /></td>
					</tr>

					<!-- Bouton de connexion-->
					<tr>
						<td></td>
						<td><input class="connect" name="submit" id="submit_authent" value="Se connecter" type="submit" /></td>
					</tr>

					<?php if (isset($erreur_connexion)) { ?>
					<tr>
						<td></td>
						<td><p>Login ou mot de passe invalide.</p></td>
					</tr>
					<?php } ?>

					<tr>
						<td></td>
						<td><a href="mdp_oublie.php" target="_blank" title="aide">Mot de passe oublié?</a></td>
					</tr>
				</table>
			</fieldset>
		</form>

		<div id="images">
			<img src="republique.png" style=" height : 90px; float : inline-block; margin-top : 0px; matgin-right : 5%">
		</div>
		<!-- Lien PHP vers le footer -->
		<div id="footer_connexion">
			<?php
				include("footer.php");
			?>
		</div>
	</body>
</html>
