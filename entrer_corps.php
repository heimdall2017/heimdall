<?php

  require 'include.php';
  verifie_droits_sur_corps();

  /* Indique s'il faut afficher un message de succès lors de l'ajout effectué */
	if (isset($_SESSION['corps_ajoute'])) {
	  $corps_ajoute = true;
    $box = $_SESSION['n_box'];
		unset($_SESSION['corps_ajoute']);
  }

  if (isset($_SESSION['morgue_pleine'])){
    $morgue = true;
    unset($_SESSION['morgue_pleine']);
  }

?>

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
		<link rel="stylesheet" type="text/css" href="input_output_set.css">

		<title>Entrées</title>
	</head>

	<body>
		<!-- Lien PHP vers la barre de navigation de l'Employé et de l'Administrateur-->
		<?php
			include("navigateur.php");
		?>

    <?php if (isset($corps_ajoute)) { ?>
      <div class="alert alert-success" role="alert">
        <p>Le corps a bien été ajouté.</p>
        <p>Box n° <?php echo $box ?> </p>
        <br><a href="imprimer.php"  target="_blank"><input name="ImprimerRecu" id="ImprimerRecu1" value="Imprimer le reçu" type="button"/></a>
	    </div>
	  <?php } else if(isset($morgue)){ ?>
      <div class="alert alert-danger" role="alert">
        <p>Le corps n'a pas pu être entré - Plus de Places disponibles </p>
      </div>
    <?php } ?>

    <!-- Formulaire de saisie des informations sur le corps à entrer -->
		<form method="post" action="entrer_corps_cible.php" name="entrer_corps" enctype="multipart/form-data">
			<fieldset>
				<legend>Informations sur le corps</legend>
				<table>
					<tr>
						<td><label for="nom">Nom </label></td>
						<td><input type="text" name="nom" id="nom"/></td>
					</tr>

					<tr>
						<td><label for="prenom">Prénom </label></td>
						<td><input type="text" name="prenom" id="prenom"/></td>
					</tr>
          <tr>
            <td><label for="adresse">Adresse</label></td>
            <td><input type="text" name="adresse" id="adresse"/></td>
          </tr>
					<tr>
						<td><label for="dateNaissance">Date de naissance</label></td>
						<td><input type="text" name="dateNaissance" id="dateNaissance" pattern="\d{4}-\d{2}-\d{2}" placeholder="AAAA-MM-JJ"/></td>
					</tr>
          <tr>
						<td><label for="lieuNaissance">Lieu de naissance</label></td>
						<td><input type="text" name="lieuNaissance" id="lieuNaissance"/></td>
					</tr>
					<tr>
						<td><label for="dateDeces">Date de décès</label></td>
						<td><input type="text" name="dateDeces" id="dateDeces" pattern="\d{4}-\d{2}-\d{2}" placeholder="AAAA-MM-JJ"/></td>
					</tr>
          <tr>
						<td><label for="lieuDeces">Lieu de décès</label></td>
						<td><input type="text" name="lieuDeces" id="lieuDeces"/></td>
					</tr>
					<tr>
						<td><label for="causeDeces">Cause de décès</label></td>
						<td><input type="text" name="causeDeces" id="causeDeces"/></td>
					</tr>
					<tr>
						<td><label for="certificatDeces">Certificat de décès </label></td>
						<td><input type="file" name="certificatDeces" id="certificatDeces"/></td>
					</tr>
				</table>
			</fieldset>
			<!-- Fin du formulaire de saisie des informations sur le corps à entrer -->
		  <!-- Formulaire de saisie des informations sur le référent au corps -->
			<fieldset>
				<legend>Informations sur l'accompagnateur</legend>
				<table>
					<tr>
						<td><label for="nomAcc">Nom </label></td>
						<td><input type="text" name="nomAcc" id="nomAcc"/></td>
					</tr>
					<tr>
						<td><label for="prenomAcc">Prénom </label></td>
						<td><input type="text" name="prenomAcc" id="nameAcc"/></td>
					</tr>
					<tr>
						<td><label for="ntel">N° téléphone </label></td>
						<td><input type="tel" name="ntel" id="ntel"/></td>
					</tr>
					<tr>
						<td><label for="AdministrationTer">Corps non identifiable<br>Administration territoriale contactée</label></td>
						<td><input type="text" name="AdministrationTer" id="AdministrationTer"/></td>
					</tr>
				</table>
			</fieldset>
			<!-- Fin du formulaire de saisie des informations sur le référent au corps -->

			<table id="tab_bouton_validation_entree_corps">
				<!-- Bouton de validation du formulaire en dehors des 2 fieldset (il valide les 2 parties du formulaire) -->
				<tr>
					<td><input name="submit" id="submit_authentification1" value="Valider" type="submit" /></td>
				</tr>
			</table>
		</form>

		<!-- Lien PHP vers le footer-->
		<?php
			include("footer.php");
		?>
	</body>
</html>
