<?php

include('inclus/enteteP.php');

// Pour des raisons de sécurité, dans le cas de l'envoi d'un mail, je teste si la page
// courante n'a pas été usurpée; je suis donc, dans ce cas, obligé de l'écrire EN DUR :
// (et non pas, justement, en m'appuyant sur $_SERVER)
define("PAGE_EN_COURS", "contact.php");

// Si le formulaire vient d'être validé, et avant de savoir si on va envoyer le mail, on "nettoie" les champs :
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
	};

	// Message

	$messageClientTxt = chunk_split(htmlspecialchars(strip_tags($_POST['message'])));
	// NB: chunk_split est utilisée ici pour respecter la RFC 2045.
	//     utilisée de cette façon, sans param. optionnels, elle
	//     a pour rôle de scinder une chaîne, qui aurait été saisie
	//     d'un seul coup, sans retour chariot, en plusieurs lignes de 76 car. max.
	//     Mais si la chaîne fait moins de 76 car. au départ, chunk_split ajoute
	//     quand même un retour chariot, ce qui ajoute 2 caractères ('invisibles').

	if( (strlen($messageClientTxt) < NB_CAR_MIN_MESSAGE) || (strlen($messageClientTxt) > NB_CAR_MAX_MESSAGE ) ){
		$erreurs['message'] = "(de " . NB_CAR_MIN_MESSAGE . " à " . NB_CAR_MAX_MESSAGE . " caractères)";
	}
	// on se donne une version du message en format HTML (plus sympa à lire pour la pharmacie)
	$messageClientHtml = "<b style='font-size: 16px;'>" . nl2br($messageClientTxt) . "</b>";
}

include('inclus/enteteH.php');
?>
	<main id='iMain'>
		<nav class='cBraille'>
			<ol>
				<li><a href="#iContactInfosPratiques">Informations pratiques</a></li>
				<li><a href="#iContactCoordonnees">Coordonnées de la <?= NOM_PHARMA ?></a></li>
				<li><a href="#iContactPlan">Localiser la <?= NOM_PHARMA ?></a></li>
				<li><a href="#iContactFormulaire">Formulaire de contact</a></li>
			</ol>
		</nav>

		<section id='iContactInfosPratiques' class='cSectionContour'><h2>Informations pratiques</h2>
			<?= CONTACT_INFOS_PRATIQUES ?>
		</section>

		<section id='iContactCoordonnees' class='cSectionContour'><h2>Coordonnées de la <?= NOM_PHARMA ?></h2>
			<p><?= NOM_PHARMA ?></p>
			<p><?= ADR_PHARMA_L1 ?></p>
			<p><?= CP_PHARMA ?> <?= VIL_PHARMA ?></p>
			<p id='iContactTel'><a href='tel:<?= TEL_PHARMA_UTIL ?>'><i class='fa fa-phone' aria-hidden='true'></i><?= TEL_PHARMA_DECO ?></a>&nbsp;<img class='cClicIndexTaille' src='img/icones/clicIndex.png' alt=''></p>
			<p><i class='fa fa-fax' aria-hidden='true'></i><?= FAX_PHARMA_DECO ?></p>
		<?php if( AFF_MAIL_PHARMA == "oui" ) : ?>
			<p id='iContactMail'><a href='mailto:<?= ADR_MAIL_PHARMA ?>'><i class='fa fa-envelope' aria-hidden='true'></i><?= ADR_MAIL_PHARMA ?></a></p>
		<?php else : ?>
			<p><?= NON_MAIL_PHARMA ?></p>
		<?php endif ?>

			<?php
