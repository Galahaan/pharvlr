<?php

// il y a aussi des constantes dans :
//
//     - tapette.php
//     - /erreurs/erreur-....php     (401, 403, 404, 500, index)
//     - .htaccess de la racine
//


// code de validation, pour pouvoir utiliser, grâce à un compte Google, ses outils de suivi de référencement
// (à garder de façon permanente tant qu'on utilise les outils)
define("GOOGLE_VALIDATION_CODE", "mhjYrgfrE7d0TraYlzb7il--H1UDZpC47s1hw92GePw");


//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////                Coordonnées de la pharmacie                 ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////

// Nom de la pharmacie
define("NOM_PHARMA"        , "Pharmacie Le Reste");      // dans <title> + bandeau
define("LOC_PHARMA_1"      , " à ");                     // que dans <title>               60 car. max pour <title> !
define("LOC_PHARMA_2"      , "Saint-Joseph de Porterie, Nantes");   // dans <title> + bandeau

// Adresse de la pharmacie
define("ADR_PHARMA_L1"     , "21 rue du Bêle");
define("ADR_PHARMA_L2"     , "");
define("CP_PHARMA"         , "44300");
define("VIL_PHARMA"        , "Nantes");

// Tel, fax, mail, facebook, google+
define("TEL_PHARMA_DECO"   , "02 40 25 15 80");
define("TEL_PHARMA_UTIL"   , "+33240251580");
define("FAX_PHARMA_DECO"   , "02 40 30 06 56");
define("ADR_MAIL_PHARMA"   , "contact@pharmacielereste.fr");
define("ADR_FB_PHARMA"     , "https://www.facebook.com/Pharmacie-Le-Reste-700447003388902");
define("ADR_GG_PHARMA"     , "https://plus.google.com/113407799173132476603/about");

//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////    Meta description et Mots-Clés pour le référencement     ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////

// (éviter de mettre des apostrophes dans les phrases, j'ai peur que cela gène les robots)

// 200 car. max pour la description !
define("META_DESC_INDEX"   , "La pharmacie, située à Nantes, quartier St-Joseph-de-Porterie, vous conseille et répond à vos besoins en médicaments, services en ligne (ordonnance et commande), location de matériel.");
define("META_DESC_HORAIRES", "Horaires d ouverture de la pharmacie : du lundi au vendredi de 8h30 à 12h30 puis de 14h à 19h, et le samedi de 9h à 16h.");
define("META_DESC_EQUIPE"  , "Valérie, Hélène, Christine et Alice vous accueillent chaque jour avec le sourire.");
define("META_DESC_CONTACT" , "Vous trouverez ci-dessous tous les renseignements pratiques pour vous rendre à la pharmacie, en bus, en voiture, ou à vélo, ainsi que pour nous joindre.");
define("META_DESC_PREP_O"  , "La pharmacie vous propose son service de téléchargement d ordonnance en ligne.");
define("META_DESC_PREP_C"  , "La pharmacie vous propose son service de prise de commande en ligne, autrement appelé clic and collect, ou encore drive.");
define("META_DESC_P_GARDE" , "Trouvez facilement la pharmacie de garde la plus proche de chez vous, ou le commissariat de police éventuel dont elle dépend.");
define("META_DESC_PROMOS"  , "Vous trouverez ici l ensemble des promotions et des réductions en cours à la pharmacie.");
define("META_DESC_GAMMES"  , "Retrouvez ici les gammes de parapharmacie suivies et conseillées par la pharmacie.");
define("META_DESC_INFOS"   , "La pharmacie vous informe sur des sujets de santé en général, ou d actualité, et vous prodigue quelques conseils bien utiles.");
define("META_DESC_MENLEG"  , "Cette page est dédiée aux mentions légales, concernant notamment les données utilisées ou diffusées dans ce site, et le traitement de vos données personnelles.");

define("META_BOTS_CONNEX"  , "noindex, nofollow, none"); // par défaut, les autres pages auront "index, follow, all"
define("META_BOTS_INSCRIP" , "noindex, nofollow, none"); // sauf index.php dont les liens sont traités au cas par cas.

define("MC_NOM_PHARMA"     , "Le Reste");
define("MC_QUARTIER"       , "Saint-Joseph de Porterie");
define("MC_1"              , "44300");
define("MC_2"              , "Beaujoire");
define("MC_3"              , "stade");

//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////                       Mentions légales                     ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////


///////////////                      données spécifiques                   ///////////////

// Pharmacien titulaire
define("PHIEN_TITULAIRE", "Valérie Le Reste");

// N° inscr. Ordre (RPPS)
define("PHIEN_RPPS", "10004122213");

// N° de licence de la pharmacie
define("PHIE_LICENCE", "44#000684");

// N° individuel d'identification relatif à l'assujettissement à la TVA
define("PHIE_TVA", "FR41812480093");

