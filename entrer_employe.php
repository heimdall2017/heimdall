<?php
	require 'include.php';
	verifie_droits_sur_employe();
?>

<!DOCTYPE html>
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

		<title>Ajouter employé</title>
	</head>

	<body>
		<!-- Lien PHP vers la barre de navigation de l'Administrateur ou du Super Utilisateur-->
		<?php
			include("navigateur.php");
		?>
		<?php

		$valider = isset($_POST['valider']) ? $_POST['valider'] : NULL;

		if($valider != NULL)
		{
			$login_responsable_ajouter = $_SESSION['login_emp'];
			$nom_emp = isset($_POST['nom_employe']) ? $_POST['nom_employe'] : NULL;
			$prenom_emp = isset($_POST['prenom_employe']) ? $_POST['prenom_employe'] : NULL;
			$email_emp = isset($_POST['email_employe']) ? $_POST['email_employe'] : NULL;
			$mdp_emp = isset($_POST['mdp_employe']) ? $_POST['mdp_employe'] : NULL;
			$confirmation_mdp_emp = isset($_POST['confirm_mdp_employe']) ? $_POST['confirm_mdp_employe'] : NULL;
			$statut_emp = isset($_POST['statut_employe']) ? $_POST['statut_employe'] : NULL;



		// Hachage du mot de passe pour plus de securite

		//$mdp_emp = password_hash("mdp_emp", PASSWORD_DEFAULT);

		// Insertion d'un nouvel employe dans la table employe de la base de données

		if($mdp_emp == $confirmation_mdp_emp && strlen($mdp_emp) >= 8 && $nom_emp != NULL && $prenom_emp != NULL && $email_emp != NULL && $mdp_emp != NULL && ($_POST['morgue_employe'] != "null" || !empty($_POST['nouvelle_morgue']) ) )
			{
				/* On génère un login pour l'employé */
				$login_employe_debut = substr($_POST['statut_employe'], 0, 3);
				$login_employe_milieu = substr($_POST['nom_employe'], 0, 5);
				$login_employe_fin = (string)(rand(0, 99) );



				/* On concatène le tout */
				$login_emp = $login_employe_debut . $login_employe_milieu . $login_employe_fin;


				/* Si la morgue entrée existe déjà */
				if(empty($_POST['nouvelle_morgue']) )
				{
					$id_morgue = $_POST['morgue_employe'];
				}
				/* Sinon on en crée une nouvelle */
				else
				{
					/* On crée un nouvel id */
					$cherche_nb_morgue = $bdd->query('SELECT COUNT(*) AS nb_morgue FROM gestion_des_morgues.morgue');
					$recupere_nb_morgue = $cherche_nb_morgue->fetch();
					$id_morgue = $recupere_nb_morgue['nb_morgue'] + 1;

					$cree_morgue = $bdd->prepare('INSERT INTO gestion_des_morgues.morgue(id_morgue, nom_morgue, adresse_morgue) VALUES(?, ?, ?)');
					$cree_morgue->execute(array($id_morgue, $_POST['nouvelle_morgue'], $_POST['adresse_morgue']) );
					$cree_morgue->closeCursor();
				}


				/* On crée l'employé dans la table employe*/
				$creer_emp = $bdd->prepare
				('
					INSERT INTO gestion_des_morgues.employe
					(
						login_emp,
						nom_emp,
						prenom_emp,
						email_emp,
						mdp_emp,
						statut_emp,
						id_morgue
					)
					VALUES
					(
						:login_emp,
						:nom_emp,
						:prenom_emp,
						:email_emp,
						:mdp_emp,
						:statut_emp,
						:id_morgue
					)
				');

				$creer_emp->execute(array
				(
					':login_emp' => $login_emp,
					':nom_emp' => $nom_emp,
					':prenom_emp' => $prenom_emp,
					':email_emp' => $email_emp,
					':mdp_emp' => $mdp_emp,
					':statut_emp' =>$statut_emp,
					':id_morgue' => $id_morgue
				) );

				$creer_emp->closeCursor();



				/* On crée l'employé dans la table ajouter_employe */
				$creer_ajouter_emp = $bdd->prepare
				('
					INSERT INTO ajouter_employe
					(
						login_responsable_ajouter,
						login_emp_ajouter,
						d_emp_ajouter,
						id_morgue
					)
					VALUES
					(
						:login_responsable_ajouter,
						:login_emp_ajouter,
						NOW(),
						:id_morgue
					)
				');

				$creer_ajouter_emp->execute(array
				(
					':login_responsable_ajouter' => $_SESSION['login_emp'],
					':login_emp_ajouter' => $login_emp,
					':id_morgue' => $id_morgue
				) );

				$creer_ajouter_emp->closeCursor();


				/* Affichage */
					?>
				<div class="alert alert-success" role="alert" >
					<p>
						Félicitations ! Votre nouvel employé a bien été ajouté aux services de la morgue, son login est: <br />
						<?php echo $login_emp;?>
					</p>
				</div>
				<?php
			}

			/* Au cas où aucun champ n'ait été saisi */
			if(isset($_POST['valider']) && ($nom_emp == NULL || $prenom_emp == NULL || $email_emp == NULL || $mdp_emp == NULL || $confirmation_mdp_emp == NULL) )
			{
				?>
				<div class="alert alert-danger" role="alert" >
						<p>La requête n'a pas pu aboutir. Veuillez saisir tous les champs </p>
				</div>
				<?php
			}

			/* Si la confirmation du mot de passe n'est pas identique au mot de passe */
			elseif($mdp_emp != $confirmation_mdp_emp)
			{
				?>
				<div class="alert alert-danger" role="alert">
					<p>La requête n'a pu aboutir. Veuillez saisir le même mot de passe dans le champ de confirmation du mot de passe</p>
				</div>
				<?php
			}
		}
		?>
		<!-- Formulaire de saisie des informations sur l'employé à ajouter -->
		<form method="post" name ="entrer_employe.php" action="entrer_employe.php" >

			<fieldset>
				<legend>Ajouter un employé</legend>
					<table>
						<tr>
							<td><label for="nom_employe">Nom</label></td>
							<td><input type="text" name="nom_employe" id="nom_employe" placeholder="Votre Nom" /></td>
						</tr>

						<tr>
							<td><label for="prenom_employe">Prenom</label></td>
							<td><input type="text" name="prenom_employe" id="prenom_employe" placeholder="Votre prenom" /></td>
						</tr>

						<tr>
							<td><label for="email_employe">Adresse mail</label></td>
							<td><input type="email" name="email_employe" id="email_employe" placeholder="exemple@domaine.com" /></td>
						</tr>

						<tr>
							<td><label for="mdp_employe">Mot de passe</label></td>
							<td><input type="password" name="mdp_employe" id="mdp_employe" minlength="8" placeholder="8 caractères au moins" autocomplete="off" /></td>
						</tr>

						<tr>
							<td><label for="confirm_mdp_employe">Confirmer le mot de passe</label></td>
							<td><input type="password" name="confirm_mdp_employe" id="confirm_mdp_employe" minlength="8" placeholder="confirmation " autocomplete="off" /></td>
						</tr>

						<tr>
							<td><label for="statut_employe">Statut</label></td>
							<td>
								<select name="statut_employe">
									<option value="employé">Employé</option>
									<option value="administrateur">Administrateur</option>

									<!-- Seul le super utilisateur peut rajouter un super utilisateur ou un simple lecteur -->
									<?php
										if($_SESSION['statut_emp'] == 'super_utilisateur')
										{
											?>
											<option value="simple_lecteur">Simple lecteur</option>
											<option value="super_utilisateur">Super utilisateur</option>
											<?php
										}
									?>
								</select>
							</td>
						</tr>

						<tr>
							<td><label for="morgue_employe">Morgue associée</label></td>
							<td>
								<select name="morgue_employe">
									<?php
										/* On recherche le nom des morgues à afficher dans la base de données */
										$cherche_morgue = $bdd->query('SELECT * FROM gestion_des_morgues.morgue');
										while($recupere_morgue = $cherche_morgue->fetch() )
										{
											?>
											<option value=" <?php echo $recupere_morgue['id_morgue']; ?> "> <?php echo $recupere_morgue['nom_morgue']; ?></option>
											<?php
										}
									?>
								</select>
							</td>
						</tr>

						<tr>
							<td><label for="nouvelle_morgue">Si c'est une nouvelle morgue</label></td>
							<td><input type="text" name="nouvelle_morgue" id="nouvelle_morgue" placeholder="nom de la morgue " /></td>
						</tr>
						<tr>
							<td><label for="adresse_morgue" >Adresse de la nouvelle morgue</td>
							<td><input type="text" name="adresse_morgue" id="adresse_morgue" minlength="8" placeholder="adresse de la morgue " /></td>
						</tr>

						<!-- Bouton de validation du formulaire -->
						<tr>
							<td></td>
							<td><input type="submit" name="valider" value="valider" /></td>
						</tr>
					</table>
				</fieldset>
			</form>

		<!-- Lien PHP vers le footer-->
		<?php
			include("footer.php");
		?>
	</body>
</html>