/*			<p>
				<a href='<?= ADR_FB_PHARMA ?>'>
					<img class='cFaceGool' src='img/icones/fb.png' alt='facebook'>
					<img class='cFaceGool cCouleurNoire' src='img/icones/fb_n.jpg' alt='facebook'>
				</a>
			</p>
			<p>
				<a href='<?= ADR_GG_PHARMA ?>'>
					<img class='cFaceGool' src='img/icones/gg.png' alt='google+'>
					<img class='cFaceGool cCouleurNoire' src='img/icones/gg_n.jpg' alt='google+'>
				</a>
			</p>
*/			?>
		</section>

		<section id='iContactPlan' class='cSectionContour'><h2>Se rendre sur place ...</h2>
			<p>Si vous utilisez un smartphone, profitez de son GPS pour vous guider :</p>
			<p>- activez la localisation</p>
			<p>- cliquez sur le plan ci-dessous</p>
			<p>- puis sur l'icône &nbsp;<img src='img/icones/itineraire.png' alt='itinéraire'></p>
			<p>... et laissez-vous guider.</p>
			<iframe src=<?= IFRAME_MAPS_PHARMA ?> width='600' height='450' title='nouvelle page google map' allowfullscreen></iframe>
		</section>

		<section id='iContactFormulaire' class='cSectionContour'><h2>Envoyer un message ...</h2>
 
		<?php if( isset($_POST['valider']) && !isset($erreurs)) : ?>

			<?php
			//    le formulaire a été rempli  ET  s'il n'y a pas d'erreurs
			//
			//    => on envoie le mail ! (après avoir préparé les données)

			/////////////////////////////////////////////////////
			//
			// préparation des infos ajoutées dans le mail
			//
			/////////////////////////////////////////////////////

			// ===================  date  =================== //

			// au début j'avais fait ça :
			// $date = date('\S\e\m. W - D d/m/Y - H:i:s') . $fuseau;
			// mais c'était en anglais, alors j'ai voulu utiliser 'locale' :
			// setlocale(LC_TIME, "fra");
			// $date = "Semaine " . strftime('%W - %A %d/%B/%Y - %H:%M:%S') . $fuseau;
			// sauf que comme on est sur un serveur mutualisé, on ne peut pas modifier 'locale', donc ça restait en anglais !
			//
			// d'où l'utilisation d'une fonction à moi :
			$date = "Semaine " . date('W') . " - " . dateFr() . " - " . heureActuelle('H');

			// ===============  IP du client  =============== //     (3 possibilités)

			$ipClient = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";
			if( empty($ipClient) ){
				$ipClient = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? "HTTP_X " . $_SERVER['HTTP_X_FORWARDED_FOR'] : "";
				if( empty($ipClient) ){
					$ipClient = isset($_SERVER['HTTP_CLIENT_IP']) ? "HTTP_C " . $_SERVER['HTTP_CLIENT_IP'] : "";	
				}
				else{
					// si jamais HTTP_X... était remplie, on la compare avec HTTP_C... et
					// si jamais les 2 sont différentes, on garde les 2 infos :
					if( isset($_SERVER['HTTP_CLIENT_IP']) ){
						if( strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $_SERVER['HTTP_CLIENT_IP']) != 0 ){
							$ipClient .= " ■ HTTP_C " . $_SERVER['HTTP_CLIENT_IP'];
						}
					}
				}
			}
			else{
				// si jamais REMOTE était remplie, on la compare avec HTTP_X... et
				// si jamais les 2 sont différentes, on garde les 2 infos :
				if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ){
					if( strcasecmp($ipClient, $_SERVER['HTTP_X_FORWARDED_FOR']) != 0 ){
						$ipClient .= " ■ HTTP_X " . $_SERVER['HTTP_X_FORWARDED_FOR'];
					}
				}
			}

			// ===================  FAI  ==================== //

			$faiClientBrut = gethostbyaddr(getIpAdr());
			// a priori, quand ça vient du réseau mobile, ce n'est pas le FAI mais l'IP,
			// d'où le message plus explicite :
			if( strcasecmp($faiClientBrut, $ipClient) == 0 ){
				$faiClientBrut = "inconnu (message issu du réseau mobile)";
			}
			// else{
			// $faiClientBrut contient, en plus du FAI, plusieurs autres infos, d'où :
			// $faiClient = substr(stristr($faiClientBrut, "ipv"), 5);
			// }


			///////////////////////////////////////////////////////////
			//
			// ENFIN, construction du mail
			//
			// (en suivant qqs étapes préparatoires encore une fois)
			//
			///////////////////////////////////////////////////////////

			// apparemment, à une époque, le CRLF était différent selon les clients mails (\r\n, ou \n, voire \r)
			// mais après plusieurs tests au cours desquels j'ai essayé les 2 1ères versions,
			// il semble qu'il n'y ait plus de problème, les 2 fonctionnent bien ... cf fichier texte "CRLF.txt"
			$rc = "\r\n";

			// NB: Pour ce qui est du charset, le ISO-8859-1 est supporté par tous les webmails,
			//     contrairement à l'UTF-8, mais ne permet pas les accents français,
			//     alors que l'UTF-8 les supportent ... donc je choisis UTF-8


			// =================  Objet du mail  ================= //

			// L'objet du message est constitué d'un préfixe (les 4 derniers car. de l'IP) suivi des prénom et nom de l'expéditeur :
			// (la fonction mb... sert à autoriser les caractères accentués)
			$objet = mb_encode_mimeheader("Contact - [" .
											substr($ipClient, -4, 4) . "]  " .
											$civilite . " " .
											$prenom . " " .
											$nom, "UTF-8", "B");

			// ==============  Création du header  =============== //

			// cf dossier "envoi de mails en PHP"
			$header =	"From: " .
						mb_encode_mimeheader(LABEL_EXP, "UTF-8", "B") .
						"<" . ADR_EXP_HBG . ">" . $rc .
						"Reply-To: $adrMailClient" . $rc .
						"MIME-Version: 1.0" . $rc .
						"X-Mailer: PHP/" . phpversion() . $rc .
						"Content-type: text/html; charset=UTF-8" . $rc .
		           		"Content-Transfer-Encoding: 8bit";

			// =============== Création du message =============== //

			// version HTML seule
			$message =	$date . " - <b>" . $civilite . " " . $prenom . " " . $nom . "</b>  -  " . $adrMailClient . "<br><br>" .
						$messageClientHtml . "<br>" .
						"IP  client     = " . $ipClient . "<br>" .
						"FAI client     = " . $faiClientBrut;

			// ================== Envoi du mail ================== //

			// En réalité, il faut envisager la préparation de 2 mails différents,
			// l'un dans le cas 'normal', et l'autre dans le cas où un 'pirate'
			// voudrait envoyer le mail à partir du site de son choix.
			// 
			// Mais dans les 2 cas, on enverra la même confirmation d'envoi du mail,
			// d'où le stockage de cette confirmation dans une variable (bon 2 en fait !) :

			// on effacera les précédentes sections de la page (+ le petit trait au-dessus de la section en cours)
			$effaceContenuPage =
				"<style type='text/css'>" .
						"#iContactInfosPratiques, #iContactCoordonnees, #iContactPlan," .
						"#iContactFormulaire::before, #iContactFormulaire h2 { display: none }" .
				"</style>";
			// puis on affichera le message de confirmation
			// (on sait de quoi on parle puisque 'Contact' est souligné dans le menu de nav.)
			//
			// NB: pour le braille, on positionne le focus
			//     (comme le mot clé HTML5 'autofocus' ne fonctionne que sur des balises de type <input>,
			//      on utilise du javascript)
			$messageConfirmation =
				"<div class='cMessageConfirmation'>" .
						"<p id='iFocus'>Merci, votre message a bien été envoyé.</p>" .
						"<p>Nous vous répondrons dans les meilleurs délais, " .
							"sous réserve qu'il n'y ait pas d'erreur dans l'adresse mail fournie.</p>" .
				"</div>";

			$messageConfirmationErreur =
				"<div class='cMessageConfirmation'>" .
						"<p id='iFocus'>Aïe, il y a eu un problème ...</p>" .
						"<p>Le serveur est probablement indisponible, veuillez réessayer ultérieurement, merci.</p>" .
				"</div>";

			// Donc, 1er cas : tentative de piratage :
			// si le formulaire n'est pas posté de notre site, on envoie un mail avec un avertissement :
			if(    strcmp( $_SERVER['HTTP_REFERER'], ADRESSE_SITE_PHARMACIE . PAGE_EN_COURS ) != 0
				&& strcmp( $_SERVER['HTTP_REFERER'], S_ADRESSE_SITE_PHARMACIE . PAGE_EN_COURS ) != 0
				&& strcmp( $_SERVER['HTTP_REFERER'], W_ADRESSE_SITE_PHARMACIE . PAGE_EN_COURS ) != 0
				&& strcmp( $_SERVER['HTTP_REFERER'], SW_ADRESSE_SITE_PHARMACIE . PAGE_EN_COURS ) != 0 ){

				$headerAlerte =	"From: " .
								mb_encode_mimeheader(LABEL_EXP_PIRATE, "UTF-8", "B") .
								"<" . ADR_EXP_HBG . ">" . $rc .
								"Reply-To: " . $rc .
								"MIME-Version: 1.0" . $rc .
								"X-Mailer: PHP/" . phpversion() . $rc .
								"Content-Type: text/html; charset='UTF-8'" . $rc .
								"Content-Transfer-Encoding: 8bit";
				$messageAlerte =	"<br><b>&nbsp;&nbsp;ATTENTION !<br>" .
									"Ce formulaire a été envoyé à partir d'un site web DIFFERENT de celui de la pharmacie : " . "<br>" .
									$_SERVER['HTTP_REFERER'] . "</b><br>" .
									"_______________________________________________________________________________" . "<br><br>" .
									$date . " - " . $civilite . " " . $prenom . " " . $nom . "  -  " . $adrMailClient . "<br><br>" .
									$messageClientTxt . "<br><br>" .
									"IP  client     = " . $ipClient . "<br>" .
									"FAI client     = " . $faiClientBrut;
				if( mail(MAIL_DEST_PHARMA, "Contact - Tentative de piratage ?", $messageAlerte, $headerAlerte) ){
					echo $effaceContenuPage;
					echo $messageConfirmation;
				}
				else{
					echo $effaceContenuPage;
					echo $messageConfirmationErreur;
				};
			}
			else{

			    // 2ème cas : envoi de l'e-mail 'normal' :

				if( mail(MAIL_DEST_PHARMA, $objet, $message, $header) ){
					echo $effaceContenuPage;
					echo $messageConfirmation;
				}
				else{
					echo $effaceContenuPage;
					echo $messageConfirmationErreur;
				}
			};
			?>

		<?php else : ?>

			<?php

			// - soit le formulaire n'a pas encore été rempli :
			//        => on pré-remplit les champs avec les données de session (sans savoir si $_SESSION existe !)
			//			 (mais si le formulaire a déjà été rempli, on ne modifie pas les valeurs saisies, d'où le if)

			if( ! isset( $civilite )		){		$civilite		= $_SESSION['client']['civilite'];		};
			if( ! isset( $nom )				){		$nom			= $_SESSION['client']['nom'];			};
			if( ! isset( $prenom )			){		$prenom			= $_SESSION['client']['prenom'];		};
			if( ! isset( $adrMailClient )	){		$adrMailClient	= $_SESSION['client']['mail'];			};

			// - soit il y a eu des erreurs dans le formulaire :
			//   => alors on ré-affiche les valeurs saisies (grâce à "value"),
			//		ainsi qu'un message d'erreur pour les valeurs concernées,
			//		le tout en activant l'autofocus, pour se déplacer
			//		automatiquement sur le 1e champ en erreur.

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
						>
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
						>
					<?php if( isset($erreurs['nom']) ) { echo "<sub>" . $erreurs['nom'] . "</sub>"; } ?>
				</div>
				<div class='cChampForm'>
					<label for='iMail'>Mail</label>
						<input type='email' id='iMail' name='adrMailClient' required <?= isset($adrMailClient) ? "value=" . $adrMailClient : ""?>
							<?php	if( isset($erreurs['adrMailClient']) && $focusErreurMis == false ){
										echo " autofocus";
										$focusErreurMis = true;
									}
							?>
						>
					<?php if( isset($erreurs['adrMailClient']) ) { echo "<sub>" . $erreurs['adrMailClient'] . "</sub>"; } ?>
				</div>
				<div class='cChampForm'>
					<label for='iMessageTextarea'>Message</label>
						<textarea rows='8' minlength='<?= NB_CAR_MIN_MESSAGE_HTM ?>' maxlength='<?= NB_CAR_MAX_MESSAGE_HTM ?>' id='iMessageTextarea' name='message' required placeholder='...'
							<?php	if( isset($erreurs['message']) && $focusErreurMis == false ){
										echo " autofocus";
										$focusErreurMis = true;
									}
							?>
						><?= isset($messageClientTxt) ? $messageClientTxt : ""?></textarea>
					<?php if( isset($erreurs['message']) ) { echo "<sub>" . $erreurs['message'] . "</sub>"; } ?>
				</div>
				<div id='iValider'>
					<button class='cDecoBoutonValid' name='valider'>Envoyer</button>
				</div>
			</form>
		<?php endif ?>
		</section>

	</main>

	<?php include('inclus/pdp.php'); ?>

	<script src='scriptsJs/scripts.js'></script>

</body>
</html>