<?php

use App\Controller\AccueilController;
use App\Controller\ContratController;
use App\Controller\LocataireController;
use App\Controller\AppartementController;
use App\Controller\UtilisateurController;
use App\Controller\ProprietaireController;



require '../vendor/autoload.php';

define('ROOT', $_SERVER['DOCUMENT_ROOT']);
if (isset($_GET['theme'])) {
	switch ($_GET['theme']) {
		case "appartement":
			// ----------------------------------------------------------------------------------
			// le paramètre thème contient appartement 
			// gestion des Appartements (on utilise le contrôleur AppartementController.php ) -
			// ----------------------------------------------------------------------------------
			require(ROOT . "/src/Controller/AppartementController.php");
			$leControleur = new AppartementController();

			switch ($_GET['action']) {
					// ---------------------------------------------------------------
					// - la méthode appelée dépend du contenu du paramètre action -
					// -------------------------------------------------------------
					case "liste":
						// Affichage des caractéristiques de tous les appartements 
						$leControleur->liste();
						break;
					case "ajout":
						// Affichage du formulaire d'ajout d'un appartement
						$leControleur->ajoutForm();
						break;
					case "ajoutTrait":
						// traitement des données saisies sur le formulaire d'ajout d'un appartement
						// Vérification et enregistrement des informations saisies
						$leControleur->ajoutTrait();
						break;
					case "modif":
						// Affichage du formulaire qui liste des appartements en vue d'une modification
						$leControleur->modifListe();
						break;
					case "modifForm":
						// Affichage du formulaire de modification d'un appartement
						$leControleur->modifForm();
						break;
					case "modifTrait":
						// traitement des données saisies sur le formulaire de modification d'un appartement
						// Vérification et enregistrement des informations saisies
						$leControleur->modifTrait();
						break;
	
					case "liste":
							// Affichage des caractéristiques de tous les appartements libre 
							$leControleur->listeAppartLib();
							break;
	
					case "suppr":
							 $leControleur->supprAppartListe();
							 break;
					
					
					 case"supprAppartForm";
						  $leControleur->supprAppartForm();
						   break;
					
					 case"supprAppartTrait";
						   $leControleur->supprAppartTrait();
							break;

					case"listeDesSecteur";
					    $leControleur->listeDesSecteur();
						break;

					case"listeDesSectTrait";
				        $leControleur->listeDesSectTrait();
						break;

			}
			break;
		case "utilisateur":
			// ----------------------------------------------------------------------------------
			// - gestion des utilisateurs (on utilise le contrôleur UtilisateurController.php ) -
			// ----------------------------------------------------------------------------------
			require(ROOT . "/src/Controller/UtilisateurController.php");
			$leControleur = new UtilisateurController();

			switch ($_GET['action']) {
				case "ajout":
					// Affichage du formulaire d'ajout d'un utilisateur 
					$leControleur->ajoutForm();
					break;
				case "ajoutTrait":
					// traitement des données saisies sur le formulaire d'ajout d'un utilisateur
					// Vérification et enregistrement des informations saisies
					$leControleur->ajoutTrait();
					break;
				case "liste":
					// traitement des données saisies sur le formulaire d'ajout d'un utilisateur
					// Vérification et enregistrement des informations saisies
					$leControleur->liste();
					break;
			}
			break;


		case "connexion":
			// -------------------------------------------------------------------------------------------------
			// - gestion de la connexion à l'application (on utilise le contrôleur UtilisateurController.php ) -
			// -------------------------------------------------------------------------------------------------
			require(ROOT . "/src/Controller/UtilisateurController.php");
			$leControleur = new UtilisateurController();

			switch ($_GET['action']) {
				case "form":
					// Affichage du formulaire de connexion
					$leControleur->connexionForm();
					break;
				case "trait":
					// traitement des données saisies sur le formulaire de connexion
					// Vérification des informations saisies
					$leControleur->connexionTrait();
					break;
				default:
					// action contient une valeur non connue : on affiche la page d'accueil
					afficheAccueil();
					break;
			}
			break;case "proprietaire":
				// ----------------------------------------------------------------------------------
				// le paramètre thème contient proprietaire 
				// gestion des propriétaires (on utilise le contrôleur ProprietaireController.php ) -
				// ----------------------------------------------------------------------------------
				require(ROOT . "/src/Controller/ProprietaireController.php");
				$leControleur = new ProprietaireController();
	
				switch ($_GET['action']) {
						// ---------------------------------------------------------------
						// - la méthode appelée dépend du contenu du paramètre action -
						// -------------------------------------------------------------
					case "liste":
						// Affichage des caractéristiques de tous les appartements 
						$leControleur->liste();
						break;
					case "ajout":
						// Affichage du formulaire d'ajout d'un appartement
						$leControleur->ajoutForm();
						break;
					case "ajoutTrait":
						// traitement des données saisies sur le formulaire d'ajout d'un appartement
						// Vérification et enregistrement des informations saisies
						$leControleur->ajoutTrait();
						break;
						case "modif":
							// traitement des données saisies sur le formulaire d'ajout d'un appartement
							// Vérification et enregistrement des informations saisies
							$leControleur->modifListe();
							break;
						case "modifForm":
							// traitement des données saisies sur le formulaire d'ajout d'un appartement
							// Vérification et enregistrement des informations saisies
							$leControleur->modifForm();
							break;
						case "modifTrait":
							// traitement des données saisies sur le formulaire d'ajout d'un appartement
							// Vérification et enregistrement des informations saisies
							$leControleur->modifTrait();
							break;
						case "suppr":
							// traitement des données saisies sur le formulaire d'ajout d'un appartement
							// Vérification et enregistrement des informations saisies
							$leControleur->supprListe();
							break;
						case "supprForm":
							// traitement des données saisies sur le formulaire d'ajout d'un appartement
							// Vérification et enregistrement des informations saisies
							$leControleur->supprForm();
							break;
						case "supprTrait":
							// traitement des données saisies sur le formulaire d'ajout d'un appartement
							// Vérification et enregistrement des informations saisies
							$leControleur->supprTrait();
							break;	
				}
				break;
			case "locataire":

				require(ROOT . "/src/Controller/LocataireController.php");
				$leControleur = new LocataireController();
				switch ($_GET['action']) {
					// ---------------------------------------------------------------
					// - la méthode appelée dépend du contenu du paramètre action -
					// -------------------------------------------------------------
				case "liste":
					// AFFICHAGE DES CARACTÉRISTIQUES DE TOUS LES LOCATAIRES
					$leControleur->liste();
					break;
				case "ajout":
					// AFFICHAGE DU FORMULAIRE D'AJOUT D'UN LOCATAIRE
					$leControleur->ajoutForm();
					break;
				case "ajoutTrait":
					// TRAITEMENT DES DONNÉES SAISIES SUR LE FORMULAIRE D'AJOUT D'UN LOCATAIRE
					// VÉRIFICATION ET ENREGISTREMENT DES INFORMATIONS SAISIES
					$leControleur->ajoutTrait();
					break;
				case "modif":
					// AFFICHAGE DU FORMULAIRE QUI LISTE DES LOCATAIRES EN VUE D'UNE MODIFICATION
					$leControleur->modifListe();
					break;
				case "modifForm":
					// AFFICHAGE DU FORMULAIRE DE MODIFICATION D'UN LOCATAIRE
					$leControleur->modifForm();
					break;
				case "modifTrait":
					// TRAITEMENT DES DONNÉES SAISIES SUR LE FORMULAIRE DE MODIFICATION D'UN LOCATAIRE
					// VÉRIFICATION ET ENREGISTREMENT DES INFORMATIONS SAISIES
					$leControleur->modifTrait();
					break;
				case "suppr":
					// TRAITEMENT DES DONNÉES SAISIES SUR LE FORMULAIRE DE MODIFICATION D'UN LOCATAIRE
					// VÉRIFICATION ET ENREGISTREMENT DES INFORMATIONS SAISIES
					$leControleur->supprListe();
					break;
				case "supprForm":
					// TRAITEMENT DES DONNÉES SAISIES SUR LE FORMULAIRE DE MODIFICATION D'UN LOCATAIRE
					// VÉRIFICATION ET ENREGISTREMENT DES INFORMATIONS SAISIES
					$leControleur->supprForm();
					break;
				case "supprTrait":
					// TRAITEMENT DES DONNÉES SAISIES SUR LE FORMULAIRE DE MODIFICATION D'UN LOCATAIRE
					// VÉRIFICATION ET ENREGISTREMENT DES INFORMATIONS SAISIES
					$leControleur->supprTrait();
					break;
				default:
				// action contient une valeur non connue : on affiche la page d'accueil
				afficheAccueil();
				break;
				}
				break;
			
			case "contrat":
				// ----------------------------------------------------------------------------------
				// - gestion des utilisateurs (on utilise le contrôleur UtilisateurController.php ) -
				// ----------------------------------------------------------------------------------
				require(ROOT . "/src/Controller/ContratController.php");
				$leControleur = new ContratController();
	
				switch ($_GET['action']) {
					case "ajout":
						// Affichage du formulaire d'ajout d'un utilisateur 
						$leControleur->ajoutForm();
						break;
					case "ajoutTrait":
						// traitement des données saisies sur le formulaire d'ajout d'un utilisateur
						// Vérification et enregistrement des informations saisies
						$leControleur->ajoutTrait();
						break;
					case "liste":
					// traitement des données saisies sur le formulaire d'ajout d'un utilisateur
					// Vérification et enregistrement des informations saisies
						$leControleur->liste();
						break;
					case "modif":
						// Affichage du formulaire qui liste des appartements en vue d'une modification
						$leControleur->modifListe();
						break;
					case "modifForm":
						// Affichage du formulaire de modification d'un appartement
						$leControleur->modifForm();
						break;
					case "modifTrait":
						// traitement des données saisies sur le formulaire de modification d'un appartement
						// Vérification et enregistrement des informations saisies
						$leControleur->modifTrait();
						break;
					case "suppr":
						// Affichage du formulaire qui liste des appartements en vue d'une modification
						$leControleur->supprListe();
						break;
					case "supprForm":
						// Affichage du formulaire de modification d'un appartement
						$leControleur->supprForm();
						break;
					case "supprTrait":
						// traitement des données saisies sur le formulaire de modification d'un appartement
						// Vérification et enregistrement des informations saisies
						$leControleur->supprTrait();
						break;
				}
				break;
			
		default:
			// action contient une valeur non connue : on affiche la page d'accueil
			afficheAccueil();
			break;
	}
} else {
	// action n'est pas fourni : on affiche la page d'accueil
	afficheAccueil();
}
function afficheAccueil()
{
	// on appelle le contrôleur AccueilControleur
	require(ROOT . "/src/Controller/AccueilController.php");
	session_start();
	session_destroy();
	session_start();
	$leControleur = new AccueilController();
	$leControleur->accueil();
}
