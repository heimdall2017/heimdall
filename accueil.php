<?php
	require 'include.php';
	verifie_tous_statuts();

?>
<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" type="text/css" href="modele.css">
		<link rel="stylesheet" type="text/css" href="input_output_set.css">

		<title>Accueil Employé</title>
	</head>

	<body>
		<!-- Lien PHP vers la barre de naviagation de l'employé -->
		<?php
			include("navigateur.php");
		?>

		<!-- Recherche et Affichage du Nombre de places disponibles -->
		<?php
			$recherche_nb = $bdd->prepare('SELECT * FROM box WHERE statut_box=?');
			$recherche_nb->execute(array(0));
			$count = $recherche_nb->rowCount();
			$_SESSION['nb_place'] = $count;
			if ($_SESSION['nb_place'] > 0) {
		?>
				<div class="alert alert-info" role="alert">
			    <p> Il y a <?php echo $_SESSION['nb_place']; ?>  place(s) libre(s). </p>
				</div>
		<?php }else { ?>
		<div class="alert alert-danger" role="alert">
		    <p>Il n'y a plus de places disponibles. </p>
		</div>
		<?php } ?>
		<fieldset>
			<h2>Statistiques</h2>
		</fieldset>

		<fieldset id="rappels">
			<legend>Rappels</legend>
		</fieldset>

		<!-- Lien PHP vers le footer -->
		<?php
			include("footer.php");
		?>
	</body>
</html>
