<?php
	require 'include.php';
	verifie_droits_sur_corps();

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

		<title>Sortie</title>
	</head>

	<body>
		<!-- Lien PHP vers la barre de navigation de l'Employé ou l'Administrateur -->
		<?php
			include("navigateur.php");
		?>

		<!-- Traitement PHP du formulaire de sortie définitive -->

			<?php

				$numero_corps = isset($_POST['numero_corps']) ? $_POST['numero_corps'] :"";			

				$numero_ticket = isset($_POST['numero_ticket']) ? $_POST['numero_ticket'] : "";

				$statut_paiement = isset($_POST['statut_paiement']) ? 1 : 0;

				$valeur_paiement = isset($_POST['valeur_paiement']) ? $_POST['valeur_paiement'] : "";

				$valider1 = isset($_POST['valider1']) ? $_POST['valider1'] : "";

				// Vérification de la validation du numero reçu
				$ticket_verif = $bdd->prepare ('SELECT numero_ticket FROM entrer_corps WHERE numero_corps = ?');
				$ticket_verif->execute( array($numero_corps));
				$num_ticket = $ticket_verif->fetch()[0];
				
				// Vérification que le numero de corps existe encore dans la table corps
				$num_corps_verif = $bdd->prepare('SELECT * FROM gestion_des_morgues.corps WHERE numero_corps=?') ;
				$num_corps_verif->execute( array($numero_corps));
				
				$num_corps_verif_sortie = $num_corps_verif->fetch()[0];

				// Si le corps a déjà été sorti
				$num_corps_sorti_verif = $bdd->prepare('SELECT * FROM gestion_des_morgues.sortir_corps WHERE numero_corps=?') ;
				$num_corps_sorti_verif->execute( array($numero_corps));
				
				$num_corps_sorti_verif_sortie = $num_corps_sorti_verif->fetch()[0];

				

				// on teste si la variable du formulaire est bien déclarée
				if($valider1 != "")
				{
					if ($numero_corps != "" && $numero_corps == $num_corps_verif_sortie && $numero_corps != $num_corps_sorti_verif_sortie && $numero_ticket == $num_ticket)
					{
						//Affichage d'un message 
						?> 
							<div class="alert alert-info" role="alert">
						    <p>Le corps N° : <?php echo $numero_corps; ?> a bien été sorti de la morgue. </p>
							</div>
						<?php 

						// Requête vers la bd
						$sortir_corps = $bdd->prepare('INSERT INTO sortir_corps(numero_corps,login_emp, statut_paiement, valeur_paiement) VALUES(?, ?, ?, ?)');

						$sortir_corps->execute(array($numero_corps, $_SESSION['login_emp'], $statut_paiement, $valeur_paiement) ) or die("Erreur". $sortir_corps. "Error: (". mysql-errno().")". mysql_error() );

					    $sortir_corps->closeCursor();

						// On ajoute une date de sortie du corps de la table corps après sa sortie
					    $modifier_corps = $bdd->prepare(' UPDATE corps SET d_sortie_corps = 
					    NOW() WHERE numero_corps=? ');
					    $modifier_corps->execute(array( $numero_corps));
						$modifier_corps->closeCursor();

						// On change le statut de box en vide (0)
					    $recherche_num_box = $bdd->prepare('SELECT numero_box FROM entrer_corps WHERE numero_corps=?');
					    $recherche_num_box->execute(array($numero_corps));
					    $num_box = $recherche_num_box->fetch()[0];
					    $vider_box = $bdd->prepare('UPDATE box SET statut_box=0 WHERE numero_box=?'); 
					    $vider_box->execute(array($num_box)); 
					    
				}
				    // Si le numéro du corps n'a pas été saisi
				    if ($numero_corps == "") 
				    {
					    ?>
							<div class="alert alert-danger" role="alert">
			   					<p>Veuillez remplir le champ N° corps </p>
							</div>
						<?php 
					} 

					// Le numéro de corps ne correspond à aucun corps de la bd
					elseif ($numero_corps != $num_corps_verif_sortie) 
					{
						?>
							<div class="alert alert-danger" role="alert">
			   					<p>Veuillez saisir un numéro de corps valide </p>
							</div>
						<?php 	
					}

					// Si le champ numero reçu n'a pas été saisi
					elseif ($numero_ticket == "") 
					{
						?>
							<div class="alert alert-danger" role="alert">
			   					<p>Veuillez remplir le champ N° reçu </p>
							</div>
						<?php 
					}
					
					// Si le numero de ticket ne correspond pas à celui de entrer_corps
					elseif ($numero_ticket != $num_ticket) 
					{
						?>
							<div class="alert alert-danger" role="alert">
			   					<p>Veuillez saisir un numéro  de reçu valide </p>
							</div>
						<?php 	
					}
					
					// Le corps a déja été sorti
					elseif ($numero_corps == $num_corps_sorti_verif_sortie) 
					{
						?>
							<div class="alert alert-danger" role="alert">
			   					<p>Ce corps a déjà été sorti </p>
							</div>
						<?php 	
					}
			}		
				
				// Sortie temporaire
				// Le statut du box ne sera pas modifié et reste occupé (valeur 1)
				// Variables
				$medecin_responsable = isset($_POST['responsable_sortie']) ? $_POST['responsable_sortie'] : "";
				$cause_sortie = isset($_POST['cause_sortie']) ? $_POST['cause_sortie'] : "";
				$valider2 = isset($_POST['valider2']) ? $_POST['valider2'] : "";
				
				if($valider2 !=""){
					if ($numero_corps != "" && $num_corps_verif_sortie == $numero_corps && $numero_corps != $num_corps_sorti_verif_sortie && $cause_sortie !="") 
					{
					
						$sortir_corps_temp = $bdd->prepare('INSERT INTO gestion_des_morgues.sortir_temp_corps(numero_corps,login_responsable, medecin_responsable, raison_sortie_temp) VALUES(?, ?, ?, ?)');

						$sortir_corps_temp->execute(array($numero_corps, $_SESSION['login_emp'], $medecin_responsable, $cause_sortie) );

					    $sortir_corps_temp->closeCursor();

					    // On n'ajoute pas de date de sortie du corps de la table corps après une sortie temporaire
					    $not_modifier_corps = $bdd->prepare(' UPDATE corps SET d_sortie_corps = 
					    NULL WHERE numero_corps=? ');
					    $not_modifier_corps->execute(array( $numero_corps));

					    // On garde le statut de box en occupé (1)
					    $rechercher_num_box = $bdd->prepare('SELECT numero_box FROM entrer_corps WHERE numero_corps=?');
					    $rechercher_num_box->execute(array($numero_corps));
					    $number_box = $rechercher_num_box->fetch()[0];
					    $garder_box = $bdd->prepare('UPDATE box SET statut_box=1 WHERE numero_box=?');  
					    ?> 
					    <!-- Affichage d'un message -->
						<div class="alert alert-info" role="alert">
					    <p>Le corps N° : <?php echo $numero_corps; ?> a bien été sorti temporairement de la morgue. </p>
						</div>
							<?php  
						}
						
						// Le numero du corps est vide
						elseif ($numero_corps =="") 
						{
							?>
								<div class="alert alert-danger" role="alert">
				   					<p>Veuillez remplir le champ N° corps </p>
								</div>
							<?php 
						}
						
						// Le numero du corps est invalide
						elseif ($numero_corps != $num_corps_verif_sortie) 
						{
							?>
								<div class="alert alert-danger" role="alert">
				   					<p>Veuillez remplir un N° corps valide</p>
								</div>
							<?php 
						}
						
						// Le corps a déjà été sorti
						elseif ($numero_corps == $num_corps_sorti_verif_sortie) 
						{
							?>
								<div class="alert alert-danger" role="alert">
				   					<p>Ce corps a déjà été sorti </p>
								</div>
							<?php 
						}
						
						// La cause de sortie n'est pas renseignée
						elseif ($cause_sortie=="") 
						{
							?>
								<div class="alert alert-danger" role="alert">
				   					<p>Veuillez indiquer le motif de la sortie du corps</p>
								</div>
							<?php 
						}
				}
			?>

		<!-- 2 formulaires: l'un pour les sorties définitives de corps,
		l'autre pour les sorties temporaires de corps-->
		<form method="post" action="sortir_corps.php">
			<!-- Formulaire de saisie des informations sur le corps à sortir définitivement -->
			<fieldset>
				<legend>Sortie définitive</legend>
				<table>
					<tr>
						<td><label for="numero_corps">N° corps </label></td>
						<td><input type="number" name="numero_corps" id="numero_corps" ></td>
					</tr>

					<tr>
						<td><label for="numero_ticket">N° reçu</label></td>
						<td><input type="number" name="numero_ticket" id="numero_ticket"></td>
					</tr>

					<tr>
						<td><label for="valeur_paiement">Prix à payer</label></td>
						<td><input type="number" name="valeur_paiement" id="valeur_paiement"></td>
					</tr>

					<tr>
						<td><label for="statut_paiement_non">Paiement effectué</label></td>
						<td>
							<input type="radio" name="statut_paiement" value="non" id="statut_paiement_non" checked>non
							<input type="radio" name="statut_paiement" value="oui" id="statut_paiement_oui">oui
						</td>

					</tr>

				<!-- Bouton de validation du formulaire -->

				<table>	

				<table>

					<tr>
						<td></td>
						<td><input name="valider1" id="valider1" value="Valider" type="submit" /></td>
					</tr>
				</table>
			</fieldset>
		</form>
				

			<!-- Formulaire de saisie d'informations sur le corps à sortir temporairement -->
			<form method="post" action="sortir_corps.php">
			<fieldset>
				<legend>Sortie temporaire</legend>
				<table>
					<tr>
						<td><label for="numero_corps">N° corps </label></td>
						<td><input type="number" name="numero_corps" id="number3" ></td>
					</tr>

					<tr>
						<td><label for="cause_sortie">Cause  de sortie </label></td>
						<td><input type="text" name="cause_sortie" id="cause_sortie"></td>
					</tr>

					<tr>
						<td><label for="responsable_sortie">Médecin responsable </label></td>
						<td><input type="text" name="responsable_sortie" id="responsable_sortie"></td>
					</tr>
				</table>

				<!-- Bouton de validation du formulaire -->
				<table>
					<tr>
						<td></td>
						<td><input name="valider2" id="valider2" value="Valider" type="submit" /></td>
					</tr>
				</table>
			</fieldset>
		</form>

		
		<!-- Lien PHP vers le footer -->
		<?php
			include("footer.php");
		?>
	</body>
</html>
