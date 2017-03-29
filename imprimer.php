<?php
	require 'include.php';
    verifie_droits_sur_corps();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Reçu</title>
	</head>

	<body onload="window.print()">
	<h1> <?php
		$recherche_nom_morgue = $bdd->prepare('SELECT * from morgue WHERE id_morgue = ?');
		$recherche_nom_morgue->execute(array($_SESSION['id_morgue']));
		$nom_morgue = $recherche_nom_morgue->fetch();
		echo 'Morgue ' . $nom_morgue['nom_morgue'] ?></h1>
		<?php echo 'Adresse : '.$nom_morgue['adresse_morgue'];?>
	<p>
		<?php
			/* On recherche les informations annexes à afficher sur le corps */
			$cherche_entrer_corps = $bdd->prepare('SELECT * FROM entrer_corps WHERE numero_corps = ?');
			$cherche_entrer_corps->execute(array($_SESSION['numero_corps']) ) or die(print_r($cherche_entrer_corps->errorInfo(), TRUE) );
			$recupere_entrer_corps = $cherche_entrer_corps->fetch();
			echo 'Reçu n°'. $recupere_entrer_corps['numero_ticket']; ?><br><br><?php

			/* On recherche les informations à afficher sur le corps */
			$cherche_corps = $bdd->prepare('SELECT * FROM corps WHERE numero_corps = ?');
			$cherche_corps->execute(array($_SESSION['numero_corps']) )  or die(print_r($cherche_corps->errorInfo(), TRUE) );
			$recupere_corps = $cherche_corps->fetch();
			echo 'Nom du défunt: '. $recupere_corps['nom_corps']. "<br />\n".'Prénom du défunt: '. $recupere_corps['prenom_corps'] . "<br />\n";
			$cherche_corps->closeCursor();

			/* On recherche les informations à afficher sur l'accompagnateur */
			$cherche_acc = $bdd->prepare('SELECT * FROM accompagnateur WHERE numero_acc = ?');
			$cherche_acc->execute(array($recupere_entrer_corps['numero_acc']) ) or die(print_r($cherche_acc->errorInfo(), TRUE) );
			$recupere_acc = $cherche_acc->fetch();

			/* Affichage */
			echo 'Nom de l\'accompagnateur: '. $recupere_acc['nom_acc']."<br />\n".'Prénom de l\'accompagnateur: '. $recupere_acc['prenom_acc'];
			$cherche_acc->closeCursor();
			$cherche_entrer_corps->closeCursor();
		?>
	</p>
</body>
</html>
