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

		<title>Mot de passe oublié</title>
	</head>

	<body>
		<br><br>

		<!-- Formulaire de réinitialisation de mot de passe -->
		<form method="post" action="formulaire.php">
			<fieldset>
				<legend>Mot de passe oublié?</legend>
				<p>Entrez votre adresse mail, un message vous sera envoyé avec un lien pour réinitialiser votre mot de passe </p>
				<label for="mail">E-mail </label>
				<input type="mail" name="mail" id="mail" autofocus>

				<!-- Bouton de validation du formulaire -->
				<input name="submit" id="submit_authentification4" value="Valider" type="submit" />
			</fieldset>
		</form>

		<!-- Lien PHP vers le footer -->
		<?php
			include("footer.php");
		?>
	</body>
</html>
