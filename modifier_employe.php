<?php
	require 'include.php';
	verifie_droits_sur_employe();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" type="text/css" href="modele.css"/>
		<link rel="stylesheet" type="text/css" href="input_output_set.css"/>

		<title>Modifier les informations sur l'employé</title>
	</head>

	<body>
		<!-- Lien PHP vers la barre de navigation du Super Utilisateur -->
		<?php
			include("navigateur.php");
		?>

		<?php
		/* On vérifie qu'un login a bien été entré */
		if(!empty($_POST['login_employe']))
		{
			/* On vérifie que l'employé existe déjà */
			$cherche_employe_modif = $bdd->prepare('SELECT * FROM employe WHERE login_emp = ?');
			$cherche_employe_modif->execute(array($_POST['login_employe']) );

			/* On récupère le résultat (unique) de notre requête */
			$recupere_employe_modif = $cherche_employe_modif->fetch();


			/* On vérifie que la requête a bien renvoyé un résultat et qu'il y a bien une modification à effectuer sur l'employé */
			if(!empty($recupere_employe_modif['login_emp']) && (!empty($_POST['email_modifier_employe']) || $_POST['statut_modifier_employe'] != "null") )
			{
				/* Variables */
				$email_emp = !empty($_POST['email_modifier_employe']) ? $recupere_employe_modif['email_emp'] : NULL;
				$statut_emp = ($_POST['statut_modifier_employe'] != "null") ? $recupere_employe_modif['statut_emp'] : NULL;


				/* Modifier la table modifier_employe */
				$creer_modifier_employe = $bdd->prepare('INSERT INTO gestion_des_morgues.modifier_employe(login_emp_modifier, login_responsable_modifier_employe, email_emp_modifier, statut_emp_modifier)
						VALUES(?, ?, ?, ?)');
				$creer_modifier_employe->execute(array($recupere_employe_modif['login_emp'], $_SESSION['login_emp'], $email_emp, $statut_emp) );
				$creer_modifier_employe->closeCursor();


				/* Changement de la valeur de mes variables */
				$email_emp = !empty($_POST['email_modifier_employe']) ? $_POST['email_modifier_employe'] : $recupere_employe_modif['email_emp'];
				$statut_emp = ($_POST['statut_modifier_employe'] != "null") ? $_POST['statut_modifier_employe'] : $recupere_employe_modif['statut_emp'];


				/* Modifier la table employe */
				$modifier_employe = $bdd->prepare('UPDATE employe SET email_emp = ?, statut_emp = ? WHERE login_emp = ?');
				$modifier_employe->execute(array($email_emp, $statut_emp, $_POST['login_employe']) );
				$modifier_employe->closeCursor();
				$cherche_employe_modif->closeCursor(); /* la requête $cherche_employe est créée en ligne 96 */

				/* Affichage */
				?>
				<div class="alert alert-success" role="alert">
				<?php
				if(!empty($_POST['email_modifier_employe']) )
				{
					?>
					<p>L'email de cet employé a bien été modifié.</p>
					<?php
				}

				if($_POST['statut_modifier_employe'] != "null")
				{
					?>
					<p>Le statut de cet employé a bien été modifié.</p>
					<?php
				}
				?>
			</div>
				<?php
			}
			/* Si aucun login valide n'a été entré on affiche un message d'erreur */
			else
			{
				?>
					<div class="alert alert-danger" role="alert">
						<p>La requête n'a pu aboutir. Veuillez saisir un login valide</p>
					</div>
				<?php
			}
		}
		?>
		<!-- Formulaire de saisie de modifications des droits -->
		<div>
			<form method="post" action="modifier_employe.php" name="formulaire_modifier_emp" onsubmit="return valider_modifier_emp()">
				<fieldset>
					<legend>Modification des informations sur l'employé</legend>
					<table>
						<tr>
							<td><label for="login_employe"> Login </label></td>
							<td><input type="text" name="login_employe" id="login_employe"/></td>
						</tr>

						<tr>
							<td><label for="email_modifier_employe"> Modifier adresse mail </label></td>
							<td><input type="text" placeholder="modifier l'adresse mail" name="email_modifier_employe" id="email_modifier_employe"/></td>
						</tr>

						<tr>
							<td>
								<label for="statut_modifier_employe"> Modifier statut </label>
							</td>
							<td>
								<select name="statut_modifier_employe">
									<option value="null">--- modifier le statut ---</option>
									<option value="simple_lecteur">Simple lecteur</option>
									<option value="employe">Employé</option>
									<option value="administrateur">Administrateur</option>
									<?php
									if($_SESSION['statut_emp'] == 'super_utilisateur')
									{
										?>
										<option value="super_utilisateur">Super utilisateur</option>
										<?php
									}
									?>
								</select>
							</td>
						</tr>


						<!-- Bouton de validation du formulaire -->
						<tr>
							<td></td>
							<td>
								<input name="submit" id="submit_authentification1" value="Valider" type="submit" />
							</td>
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
