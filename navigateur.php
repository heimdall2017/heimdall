<!-- Barre de navigation du Super Utilisateur -->
<nav class="navbar navbar-default">
 	<div class="container-fluid">
		<div class="navbar-header">
	 		<a class="navbar-brand" href="#">
				<span class="glyphicon glyphicon-education"></span>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	 		<ul class="nav navbar-nav">
				<?php switch($_SESSION['statut_emp'])
					{
						case 'simple_lecteur': case 'employe': case 'administrateur': case 'super_utilisateur':
							?>
								<li>
									<!-- Condition: switch -> Tout les statuts -->
									<a href="accueil.php"> Accueil</a>
								</li>

							<?php if($_SESSION['statut_emp']=='employe' || $_SESSION['statut_emp']=='administrateur')
							{
								?>
							<!-- Condition: switch + if -> employe + administrateur -->
							<li>
								<a href="entrer_corps.php">Entrées</a>
							</li>
							<li>
								<a href="sortir_corps.php">Sorties</a>
							</li>
							<li>
								<a href="modifier_corps.php">Modifier</a>
							</li>
							<?php
								}

								if($_SESSION['statut_emp']=='administrateur' || $_SESSION['statut_emp']=='super_utilisateur')
								{
									?>
								<!-- Condition: switch + if -> administrateur + super utilisateur -->
							<li>
								<a href="entrer_employe.php">Ajouter Employé</a>
							</li>
							<li>
								<a href="blacklister.php">Blacklister Employé</a>
							</li>
							<li>
								<a href="modifier_employe.php">Modifier Employé</a>
							</li>
							<?php 
								if($_SESSION['statut_emp']=='administrateur')
								{
							?>
							<li>
								<a href="gerer_box.php">Gérer box</a>
							</li>
							<?php 
								}
							?>
							<?php
								}

								if($_SESSION['statut_emp']=='employe' || $_SESSION['statut_emp']=='administrateur' || $_SESSION['statut_emp']=='super_utilisateur')
								{
									?>
							<!-- Condition: switch + if -> employé + administrateur + super utilisateur -->
										<li>
											<a href="rechercher.php"><span class="glyphicon glyphicon-search"></span> Rechercher</a>
										</li>
							<?php
								} ?>

									<!-- Condition: switch -> Tout les statuts -->
									<li>
										<a href="deconnexion.php"><span class="glyphicon glyphicon-off"></span> Déconnexion</a>
									</li>
								<?php
								break; /* Fin du seul case*/

							/* Pas de statut légal -> pas de navigateur */
							default:
								break;
						}
					?>
		 		</ul>
			</div><!-- /.navbar-collapse -->
	 	</div><!-- /.container-fluid -->
	</nav>