// N° d'inscription au Registre du Commerce et des Sociétés (SIREN)
define("PHIE_SIRET", "81248009300010");

// Code APE
define("PHIE_APE", "4773Z");

// URL de la pharmacie
define("PHIE_URLC", "www.pharmacielereste.fr");

// Hébergeur du site
define("PHIE_HBG_COORD", "OVH - 2 rue Kellermann - BP 80157 - 59053 Roubaix cedex 1");
define("PHIE_HBG_URL", "https://www.ovh.com/fr/");
define("PHIE_HBG_URLC", "ovh.com");

///////////////                       données générales                    ///////////////

// Agence régionale de santé territorialement compétente
define("ARS_COORD", "ARS Bretagne - 6 pl. des Colombes - CS 14253 - 35042 Rennes cedex - <a href='tel:+33290088000'>tel : 02 90 08 80 00</a>");
define("ARS_URL", "https://www.bretagne.ars.sante.fr/");
define("ARS_URLC", "bretagne.ars.sante.fr");

define("ARS_COORD", "ARS des Pays de la Loire - 17 bd Gaston Doumergue - CS 56233 - 44262 Nantes cedex 2 - <a href='tel:+33249104000'>tel : 02 49 10 40 00</a>");
define("ARS_URL", "https://www.pays-de-la-loire.ars.sante.fr/");
define("ARS_URLC", "pays-de-la-loire.ars.sante.fr");

// Agence nationale de sécurité du médicament et des produits de santé (ANSMPS)
define("ANSM_COORD", "143 / 147 bd Anatole France - 93285 St-Denis cedex - <a href='tel:+33155873000'>tel : 01 55 87 30 00</a>");
define("ANSM_URL", "http://ansm.sante.fr/");
define("ANSM_URLC", "ansm.sante.fr");

// Ordre national des pharmaciens
define("ORDRE_COORD", "12 rue Ampère - 75017 Paris - <a href='tel:+33156213434'>tel : 01 56 21 34 34</a>");
define("ORDRE_URL", "http://www.ordre.pharmacien.fr/");
define("ORDRE_URLC", "ordre.pharmacien.fr");

// Ministère des solidarités et de la santé
define("MINIS_COORD", "14 av. Duquesne - 75350 Paris 07 SP - <a href='tel:+33140566000'>tel : 01 40 56 60 00</a>");
define("MINIS_URL", "http://solidarites-sante.gouv.fr/");
define("MINIS_URLC", "solidarites-sante.gouv.fr");

// Commission nationale de l'informatique et des libertés (CNIL)
define("CNIL_COORD", "3 pl. de Fontenoy - TSA 80715 - 75334 Paris cedex 07 - <a href='tel:+33153732222'>tel : 01 53 73 22 22</a>");
define("CNIL_URL", "https://www.cnil.fr/fr");
define("CNIL_URLC", "cnil.fr");

// Pour la VMI :
// - chaque page comportera le logo commun mis en place au niveau communautaire et défini selon la directive européenne
// - un élément sélectionnable, parfaitement identifié, permettra d'accéder au service de vente de médicaments.
//   (les médicaments y seront présentés de manière claire, objective et non trompeuse)


//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////                  Base de données hébergée                  ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////

// adresse du serveur de la BDD (initDB.php)
define("ADR_BDD_HBG", "pharmacihctofbdd.mysql.db");

// nom de la BDD (initDB.php)
define("NOM_BDD_HBG", "pharmacihctofbdd");

// utilisateur de la BDD (initDB.php)
define("USERNAME_BDD_HBG", "pharmacihctofbdd");
define("USERPSWD_BDD_HBG", "Mdp2pharmacihc");

// nom de la table 'clients' pour cette BDD (inscription.php et connexion.php)
define("TABLE_CLIENTS", "clientsVLR01");

//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////                     Infos hébergeur                        ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////

// 'home' du site sur le serveur de l'hébergeur (fonctions.php)
define("HOME", "/home/pharmacihc/"); // utilisé uniquement dans require_onceCLR qui n'est utilisée nulle part !

// pour l'envoi de mails : pages prepaOrdonnance, prepaCommande et contact
// adresse de l'expéditeur des mails via l'hébergeur du site :
define("ADR_EXP_HBG", "pharmacihc@cluster021.hosting.ovh.net");

// nom explicite pour l'expéditeur des mails : (possible avec accents !)
define("LABEL_EXP", "Site pharmacie");
define("LABEL_EXP_PIRATE", "Site pharmacie - Attention");

// adresse du site de la pharmacie :
define("ADRESSE_SITE_PHARMACIE", "http://pharmacielereste.fr/");
define("S_ADRESSE_SITE_PHARMACIE", "https://pharmacielereste.fr/");
define("W_ADRESSE_SITE_PHARMACIE", "http://www.pharmacielereste.fr/");
define("SW_ADRESSE_SITE_PHARMACIE", "https://www.pharmacielereste.fr/");

