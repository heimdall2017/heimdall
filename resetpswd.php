<!DOCTYPE HTML>

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
		<link rel="stylesheet" type="text/css" href="deconnexion.css">

		<title>Réinitialiser Mot de passe</title>
	</head>

	<body>
		<div id="content">
			<h1>Réinitialiser votre mot de passe</h1>

			<!-- Formulaire de saisie de réinitialisation de mot de passe -->
			<form method="post" action="formulaire.php">
				<fieldset>
					<legend>Réinitialisation</legend>
					<table>
						<tr>
							<td><label for="password">Mot de passe </label></td>
							<td><input type="password" name="password" id="password" placeholder="Nouveau mot de passe" minlength="8" required size="25" autocomplete="off" /></td>
						</tr>

						<tr>
							<td><label for="password">Mot de passe </label></td>
							<td><input type="password" name="password" id="password" placeholder="Confirmez votre mot de passe" minlength="8" required autocomplete="off" size="25" /></td>
						</tr>

						<!-- Bouton de validation du formulaire -->
						<tr>
							<td></td>
							<td><input name="submit" id="submit_authentification" value="Valider" type="submit" /></td>
						</tr>
					</table>
				</fieldset>
			</form>
		</div>

		<!-- Lien PHP vers le footer -->
		<?php
			include("footer.php");
		?>

	</body>
</html>
