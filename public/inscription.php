<?php

include('inclus/enteteP.php');

// ici on est obligé d'utiliser la fonction native telle quelle, sinon elle ne peut pas jouer son rôle de "_once" :
require_once("./inclus/initDB.php");

// Si le formulaire vient d'être validé, et avant de savoir si on va
// sauvegarder les infos en BDD, on "nettoie" les champs :
if( isset($_POST['valider']) ){

	// Civilité

	$civilite = $_POST['civilite'];

	// Prénom

	$prenomFiltre = filtrerPrenom($_POST['prenom']);
	$prenom = $prenomFiltre[0];
	if( isset($prenomFiltre[1]) ) $erreurs['prenom'] = $prenomFiltre[1];

	// Nom

	$nomFiltre = filtrerNom($_POST['nom']);
	$nom = $nomFiltre[0];
	if( isset($nomFiltre[1]) ) $erreurs['nom'] = $nomFiltre[1];

	// Mail

	$adrMailClient = $_POST['adrMailClient'];

	if( ! mailValide($adrMailClient) ){
		$erreurs['adrMailClient'] = "(mail invalide)";
	}
	else{
		// si toutes les infos sont ok, il faudra créer un nouvel enregistrement, à la condition
		// que le mail, qui sert d'identifiant, ne soit pas déjà présent en BDD, d'où ce petit test :

		$phraseRequete = "SELECT mail FROM " . TABLE_CLIENTS . " WHERE mail = '" . $adrMailClient . "'";
		$requete = $dbConnex->prepare($phraseRequete);
		$requete->execute();
		$mailExisteDeja = $requete->fetchAll();
	}

	// N° de tel mobile

	if( ! telValide($_POST['telMobile']) ){
		$erreurs['telMobile'] = "(n° invalide)";
	}
	else{
		// ex. de saisie (pourrie) initiale : 0 6 123 4 5678
		// or on veut stocker               : 06 12 34 56 78
		$telMobile = formaterTel($_POST['telMobile']);
	}

	// Mot de passe :

	if( ! mdpValide($_POST['password']) ){
		$erreurs['password'] = "(de " . NB_CAR_MIN_MDP . " à " . NB_CAR_MAX_MDP . " car. dont 1 Maj., 1 min. et 1 chiffre)";
	}
	$passwordCrypte = password_hash($_POST['password'], PASSWORD_DEFAULT);
}

