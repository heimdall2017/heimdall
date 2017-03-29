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

	<script type="text/javascript" src="accueil.js"></script>
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
				<legend>Statistiques</legend>
				<form method="post" action="selectionner" name="statistiques">
					<table>
						<tr>
							<td><label for="critere_stat">Critère</label></td>
							<td><select name="critere_stat" id="critere_stat" onchange="afficher();">
								<option value="null">--- Critère de Statistiques ---</option>
								<option value="1">Tranche d'âges</option>
								<option value="2">Causes de Décès</option>
								<option value="3">Lieu de Décès</option>
								<option value="4">Indigence</option>
								<option value="5">Nombre de Décès par an</option>
							</select>
						</td>
					</tr>
				</table>
			</form>
			<table>
				<tr>
				<div class="age" id="age" style="display: none">
					<h1><small>Nombre de Décès par Tranche d'âge</small></h1>
					<p>(0-24 mois)</p>
					<p>Nombre de Décès :
						<?php
							$recupere_nb_deces = $bdd->query('SELECT COUNT(*) FROM corps WHERE (YEAR(d_mort_corps)-YEAR(d_naissance_corps))<=2 ');
							$nb_deces_0 = $recupere_nb_deces->fetch()[0];
							echo $nb_deces_0;
							$recupere_nb_deces->closeCursor();

						?></p>
					<br>
					<p>(2-14 ans)</p>
					<p>Nombre de Décès :
						<?php
							$recupere_nb_deces = $bdd->query('SELECT COUNT(*) FROM corps WHERE(YEAR(d_mort_corps)-YEAR(d_naissance_corps))>2 AND  (YEAR(d_mort_corps)-YEAR(d_naissance_corps))<=14');
							$nb_deces_1 = $recupere_nb_deces->fetch()[0];
							echo $nb_deces_1;
							$recupere_nb_deces->closeCursor();

						?></p>
					<br>
					<p>(15-29 ans)</p>
					<p>Nombre de Décès :<?php
						$recupere_nb_deces = $bdd->query('SELECT COUNT(*) FROM corps WHERE(YEAR(d_mort_corps)-YEAR(d_naissance_corps))>14 AND  (YEAR(d_mort_corps)-YEAR(d_naissance_corps))<=29');
						$nb_deces_1 = $recupere_nb_deces->fetch()[0];
						echo $nb_deces_1;
						$recupere_nb_deces->closeCursor();

					?></p>
					<br>
					<p>(30-44 ans)</p>
					<p>Nombre de Décès : <?php
						$recupere_nb_deces = $bdd->query('SELECT COUNT(*) FROM corps WHERE(YEAR(d_mort_corps)-YEAR(d_naissance_corps))>29 AND  (YEAR(d_mort_corps)-YEAR(d_naissance_corps))<=44');
						$nb_deces_1 = $recupere_nb_deces->fetch()[0];
						echo $nb_deces_1;
						$recupere_nb_deces->closeCursor();

					?></p>
					<br>
					<p>(45-59 ans)</p>
					<p>Nombre de Décès : <?php
						$recupere_nb_deces = $bdd->query('SELECT COUNT(*) FROM corps WHERE(YEAR(d_mort_corps)-YEAR(d_naissance_corps))>44 AND  (YEAR(d_mort_corps)-YEAR(d_naissance_corps))<=59');
						$nb_deces_1 = $recupere_nb_deces->fetch()[0];
						echo $nb_deces_1;
						$recupere_nb_deces->closeCursor();

					?></p>
					<br>
					<p>(60-74 ans)</p>
					<p>Nombre de Décès : <?php
						$recupere_nb_deces = $bdd->query('SELECT COUNT(*) FROM corps WHERE(YEAR(d_mort_corps)-YEAR(d_naissance_corps))>60 AND  (YEAR(d_mort_corps)-YEAR(d_naissance_corps))<=74');
						$nb_deces_1 = $recupere_nb_deces->fetch()[0];
						echo $nb_deces_1;
						$recupere_nb_deces->closeCursor();

					?></p>
					<br>
					<p>(75+ ans)</p>
					<p>Nombre de Décès : <?php
						$recupere_nb_deces = $bdd->query('SELECT COUNT(*) FROM corps WHERE(YEAR(d_mort_corps)-YEAR(d_naissance_corps))>74');
						$nb_deces_1 = $recupere_nb_deces->fetch()[0];
						echo $nb_deces_1;
						$recupere_nb_deces->closeCursor();

					?></p>
					<br>
				</div>
				<tr>
					<div class="cause" id="cause" style="display: none">
						<h1><small>Répartition des Décès par Cause</small></h1>
					</div>
				</tr>
				<tr>
					<div class="lieu" id="lieu" style="display: none">
						<h1><small>Lieu de Décès</small></h1>
					</div>
				</tr>
				<tr>
					<div class="indigence" id="indigence" style="display: none">
						<h1><small>Indigence</small></h1>
					</div>
				</tr>
				<tr>
					<div class="nombre" id="nombre" style="display: none">
						<h1><small>Nombre de Décès par an</small></h1>
					</div>
				</tr>
			</table>
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
