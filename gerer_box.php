<?php
	require 'include.php';
	verifie_droits_sur_box();
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

		<!-- Formulaire de saisie des informations sur les boxes -->
		<form method="post" name="gerer_box.php" action="gerer_box.php">
			<fieldset>
				<legend>Informations sur les boxes</legend>
				<p>
					<?php
					/* On recherche la morgue de l'employé */
					$recherche_morgue_employe = $bdd->prepare('SELECT id_morgue FROM gestion_des_morgues.ajouter_employe WHERE login_emp_ajouter = ?');
					$recherche_morgue_employe->execute(array($_SESSION['login_emp']) );

					$recupere_morgue_employe = $recherche_morgue_employe->fetch();

					$recherche_nb_box = $bdd->prepare('SELECT COUNT(*) AS nb_de_box FROM gestion_des_morgues.box WHERE id_morgue = ?');
					$recherche_nb_box->execute(array($recupere_morgue_employe['id_morgue']) );

					$recupere_nb_box = $recherche_nb_box->fetch();

					echo 'Il y a actuellement '. $recupere_nb_box['nb_de_box']. ' box(es) dans la morgue';
					?>
				</p>

				<table>
					<tr>
						<td><label for="nb_box">Nombre de boxes </label></td>
						<td><input type="number" name="nb_box" id="nb_box"/></td>
					</tr>

					<tr>
						<td><label for="mdp_box">Code pour y accéder </label></td>
						<td><input type="password" name="mdp_box" id="mdp_box"/></td>
					</tr>

				</table>

				<table id="tab_bouton_validation_box">
					<!-- Bouton de validation du formulaire en dehors des 2 fieldset (il valide les 2 parties du formulaire) -->
					<tr>
						<td></td>
						<td><input name="submit_authentification4" id="submit_authentification4" value="Valider" type="submit" /></td>
					</tr>
				</table>
			</fieldset>
		</form>

		<?php

			$mdp_box = NULL;

			if(!empty($_POST['nb_box']) )
			{



				if(!empty($_POST['mdp_box']) )
				{
					/* On récupère le mot de passe des boxes de cette morgue */
					$recherche_mdp_box = $bdd->prepare('SELECT mdp_box FROM gestion_des_morgues.box WHERE id_morgue = ?');
					$recherche_mdp_box->execute(array($recupere_morgue_employe['id_morgue']) )/* or die ("Erreur". $recherche_mdp_box. "Error (". mysql-errno(). ")". mysql_error() )*/;

					/* On modifie le mot de passe sur tous les boxes */
					$modifier_mdp_box = $bdd->prepare('UPDATE gestion_des_morgues.box SET mdp_box = ? WHERE id_morgue = ?');
					$modifier_mdp_box->execute(array($_POST['mdp_box'], $recupere_morgue_employe['id_morgue']) );

					$mdp_box = $_POST['mdp_box'];
				}

				/* On utlise ce résultat pour calculer le nombre de boxes dans cette morgue */


				//$recherche_morgue_employe->closeCursor();

				$nb_box_dans_bdd = $recupere_nb_box['nb_de_box'];

				?>
				<fieldset>
					<?php

					/* On crée les boxes manquants */
					while($_POST['nb_box'] > $nb_box_dans_bdd)
					{
						$nb_box_dans_bdd ++;
						$creer_box = $bdd->prepare
						('
							INSERT INTO gestion_des_morgues.box
							(
								numero_box,
								mdp_box,
								statut_box,
								id_morgue
							)
							VALUES
							(
								:numero_box,
								:mdp_box,
								:statut_box,
								:id_morgue
							)
						');

						$creer_box->execute(array
						(
							':numero_box' => $nb_box_dans_bdd ,
							':mdp_box' => $mdp_box,
							':statut_box' => 0,
							':id_morgue' => $recupere_morgue_employe['id_morgue']
						) );

						echo 'Box N°'. $nb_box_dans_bdd. ' a été créé'; ?> <br /><br /> <?php
					}

					$cherche_box_vide = $bdd->prepare('SELECT numero_box FROM gestion_des_morgues.box WHERE statut_box = 0 AND id_morgue = ? ORDER BY numero_box DESC');
					$cherche_box_vide->execute(array($recupere_morgue_employe['id_morgue']) );


					/* On crée les boxes manquants */
					while($nb_box_dans_bdd > $_POST['nb_box'])
					{
						$recupere_box_vide = $cherche_box_vide->fetch();

						if(empty($recupere_box_vide['numero_box']) )
						{
							echo 'Erreur: vous ne pouvez pas supprimer un box supplémentaire car vos boxes sont tous occupés.'; ?> <br /><br /> <?php
							echo 'Pensez à bien sortir les corps qui ne sont plus présents sur l\'application afin que les nombre de boxes vides ne soit pas faussé.'; ?> <br /> <?php

							$_POST['nb_box'] = $nb_box_dans_bdd;
						}
						else
						{
							$supprimer_box = $bdd->prepare('DELETE FROM gestion_des_morgues.box WHERE numero_box = ? AND id_morgue = ?');
							$supprimer_box->execute(array($recupere_box_vide['numero_box'], $recupere_morgue_employe['id_morgue']) );

							$supprimer_box->closeCursor();

							echo 'Box N°'. $nb_box_dans_bdd. ' a été supprimé'; ?> <br /><br /> <?php
							$nb_box_dans_bdd --;
						}
					}
					?>
				</fieldset>
				<?php
			}
		?>


		<!-- Lien PHP vers le footer-->
		<?php
			include("footer.php");
		?>
	</body>
</html>