// adresse mail de la pharmacie :
define("MAIL_DEST_PHARMA", "phcie.lereste@perso.alliadis.net");

// pour vérifier les 1ers mails officiels :
define("MAIL_DEST_CLR",    "clr.tstph@use.startmail.com");

// taille max de la pièce jointe : 5 Mo = 5242880 octets
define("TAILLE_MAX_PJ", 5242880);

// extensions autorisées pour la pièce jointe : cf aussi ligne : " switch ($extension) " en ligne 177 de prepaCommande
define("LISTE_EXT_AUTORISEES", '".jpe, .jpg, .jpeg, .png, .gif, .pdf"');

//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////       Nb caractères min et max dans les formulaires        ///////////////
///////////////                                                            ///////////////
///////////////      (pages prepaOrdonnance, prepaCommande et contact)     ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////

// Nombre de caractères min et max pour les nom et prénom :
define("NB_CAR_MIN", 2);
define("NB_CAR_MAX", 40);
define("NB_CAR_MIN_HTM", 1);
define("NB_CAR_MAX_HTM", 45);

// Nombre de caractères min et max pour le mot de passe :
define("NB_CAR_MIN_MDP", 5);
define("NB_CAR_MAX_MDP", 20);
define("NB_CAR_MIN_MDP_HTM", 2);
define("NB_CAR_MAX_MDP_HTM", 25);

// Nombre de caractères min et max pour le texte libre :
define("NB_CAR_MIN_MESSAGE", 5);
define("NB_CAR_MAX_MESSAGE", 1000);
define("NB_CAR_MIN_MESSAGE_HTM", 1);
define("NB_CAR_MAX_MESSAGE_HTM", 1000);

//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////           Horaires d'ouverture de la pharmacie             ///////////////
///////////////                                                            ///////////////
///////////////           (ctes utilisées dans fonctions.php)              ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////

// 'D' pour le format décimal, 'H' pour le format horaire

// le matin, de 8h30 ...
define('OMATD', 8.5);
define('OMATH', '8h30');

// ... à 12h30
define('FMATD', 12.5);
define('FMATH', '12h30');

// l'après-midi, de 14h ...
define('OAMID', 14);
define('OAMIH', '14h');

// ... à 19h30
define('FAMID', 19.5);
define('FAMIH', '19h30');

// le samedi matin, de 9h ...
define('SA_OMATD', 9);
define('SA_OMATH', '9h');

// ... à 16h
define('SA_FAMID', 16);
define('SA_FAMIH', '16h');

// Compte à rebours avant ouverture / fermeture
define('REBOURSD', 0.25);		// compte à rebours en 'heure décimale', ie que   0.25 = 15 mn
define('PAS_DE_REBOURS', 5);	// en minutes ( ex. ... dans moins de 15, 10, 5 mn )

// Pour les medias braille, on remplace tout le 'tableau' précédent par une simple phrase :
define('HORAIRES_PHARMACIE',
    "La pharmacie est ouverte du lundi au vendredi de 8h30 à 12h30 et de 14h à 19h30, et le samedi de 9h à 16h.");

// Durée de rafraîchissement des pages index et horaires (en secondes)
// (pour que l'heure affichée soit toujours acceptable)
define('REFRESH', 300);

//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////                     Horaires de garde                      ///////////////
///////////////                                                            ///////////////
///////////////                      (pharmaDeGarde)                       ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////

// Heure au-delà de laquelle il faut se rendre au commissariat.
// Si les gardes fonctionnent sans commissariat (ex. Vendée) -> mettre la constante _D à "X"
define('HEURE_SOIR_POLICE_D', 20.5);
define('HEURE_SOIR_POLICE_H', "20h30");
// Nantes : 20h30
// Brest  : 20h00

// Heure jusqu'à laquelle il faut s'adresser au commissariat
define('HEURE_MATIN_POLICE_D', 8);
define('HEURE_MATIN_POLICE_H', "8h");
// Nantes : 8h00
// Brest  : 9h00

define('ADRESSE_POLICE', "6 place Waldeck-Rousseau à Nantes");

//////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                            ///////////////
///////////////                          Contact                           ///////////////
///////////////                                                            ///////////////
///////////////                     (infos pratiques)                      ///////////////
///////////////                                                            ///////////////
//////////////////////////////////////////////////////////////////////////////////////////

// lignes de bus / tram / métro, parking privé, ...
define('CONTACT_INFOS_PRATIQUES',
    "<p>La pharmacie dispose d'un parking pour sa clientèle.</p>
    <p>En <span>chronobus C6</span>, descendez à l'arrêt <span>St Joseph de Porterie</span> :
         la pharmacie est alors à moins d'une minute.</p>");

?>