include("inclus/enteteH.php");
?>
	<main id='iMain'>
		<section id='iInscription' class='cSectionContour'><h2>Création de votre compte</h2>

		<?php if( isset($_POST['valider']) && !isset($erreurs) && !$mailExisteDeja ) : ?>

			<?php
			//    le formulaire a été rempli  ET  il n'y a pas d'erreurs  ET  le mail n'existait pas encore en BDD

			// la date de création sera insérée automatiquement lors de la création de l'enregistrement
			// avec comme valeur 'CURRENT_TIMESTAMP'

			// requête pour créer un nouvel enregistrement :

			// au début, je faisais ça, et ça marchait très bien, tant que le nom de la table
			// était écrit en "dur" :
			// le pb, c'est qu'on veut stocker le nom de la table dans une constante d'un fichier de config ...
			// mais en utilisant la même technique pour le nom de la table que pour les valeurs des champs,
			// ie avec le bindValue, ça ajoute des guillemets autour du nom de la table ... et ça, ça ne passe pas en SQL !
			// (mais il en faut autour des valeurs des champs)

			// $requete = $dbConnex->prepare("INSERT INTO clients (civilite, nom, prenom, mail, pwd) VALUES (:civiliteB, :nomB, :prenomB, :mailB, :passwordB)");
			// $requete->bindValue("civiliteB", $civilite, PDO::PARAM_STR);
			// ...
			// $requete->bindValue("passwordB", $passwordCrypte, PDO::PARAM_STR);

			// d'où la solution : construire une chaîne de caractères complète, avec des guillemets là où il en faut !
			// (avant je délimitais les ch. de car. de la requête par des " et les variables par des ' mais
			//  j'ai dû inverser le jour où j'ai décidé d'accepter le car. ' dans les noms : ex. Mc Kulloc'h )
			$phraseRequete = 'INSERT INTO ' . TABLE_CLIENTS .
							 ' (civilite, nom, prenom, mail, telMobile, pwd) VALUES ("' .
							 $civilite . '", "' .
							 $nom . '", "' .
							 $prenom . '", "' .
							 $adrMailClient . '", "' .
							 $telMobile . '", "' .
							 $passwordCrypte . '")';
			$requete = $dbConnex->prepare($phraseRequete);
			$requete->execute();

			echo "<div class='cMessageConfirmation'>";
				// NB: pour le braille, on positionne le focus (merci HTML5 !) comme ça ils n'ont pas à relire tout le début de la page pour accéder au message de confirmation.
			echo "<p id='iFocus'>Merci, votre compte a bien été créé.</p>";
			echo "<p>Vous pouvez dorénavant vous connecter ...</p>";
			echo "</div>";
			echo "<a href='connexion.php'>>  connexion  <</a>";

			?>

		<?php else : ?>

			<?php

			// - soit il y a eu des erreurs dans le formulaire
			//   => alors on ré-affiche les valeurs saisies (grâce à "value"),
			//      ainsi qu'un message d'erreur pour les valeurs concernées,
			//      le tout en activant l'autofocus, pour se déplacer
			//      automatiquement jusqu'au formulaire.
			//
			// - soit le mail existait déjà en BDD
			//   => il faut re-proposer le formulaire comme dans le cas où
			//      il y a eu des erreurs
			//
			// - soit le formulaire n'a pas encore été rempli
			//   => on laisse les cases vides.

			// Si jamais il y a plusieurs erreurs, on ne placera le focus que sur la 1ère,
			// d'où l'utilisation de ce booleen :
			$focusErreurMis = false;
			?>

			<sup>Veuillez renseigner tous les champs ci-dessous svp.</sup>
			<form method='POST'>
				<div class='cChampForm'>
					<input type='radio' id='iCiviliteMme'  name='civilite' value='Mme'  required
						<?= $civilite == "Mme"  ? "checked" : ""?> >
					<label for='iCiviliteMme' >Mme</label>
					<input type='radio' id='iCiviliteMlle' name='civilite' value='Mlle' required
						<?= $civilite == "Mlle" ? "checked" : ""?> >
					<label for='iCiviliteMlle'>Melle</label>
					<input type='radio' id='iCiviliteM'    name='civilite' value='M.'   required
						<?= $civilite == "M."   ? "checked" : ""?> >
					<label for='iCiviliteM'   >M.</label>
				</div>
				<div class='cChampForm'>
					<label for='iPrenom'>Prénom</label>
						<input type='text' id='iPrenom' name='prenom' minlength='<?= NB_CAR_MIN_HTM ?>' maxlength='<?= NB_CAR_MAX_HTM ?>' required <?= isset($prenom) ? 'value="' . $prenom . '"' : ""?>
							<?php	if( isset($erreurs['prenom']) && $focusErreurMis == false ){
										echo " autofocus";
										$focusErreurMis = true;
									}
							?>
						placeholder='...'>
					<?php if( isset($erreurs['prenom']) ) { echo "<sub>" . $erreurs['prenom'] . "</sub>"; } ?>
				</div>
				<div class='cChampForm'>
					<label for='iNom'>Nom</label>
						<input type='text' id='iNom' name='nom' minlength='<?= NB_CAR_MIN_HTM ?>' maxlength='<?= NB_CAR_MAX_HTM ?>' required <?= isset($nom) ? 'value="' . $nom . '"' : ""?>
							<?php	if( isset($erreurs['nom']) && $focusErreurMis == false ){
										echo " autofocus";
										$focusErreurMis = true;
									}
							?>
						placeholder='...'>
					<?php if( isset($erreurs['nom']) ) { echo "<sub>" . $erreurs['nom'] . "</sub>"; } ?>
				</div>
				<div class='cChampForm'>
					<label for='iMail'>Adresse mail</label>
						<input type='email' id='iMail' name='adrMailClient' required <?= isset($adrMailClient) ? "value=" . $adrMailClient : ""?>
							<?php	if( isset($erreurs['adrMailClient']) && $focusErreurMis == false ){
										echo " autofocus";
										$focusErreurMis = true;
									}
							?>
						placeholder='...'>
					<?php if( isset($erreurs['adrMailClient']) ) { echo "<sub>" . $erreurs['adrMailClient'] . "</sub>"; } ?>
					<?php if( $mailExisteDeja ) { echo "<sub>Aïe, cet identifiant est déjà pris, veuillez en choisir un autre svp ...</sub>"; } ?>
				</div>
				<div class='cChampForm'>
					<label for='iTelMobile'>n° de mobile</label>
						<input type='text' id='iTelMobile' name='telMobile' required <?= isset($telMobile) ? "value=" . $telMobile : ""?>
							<?php	if( isset($erreurs['telMobile']) && $focusErreurMis == false ){
										echo " autofocus";
										$focusErreurMis = true;
									}
							?>
						placeholder='...'>
					<?php if( isset($erreurs['telMobile']) ) { echo "<sub>" . $erreurs['telMobile'] . "</sub>"; } ?>
				</div>
				<div class='cChampForm'>
					<label for='idPassword'>Mot de passe</label>
						<input type='password' id='idPassword' name='password' minlength='<?= NB_CAR_MIN_MDP_HTM ?>' maxlength='<?= NB_CAR_MAX_MDP_HTM ?>' required
							<?php	if( isset($erreurs['password']) && $focusErreurMis == false ){
										echo " autofocus";
										$focusErreurMis = true;
									}
							?>
						placeholder='...'>
					<?php if( isset($erreurs['password']) ) { echo "<sub>" . $erreurs['password'] . "</sub>"; } ?>
				</div>
				<div id='iValider'>
					<button class='cDecoBoutonValid' name='valider'>Valider</button>
				</div>
			</form>
		</section>

		<?php endif ?>

	</main>

	<?php include('inclus/pdp.php'); ?>

	<script src='scriptsJs/scripts.js'></script>

</body>
</html>