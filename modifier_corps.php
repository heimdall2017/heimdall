<?php
  require 'include.php';
  verifie_droits_sur_corps();
?>
<!DOCTYPE HTML>

<html lang="fr">
	<head>
		<meta charset="utf-8"/>

        <!-- BOOTSTRAP-->

		<!-- Bootstrap pour le CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Boostrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<!-- Bootstrap pour JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" type="text/css" href="modele.css"/>
		<link rel="stylesheet" type="text/css" href="input_output_set.css"/>
        <link rel="stylesheet" type="text/css" href="modifier_corps_style.css"/>
        <script type="text/javascript" src="modifier.js"></script>

		<title>Accueil Employé</title>

	</head>

	<body>
		<!-- Lien PHP vers la barre de navigation de l'employé -->
		<?php
			include("navigateur.php");
		?>

		<!-- Formulaire de saisie des informations à modifier -->
		<div>
			<form method="post" action="formulaire.php">
				<fieldset>
					<legend>Corps à modifier</legend>
					<table>
						<tr>
							<td><label for="num_corps"> Numéro du Corps </label></td>
							<td><input type="number" name="num_corps" id="num_corps"/></td>
						</tr>
					</table>
				</fieldset>

				<fieldset>
					<legend>Informations sur le corps</legend>
					<table>
						<tr>
							<td><label for="champs">Champs à modifier </label></td></tr><tr>
							<td><select name="champs" id="champs" onChange="printInput();" >
									<option value="0">--- Champs à modifier  ---</option>
									<option value="1">Nom</option>
									<option value="2">Prénom</option>
									<option value="3">Cause de décès</option>
									<option value="4">Date de naissance</option>
									<option value="5">Lieu de naissance</option>
									<option value="6">Date de décès</option>
									<option value="7">Lieu de décès</option>
									<option value="8">Adresse</option>
									<option value="9">Corps identifiable?</option>
									<option value="10">Ajouter Certificat</option>
								</select></td>
								<td><input type="text" name="nom_corps" id="nom_corps" style="display: none"/></td>
                                <td><input type="text" name="prenom_corps" id="prenom_corps" style="display: none"/></td>
                                <td><input type="text" name="cause_deces_corps" id="cause_deces_corps" style="display: none"/></td>
                                <td><input type="date" name="d_naiss_corps" id="d_naiss_corps" style="display: none"/></td>
                                <td><input type="text" name="l_naiss_corps" id="l_naiss_corps" style="display: none"/></td>
                                <td><input type="date" name="d_deces_corps" id="d_deces_corps" style="display: none"/></td>
                                <td><input type="text" name="l_deces_corps" id="l_deces_corps" style="display: none"/></td>
                                <td><input type="text" name="adresse_corps" id="adresse_corps" style="display: none"/></td>
                                <td><input type="file" name="certif_corps" id="certif_corps" style="display: none"/></td>

						</tr>

						<!-- Bouton de validation du formulaire -->
						<tr>
							<td></td>
							<td><input name="submit" id="submit_authentification1" value="Valider" type="submit" /></td>
						</tr>
					</table>
				</fieldset>

				<fieldset>
					<legend>Informations sur le référent</legend>
					<table>
						<tr>
							<td><label for="champs_ref">Champs à modifier </label></td></tr><tr>
							<td><select name="champs_ref" id="champs_ref" onChange="printInputRef();">
									<option value="0">--- Champs à modifier  ---</option>
									<option value="1">Nom</option>
									<option value="2">Prénom</option>
									<option value="3">Téléphone</option>
								</select>
				            </td>
                            <td><input type="text" name="nom_ref" id="nom_ref" style="display:none"/></td>
                            <td><input type="text" name="prenom_ref" id="prenom_ref" style="display:none"/></td>
                            <td><input type="text" name="tel_ref" id="tel_ref" style="display:none"/></td>
						</tr>

						<!-- Bouton de validation du formulaire -->
						<tr>
							<td></td>
							<td><input name="submit" id="submit_authentification1" value="Valider" type="submit" /></td>
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
