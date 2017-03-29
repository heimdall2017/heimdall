<?php
	require 'include.php';
	verifie_droit_sur_corps_employe()
?>

	<html>
		<head>
			<meta charset="utf-8">

			<!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

			<!-- Optional theme -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

			<!-- Latest compiled and minified JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

			<link rel="stylesheet" type="text/css" href="modele.css"/>
			<link rel="stylesheet" type="text/css" href="input_output_set.css">

			<title>Rechercher</title>
		</head>

		<body>
			<!-- Lien PHP vers la barre de naviagation de l'employé -->
			<?php
				include("navigateur.php");


			if($_SESSION['statut_emp'] == 'employe' || $_SESSION['statut_emp'] == 'administrateur')
			{
				?>
				<!-- Formulaire de recherche d'un corps -->
				<form method="post" name="rechercher.php" action="rechercher.php">
					<fieldset>
						<legend>Rechercher un corps</legend>

						Remplissez un champ pour obtenir des informations sur le corps,
						entrez le numéro du corps pour plus d'informations (corps, référent, modifications)
						<br /><br />

						<table>
							<!-- Choix du critère de recherche -->
							<tr>

								<td><label for="critere_corps">Critère </label></td>
								<td><select name="critere_corps">
										<option value="null">--- Critère de recherche ---</option>
										<option value="numero_corps">Numéro du corps</option>
										<option value="nom_corps">Nom du défunt</option>
										<option value="prenom_corps">Prénom du défunt</option>
										<option value="numero_ticket">Numéro de ticket</option>
										<option value="numero_bracelet_corps">Numéro du bracelet</option>
										<option value="numero_box">Numéro du box</option>
										<option value="nom_acc">Nom du référent</option>
										<!--<option value="prenom">Date d'arrivée</option>
										<option value="prenom">Date de sortie</option>-->
									</select>
								</td>
							</tr>

							<!-- Insertion de l'information permettant la recherche dans la base de données -->
							<tr>
								<td><label for="recherche_corps">Votre recherche</label></td>
								<td><input type="" name="recherche_corps" id="recherche_corps"/></td>
							</tr>

							<!-- Bouton de validation du formulaire -->
							<tr>
								<td></td>
								<td>
									<input name="submit" id="submit_recherche" value="Valider" type="submit" />
								</td>
							</tr>
						</table>
					</fieldset>
				</form>
				<?php
			}
			if($_SESSION['statut_emp'] == 'administrateur' ||$_SESSION['statut_emp'] == 'super_utilisateur')
			{
			?>
				<!-- Formulaire de recherche d'un employé -->
				<form method="post" name="rechercher.php" action="rechercher.php">
					<fieldset>
						<legend>Rechercher un employé</legend>

						Remplissez un champ pour obtenir des informations sur l'employé,
						entrez le login de l'employé pour plus d'informations (entrée, modifications, morgue)
						<br /><br />

						<table>
							<!-- Choix du critère de recherche -->
							<tr>
								<td><label for="critere_emp">Critère </label></td>
								<td><select name="critere_emp">
										<option value="null">--- Critère de recherche ---</option>
										<option value="login_emp">Login</option>
										<option value="nom_emp">Nom</option>
										<option value="prenom_emp">Prénom</option>
										<option value="email_emp">Email</option>
									</select>
								</td>
							</tr>

							<!-- Insertion de l'information permettant la recherche dans la base de données -->
							<tr>
								<td><label for="recherche_emp">Votre recherche</label></td>
								<td><input type="" name="recherche_emp" id="recherche_emp"/></td>
							</tr>

							<!-- Bouton de validation du formulaire -->
							<tr>
								<td></td>
								<td>
									<input name="submit" id="submit_recherche" value="Valider" type="submit" />
								</td>
							</tr>
						</table>
					</fieldset>
				</form>
				<?php
			}

			$requete_valide = 1;

			/* Rechercher un corps */
			if(!empty($_POST['recherche_corps']) && $_POST['critere_corps'] != "null")
			{
				/* Recherche du corps correspondant à la recherche */
				switch($_POST['critere_corps'])
				{
					case("numero_corps"):
						$rechercher_corps = $bdd->prepare('SELECT * FROM corps C, entrer_corps E WHERE C.numero_corps = ? AND C.numero_corps = E.numero_corps');
						break;
					case("nom_corps"):
						$rechercher_corps = $bdd->prepare('SELECT * FROM corps C, entrer_corps E WHERE C.nom_corps = ? AND C.numero_corps = E.numero_corps');
						break;
					case("prenom_corps"):
						$rechercher_corps = $bdd->prepare('SELECT * FROM corps C, entrer_corps E WHERE C.prenom_corps = ? AND C.numero_corps = E.numero_corps');
						break;
					case("numero_bracelet_corps"):
						$rechercher_corps = $bdd->prepare('SELECT * FROM corps C, entrer_corps E WHERE C.numero_bracelet_corps = ? AND C.numero_corps = E.numero_corps');
						break;
					case("numero_box"):
						$rechercher_corps = $bdd->prepare('SELECT * FROM corps C, entrer_corps E WHERE E.numero_box = ? AND C.numero_corps = E.numero_corps');
						break;
					case("numero_ticket"):
						$rechercher_corps = $bdd->prepare('SELECT * FROM corps C, entrer_corps E WHERE E.numero_ticket = ? AND C.numero_corps = E.numero_corps');
						break;
					case("nom_acc"):
						$rechercher_corps = $bdd->prepare('SELECT * FROM corps C, entrer_corps E, accompagnateur A WHERE A.nom_acc = ? AND A.numero_acc = E.numero_acc AND E.numero_corps = C.numero_corps');
						break;
					default:
						break;
				}
				$rechercher_corps->execute(array($_POST['recherche_corps']) );

				/* Affichage */
				?>
				<fieldset>
				<?php
				while($resultat_recherche = $rechercher_corps->fetch() )
				{
					?>
					<legend>Informations sur le(s) corps</legend>
					<p>
						Numéro du corps: <?php echo $resultat_recherche['numero_corps']; ?> <br />
						Nom: <?php echo $resultat_recherche['nom_corps']; ?> <br />
						Prénom: <?php echo $resultat_recherche['prenom_corps']; ?> <br />
						Adresse: <?php echo $resultat_recherche['adresse_corps']; ?> <br />
						Cause de décès: <?php echo $resultat_recherche['cause_deces_corps']; ?> <br />
						Date de naissance: <?php echo $resultat_recherche['d_naissance_corps']; ?> <br />
						Date de mort: <?php echo $resultat_recherche['d_mort_corps']; ?> <br /><br />

						Numero de box: <?php echo $resultat_recherche['numero_box']; ?> <br />
						Numero du ticket: <?php echo $resultat_recherche['numero_ticket']; ?> <br />
						Numero de bracelet: <?php echo $resultat_recherche['numero_bracelet_corps']; ?> <br /><br />

						Date d'arrivée: <?php echo $resultat_recherche['d_arrivee_corps']; ?> <br />
						Date de sortie: <?php echo $resultat_recherche['d_sortie_corps']; ?> <br />
						<?php
							$req = $bdd->prepare('SELECT id_morgue FROM entrer_corps WHERE numero_corps = ?');
							$req->execute(array($resultat_recherche['numero_corps']));
							$recupere_id = $req->fetch();
							$req->closeCursor();
							$_SESSION['id_morgue'] = $recupere_id['id_morgue'];

							$chercher_nom = $bdd->prepare('SELECT * FROM morgue WHERE id_morgue = ?');
							$chercher_nom->execute(array($_SESSION['id_morgue']));
							$recupere_nom = $chercher_nom->fetch();
							$chercher_nom->closeCursor();
							$_SESSION['nom_morgue']=$recupere_nom['nom_morgue'];
							$_SESSION['adresse_morgue']=$recupere_nom['adresse_morgue'];

							$_SESSION['numero_corps']=$resultat_recherche['numero_corps'];
						?>
						<a href="imprimer.php"  target="_blank"><input name="ImprimerRecu" id="ImprimerRecu1" value="Imprimer le reçu" type="button"/></a>
					</p>

					<?php
				}
				$rechercher_corps->closeCursor();

				if($_POST['critere_corps'] == "numero_corps")
				{
					$rechercher_modif_corps = $bdd->prepare('SELECT * FROM modifier_corps WHERE numero_corps_modifier = ? ORDER BY d_modifier_corps DESC');
					$rechercher_modif_corps->execute(array($_POST['recherche_corps']) );

					while($resultat_modif_corps = $rechercher_modif_corps->fetch() )
					{
						/* On affiche les modifications sur le corps */
						?>
						<p>
							<br />
							Modifié par: <?php echo $resultat_modif_corps['login_emp_modifier']; ?>
							le: <?php echo $resultat_modif_corps['d_modifier_corps']; ?> <br />

							Element(s) avant modification:
							<?php
							if($resultat_modif_corps['nom_corps_modifier'] != NULL)
								echo ' Nom: '. $resultat_modif_corps['nom_corps_modifier'];

							if($resultat_modif_corps['prenom_corps_modifier'] != NULL)
								echo ' Prenom du corps: '. $resultat_modif_corps['prenom_corps_modifier'];

							if($resultat_modif_corps['adresse_corps_modifier'] != NULL)
								echo ' Adresse: '. $resultat_modif_corps['adresse_corps_modifier'];

							if($resultat_modif_corps['d_naissance_corps_modifier'] != NULL)
								echo ' Date de naissance: '. $resultat_modif_corps['d_naissance_corps_modifier'];

							if($resultat_modif_corps['l_naissance_corps_modifier'] != NULL)
								echo ' Lieu de naissance: '. $resultat_modif_corps['l_naissance_corps_modifier'];

							if($resultat_modif_corps['cause_deces_corps_modifier'] != NULL)
								echo ' Cause du décès: '. $resultat_modif_corps['cause_deces_corps_modifier'];

							if($resultat_modif_corps['d_mort_corps_modifier'] != NULL)
								echo ' Date de mort: '. $resultat_modif_corps['d_mort_corps_modifier'];

							if($resultat_modif_corps['l_mort_corps_modifier'] != NULL)
								echo ' Lieu de mort: '. $resultat_modif_corps['l_mort_corps_modifier'];

							if($resultat_modif_corps['numero_box_modifier'] != NULL)
								echo ' Numero du box: '. $resultat_modif_corps['numero_box_modifier'];

							if($resultat_modif_corps['numero_bracelet_corps_modifier'] != NULL)
								echo ' Numero du bracelet'. $resultat_modif_corps['numero_bracelet_corps_modifier']; ?>
							<br />
						</p>
						<?php
					}
					$rechercher_modif_corps->closeCursor();

					/* On affiche les informations sur l'entrée du corps */
					$rechercher_entrer_corps = $bdd->prepare('SELECT * FROM gestion_des_morgues.entrer_corps WHERE numero_corps = ?');
					$rechercher_entrer_corps->execute(array($_POST['recherche_corps']) );

					if($recupere_entrer_corps = $rechercher_entrer_corps->fetch() )
					{
						?>
						<br /><br />
						Entré par: <?php echo $recupere_entrer_corps['login_emp']; ?>
						le: <?php echo $recupere_entrer_corps['d_arrivee_corps']; ?><br />
						Numéro de ticket: <?php echo $recupere_entrer_corps['numero_ticket']; ?><br />
						Numéro de box: <?php echo $recupere_entrer_corps['numero_box']; ?><br />
						<?php

						/* On affiche la morgue du corps */
						$recherche_morgue = $bdd->prepare('SELECT nom_morgue FROM gestion_des_morgues.morgue WHERE id_morgue = ?');
						$recherche_morgue->execute(array($recupere_entrer_corps['id_morgue']) );

						$recupere_morgue = $recherche_morgue->fetch();
						echo 'Morgue: '. $recupere_morgue['nom_morgue'];

						$recherche_morgue->closeCursor();
					}
					$rechercher_entrer_corps->closeCursor();

					/* On affiche les informations relatives au paiement */
					$recherche_sortir_corps = $bdd->prepare('SELECT * FROM gestion_des_morgues.sortir_corps WHERE numero_corps = ?');
					$recherche_sortir_corps->execute(array($_POST['recherche_corps']) );

					$recupere_sortir_corps = $recherche_sortir_corps->fetch();

					if(!empty($recupere_sortir_corps['numero_corps']) )
					{
						echo 'Valeur du paiement: '. $recupere_sortir_corps['valeur_paiement'];
						if($recupere_sortir_corps['statut_paiement'] == 1)
							echo ' déjà payé.';
						else
							echo ' pas encore payé.';
					}
				}
				?>
				</fieldset>
				<!-- Fin de l'affichage pour les corps -->

				<?php
				if( empty($resultat_recherche) )
					$requete_valide = 0;
			}
			/* Rechercher un employé */
			else if(!empty($_POST['recherche_emp']) && $_POST['critere_emp'] != "null")
			{
				/* Recherche de l'employé correspondant à la recherche */
				switch($_POST['critere_emp'])
				{
					case "login_emp":
						$rechercher_employe = $bdd->prepare('SELECT * FROM employe WHERE login_emp = ?');
						break;
					case "nom_emp":
						$rechercher_employe = $bdd->prepare('SELECT * FROM employe WHERE nom_emp = ?');
						break;
					case "prenom_emp":
						$rechercher_employe = $bdd->prepare('SELECT * FROM employe WHERE prenom_emp = ?');
						break;
					case "email_emp":
						$rechercher_employe = $bdd->prepare('SELECT * FROM employe WHERE email_emp = ?');
						break;
				}

				$rechercher_employe->execute(array($_POST['recherche_emp']) );

				?>
				<fieldset>
					<?php
					while($resultat_recherche = $rechercher_employe->fetch() )
					{
						/* On affiche les informations sur l'employé */
						?>
						<legend>Informations sur le(s) employés</legend>
						<p>
							Login: <?php echo $resultat_recherche['login_emp']; ?> <br />
							Nom: <?php echo $resultat_recherche['nom_emp']; ?> <br />
							Prenom: <?php echo $resultat_recherche['prenom_emp']; ?> <br />
							Statut: <?php echo $resultat_recherche['statut_emp']; ?> <br />
							Email: <?php echo $resultat_recherche['email_emp']; ?> <br />
						</p>
						<?php
					}
					$rechercher_employe->closeCursor();

					if($_POST['critere_emp'] == "login_emp")
					{
						/* On affiche les modifications sur l'employé */
						$rechercher_modif_employe = $bdd->prepare('SELECT * FROM modifier_employe WHERE login_emp_modifier = ? ORDER BY d_modifier_employe DESC');
						$rechercher_modif_employe->execute(array($_POST['recherche_emp']) );

						while($resultat_modif_employe = $rechercher_modif_employe->fetch() )
						{
							?>
							<p>
								<br />
								Modifié par: <?php echo $resultat_modif_employe['login_responsable_modifier_employe']; ?>
								le: <?php echo $resultat_modif_employe['d_modifier_employe']; ?><br />

								Elément(s) avant modification:
								<?php
								if($resultat_modif_employe['email_emp_modifier'] != NULL)
									echo ' Email: '. $resultat_modif_employe['email_emp_modifier'];
								if($resultat_modif_employe['statut_emp_modifier'] != NULL)
									echo ' Statut: '. $resultat_modif_employe['statut_emp_modifier'];
								?>
								<br />
							</p>
							<?php
						}
						$rechercher_modif_employe->closeCursor();


						/* On affiche les informations sur la création de l'employé */
						$rechercher_entrer_employe = $bdd->prepare('SELECT * FROM gestion_des_morgues.ajouter_employe WHERE login_emp_ajouter = ?');
						$rechercher_entrer_employe->execute(array($_POST['recherche_emp']) );

						if($resultat_entrer_employe = $rechercher_entrer_employe->fetch() )
						{
							?>
							<p>
								<br /><br />
								Entré par: <?php echo $resultat_entrer_employe['login_responsable_ajouter']; ?>
								le: <?php echo $resultat_entrer_employe['d_emp_ajouter']; ?><br />
							</p>
							<?php
						}
					}
					?>
				</fieldset>
				<?php
				$rechercher_employe->closeCursor();
			}
			else if($requete_valide == 0)
			{
				?>
				<fieldset>
					<legend>Nous n'avons pas pu exécuter votre requête</legend>
					<p>Veuillez renseigner tous les champs nécessaires à votre recherche.</p>
				</fieldset>
				<?php
			}


			/* Lien PHP vers le footer */

				include("footer.php");
			?>
		</body>
	</html>
