<?php

	require 'include.php';
	verifie_droits_sur_employe();
?>
<!DOCTYPE HTML>

<html>
	<head>
		<meta charset="utf-8" />

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" type="text/css" href="modele.css">
		<link rel="stylesheet" type="text/css" href="input_output_set.css">

		<title>Blacklister</title>
	</head>

	<body>
		<!--Lien PHP vers la barre de navigation du Super Utilisateur-->
		<?php
			include("navigateur.php");
		?>
		<?php

			/* On vérifie que le login de l'employé à blacklister ainsi que son statut a bien été saisi */
			if(!empty($_POST['login_employe_blacklister']) )
			{
				/* On recherche l'employé à blacklister */
				$rechercher = $bdd->prepare('SELECT * FROM gestion_des_morgues.employe WHERE login_emp = ?');
				$rechercher->execute(array($_POST['login_employe_blacklister']) );

				$recupere_employe_blacklister = $rechercher->fetch();


				if(!empty($recupere_employe_blacklister['login_emp']) )
				{
					$email_emp = NULL;
					$statut_emp = 'blacklisté';

					/* On recherche le statut de l'employé AVANT de se faire blacklister */
					$cherche_statut_emp_blacklister = $bdd->prepare('SELECT * FROM gestion_des_morgues.employe WHERE login_emp = ?');
					$cherche_statut_emp_blacklister->execute(array($_POST['login_employe_blacklister']) );

					$recupere_statut_emp_blacklister = $cherche_statut_emp_blacklister->fetch();

					/* On insère l'employé à blacklister dans la table modifier_employe */
					$creer_blacklister_employe = $bdd->prepare('INSERT INTO gestion_des_morgues.modifier_employe(login_emp_modifier, login_responsable_modifier_employe, email_emp_modifier, statut_emp_modifier)
						VALUES(?, ?, ?, ?)');
					$creer_blacklister_employe->execute(array($_POST['login_employe_blacklister'], $_SESSION['login_emp'], $email_emp, $recupere_statut_emp_blacklister['statut_emp']) );

					$creer_blacklister_employe->closeCursor();
					$cherche_statut_emp_blacklister->closeCursor();


					/* Changement de statut de l'employé qui devient blacklisté dans la table employe */
					$blacklister_employe = $bdd->prepare('UPDATE gestion_des_morgues.employe SET statut_emp= "blacklisté" WHERE login_emp = ? ');
					$blacklister_employe->execute(array($_POST['login_employe_blacklister']) );

					$blacklister_employe->closeCursor();


					/* Affichage */
					?>
					<div class="alert alert-success" role="alert">
						<p>L'employé <?php echo $_POST['login_employe_blacklister'] ?> a bien été blacklisté </p>
					</div>
					<?php
				}
				else
				{
					?>
					<div class="alert alert-danger" role="alert">
						<p>La requête n'a pu aboutir. Veuillez saisir un login valide </p>
					</div>
					<?php
				}
			}
			?>
		<!-- Formulaire de saisie d'infomation sur l'employé blacklisté-->
		<form method="post" action="blacklister.php" name="blacklister.php">
			<fieldset>
				<legend>Informations sur l'employé à blacklister</legend>
				<table>
					<p>
						Attention, lors du remplacement d'un administrateur veuillez penser à créer un nouvel
						administrateur AVANT de supprimer l'administrateur de la morgue.
<br />
						Cela vaut aussi pour le remplacement du super utilisateur.
					</p>

					<tr>
						<td><label for="login_employe_blacklister">Login</label></td>
						<td><input type="text" name="login_employe_blacklister" id="login_employe_blacklister"/></td>
					</tr>

				</table>

				<!-- Bouton de validation du formulaire-->
				<table id="tab3">
					<tr>
						<td></td>
						<td>
							<input name="submit" id="submit_personne_a_blacklister" value="Valider" type="submit" />
						</td>
					</tr>
				</table>
			</fieldset>
		</form>


	</body>

		<!-- Lien PHP vers le footer-->
		<?php
			include("footer.php");
		?>

</html>
