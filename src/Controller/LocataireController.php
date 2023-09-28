<?php
namespace App\Controller;
use App\Controller\Controller;

use App\Repository\LocataireRepository;
use App\Entity\Locataire;

use App\Entity\Impression;
use App\Repository\ImpressionRepository; 

use App\Repository\CategorieSocioprofessionnelleRepository; 
use App\Entity\CategorieSocioprofessionnelle;

use App\Repository\VilleRepository;
use App\Entity\Ville;

class LocataireController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function connexionForm(): void
    {
        //$this->render(ROOT . "/templates/locataire/connexion", array("title" => "Connexion"));
    }

    public function ajoutForm(): void
    {
        // il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
        $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        $villeRepository = new VilleRepository();
        $villes = $villeRepository->GetVille();

		$impressionRepository = new ImpressionRepository();
		$impressions  = $impressionRepository->GetLesImpressions();

        $categorieSocioprofessionelleRepository = new CategorieSocioprofessionnelleRepository();
		$categorieSocioprofessionnelles = $categorieSocioprofessionelleRepository->getLesCategorieSocioprofessionnelles();

        // on appelle la vue pour afficher le formulaire d'ajout d'un appartement
        $this->render(ROOT . "/templates/Locataire/ajout", array("title" => "Ajout d'un locataire", "lesLocataires" => $lesLocataires, "lesVilles" => $villes,  "impressions" => $impressions,
        "categSociopro" => $categorieSocioprofessionnelles));
    }
    

    public function ajoutTrait()
    {
        //On crée une instance de la classe Locataire à partir des données saisies sur le formulaire
        $loc = new Locataire(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['mail'],
            $_POST['telephone'],
            $_POST['rue'],
            $_POST['salaireMensuel'],

            new Impression($_POST["lstImpression"],null),
            new CategorieSocioprofessionnelle($_POST["lstCategorieSocioprofessionnelle"],null),
            new Ville($_POST["lstVille"])
        );
         //On crée une instance de LocataireRepository
         $unLocataireRepository = new LocataireRepository();
         $ret = $unLocataireRepository->ajoutLocataire($loc);
         $villeRepository = new villeRepository();
         $villes = $villeRepository->GetVille();
         $impressionRepository = new impressionRepository();
         $impressions = $impressionRepository->getLesImpressions();
         $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
         $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();

         // dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
         if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : le locataire n'a pas été enregistré</p>";
            $this->render(ROOT . "/templates/locataire/ajout", array("title" => "Ajout d'un locataire", "msg" => $msg, "loc" => $loc, "impressions" => $impressions, "categorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "villes" => $villes));
        } else {
            $msg = "<p class='text-success'>Le locataire a été enregistré</p>";
            $this->render(ROOT . "/templates/locataire/ajout", array("title" => "Ajout d'un locataire", "msg" => $msg, "impressions" => $impressions, "categorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "villes" => $villes));
        }
    }
    public function liste(): void
    {
        // on crée une instance de AppartementRepository
        $unLocataireRepository = new LocataireRepository();

        // on demande au modèle la liste des appartements
        $lesLocataires = $unLocataireRepository->getLesLocataires();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/locataire/consultListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires));
    }

    public function modifListe(): void
    {
        // on crée une instance de AppartementRepository
        $unLocataireRepository = new LocataireRepository();

        // on demande au modèle la liste des appartements
        $lesLocataires = $unLocataireRepository->getLesLocataires();

        $this->render(ROOT . "/templates/Locataire/modifListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires));
    }

    public function modifForm(): void
    {
        $villeRepository = new villeRepository();
        $villes = $villeRepository->GetVille();

        $impressionRepository = new impressionRepository();
        $impressions = $impressionRepository->getLesImpressions();

        $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
        $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();

        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idLocataire =  $_POST["lstLocataire"];

        $unLocataireRepository = new LocataireRepository();
        $leLocataire = $unLocataireRepository->getUnLocataire($idLocataire);

        // on crée une instance de AppartementRepository
        $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        // on demande au modèle l'appartement à modifier 


        $this->render(ROOT . "/templates/Locataire/modif", 
        array("title" => "Modification d'un locataire", 
        "lesLocataires" => $lesLocataires,
        "leLocataire" => $leLocataire,
         "impressions" => $impressions, 
         "categSociopro" => $categorieSocioprofessionnelles, 
         "lesVilles" => $villes));
    }

    public function modifTrait(): void
    {
        $loc = new Locataire(
            $_POST['idLocataire'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['mail'],
            $_POST['telephone'],
            $_POST['rue'],
            $_POST['salaireMensuel'],
            new Impression($_POST['lstImpression'], null),
            new CategorieSocioprofessionnelle($_POST['lstCategorieSocioprofessionnelle'], null),
            new Ville($_POST['lstVille'], null)
        );

        // on crée une instance de AppartementRepository
        $unLocataireRepository = new LocataireRepository();


        $ret = $unLocataireRepository->modifLocataire($loc);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $unLocataireRepository = new LocataireRepository();
            $lesLocataires = $unLocataireRepository->getLesLocataires();
            $villeRepository = new villeRepository();
            $villes = $villeRepository->GetVille();
    
            $impressionRepository = new impressionRepository();
            $impressions = $impressionRepository->getLesImpressions();
    
            $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
            $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();
    
            $this->render(ROOT . "/templates/Locataire/modif", array("title" => "Modification d'un locataire",  "lesLocataires" => $lesLocataires, "villes" =>$villes, "impressions" => $impressions, "categorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "loc" => $loc, "msg" => $msg ));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée !</p>";
            // on crée une instance de AppartementRepository
            $unLocataireRepository = new LocataireRepository();

            // on demande au modèle la liste des appartements
            $lesLocataires = $unLocataireRepository->getLesLocataires();

            $this->render(ROOT . "/templates/Locataire/modifListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires, "msg" => $msg));
        }
    }
    // SUPPRESSION

    public function supprListe(): void
    {
        // on crée une instance de AppartementRepository
        $unLocataireRepository = new LocataireRepository();

        // on demande au modèle la liste des appartements
        $lesLocataires = $unLocataireRepository->getLesLocataires();

        $this->render(ROOT . "/templates/Locataire/supprListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires));
    }

    public function supprForm(): void
    {
        $villeRepository = new villeRepository();
        $villes = $villeRepository->GetVille();

        $impressionRepository = new impressionRepository();
        $impressions = $impressionRepository->getLesImpressions();

        $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
        $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();

        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idLocataire =  $_POST["lstLocataire"];

        $unLocataireRepository = new LocataireRepository();
        $leLocataire = $unLocataireRepository->getUnLocataire($idLocataire);

        // on crée une instance de AppartementRepository
        $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        // on demande au modèle l'appartement à modifier 


        $this->render(ROOT . "/templates/Locataire/suppr", 
        array("title" => "Modification d'un locataire", 
        "lesLocataires" => $lesLocataires,
        "leLocataire" => $leLocataire,
         "impressions" => $impressions, 
         "categSociopro" => $categorieSocioprofessionnelles, 
         "lesVilles" => $villes));
    }

    public function supprTrait(): void
    { 
        $loc = new Locataire(
            $_POST['idLocataire'])
        ;

        // on crée une instance de AppartementRepository
        $unLocataireRepository = new LocataireRepository();

        $ret = $unLocataireRepository->supprLocataire($loc);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $unLocataireRepository = new LocataireRepository();
            $lesLocataires = $unLocataireRepository->getLesLocataires();
            $villeRepository = new villeRepository();
            $villes = $villeRepository->GetVille();
    
            $impressionRepository = new impressionRepository();
            $impressions = $impressionRepository->getLesImpressions();
    
            $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
            $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();
    
            $this->render(ROOT . "/templates/Locataire/suppr", array("title" => "Modification d'un locataire",  "lesLocataires" => $lesLocataires, "villes" =>$villes, "impressions" => $impressions, "categorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "loc" => $loc, "msg" => $msg ));
        } else {
            $msg = "<p class='text-success'>Le locataire a bien été supprimé !</p>";
            // on crée une instance de AppartementRepository
            $unLocataireRepository = new LocataireRepository();

            // on demande au modèle la liste des appartements
            $lesLocataires = $unLocataireRepository->getLesLocataires();

            $this->render(ROOT . "/templates/Locataire/supprListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires, "msg" => $msg));
        }
        
    }
    

}
