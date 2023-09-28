<?php
namespace App\Controller;

use App\Entity\Proprietaire;
use App\Controller\Controller;
use App\Entity\GestionProprio;
use App\Entity\Ville;
use App\Repository\ProprietaireRepository;
use App\Repository\GestionProprioRepository;
use App\Repository\VilleRepository;


class ProprietaireController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function ajoutForm(): void
    {
        // il faut demander au modèle la liste du mode de gestion et la ville pour alimenter la liste déroulante
        $gestionProprioRepository = new GestionProprioRepository();
        $gestionProprio = $gestionProprioRepository->GetGestionProprio();
        $villeRepository = new VilleRepository();
        $ville = $villeRepository->GetVille();

        // on appelle la vue pour afficher le formulaire d'ajout d'un proprietaire
        $this->render(ROOT . "/templates/proprietaire/ajout", array("title" => "Ajout d'un proprietaire", "lesModesGestions" => $gestionProprio,
                                                                                                          "lesVilles" => $ville));
    }
    public function ajoutTrait()
    {
        // on crée une instance de la classe Proprietaire à partir des données saisies sur le formulaire
        $proprio = new Proprietaire(
            null,
            $_POST['nom'],
            $_POST['rue'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            new GestionProprio($_POST['lstGestionProprio'], null),
            new Ville($_POST['lstVille'], null)
        );
                // on crée une instance de GestionProprioRepository et laVilleRepository
        $unProprietaireRepository = new proprietaireRepository();
        
        $gestionProprioRepository = new GestionProprioRepository();
        $gestionProprio = $gestionProprioRepository->GetGestionProprio();
        $villeRepository = new VilleRepository();
        $ville = $villeRepository->GetVille();
        // on appelle la méthode qui permet d'ajouter le proprietaire
        // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
        // ret contient true si l'ajout s'est bien passé
        $ret = $unProprietaireRepository->verifProprietaire($proprio);
        
        if ($ret == false) {
            // affichage d'un message d'erreur : le propriétaire n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
            $msg = "<p class='text-danger'>ERREUR : il existe déja un propriétaire avec le même nom</p>";
            $this->render(ROOT . "/templates/Proprietaire/ajout", array("title" => "Ajout d'un propriétaire", "lstGestionProprio" => $gestionProprio, "msg" => $msg, "leProprio" => $proprio, $gestionProprio,$ville));
        } else {
            $ret = $unProprietaireRepository->ajoutProprietaire($proprio);

            $gestionProprioRepository = new GestionProprioRepository();
            $gestionProprio = $gestionProprioRepository->GetGestionProprio();
            $villeRepository = new VilleRepository();
            $ville = $villeRepository->GetVille();
            // dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
            if ($ret == false) {
                // affichage d'un message d'erreur : le propriétaire n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
                $msg = "<p class='text-danger'>ERREUR : Le propriétaire n'a pas été enregistré</p>";
                $this->render(ROOT . "/templates/Proprietaire/ajout", array("title" => "Ajout d'un propriétaire", "lstGestionProprio" => $gestionProprio, "msg" => $msg, "lesGestionProprio" => $gestionProprio, "lesVilles" =>$ville));
            } else {
                // pas de  : le propriétaire n'a pas été ajouté
                $msg = "<p class='text-success'>Le propriétaire a été enregistré</p>";
                $this->render(ROOT . "/templates/Proprietaire/ajout", array("title" => "Ajout d'un propriétaire", "lstGestionProprio" => $gestionProprio, "msg" => $msg , "lesGestionProprio" => $gestionProprio, "lesVilles" => $ville));
            }
        }
        

        // Réaffichage du formulaire (la vue proprietaire/ajout)
        // ----------------------------------------------------
        // pour le formulaire, on récupère le
        // il faut demander au modèle la liste du mode de gestion pour alimenter la liste déroulante
      
    }
    public function liste(): void
    {
        // on crée une instance de ProprietaireRepository
        $unProprioRepository = new ProprietaireRepository();

        // on demande au modèle la liste des appartements
        $lesProprios = $unProprioRepository->getLesProprios();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Proprietaire/consultListe", array("title" => "Liste des propriétaire", "lesProprios" => $lesProprios));
    }

    public function modifListe(): void
    {
        // on crée une instance de AppartementRepository
        $unProprietaireRepository = new ProprietaireRepository();

        // on demande au modèle la liste des appartements
        $lesProprios = $unProprietaireRepository->getLesProprios();

        $this->render(ROOT . "/templates/Proprietaire/modifListe", array("title" => "Liste des proprietaires", "lesProprietaires" => $lesProprios));
    }
    public function modifForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idProprio =  $_POST["lstProprios"];

        // on crée une instance de AppartementRepository
        $unProprietaireRepository = new proprietaireRepository();

        // on demande au modèle l'appartement à modifier 
        $unProprio = $unProprietaireRepository->getUnProprietaire($idProprio);

       

        $gestionProprioRepository = new GestionProprioRepository();
        $gestionProprio = $gestionProprioRepository->GetGestionProprio();
        $villeRepository = new VilleRepository();
        $ville = $villeRepository->GetVille();
        $this->render(ROOT . "/templates/Proprietaire/modif", array("title" => "Modification d'un proprietaire", "leProprio" => $unProprio,"lesModesGestions" => $gestionProprio, "lesVilles" => $ville));
    }

    public function modifTrait(): void
    { $proprio = new Proprietaire(
            $_POST['idProprio'],
            $_POST['nom'],
            $_POST['rue'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            new GestionProprio($_POST['lstGestionProprios'], null),
            new Ville($_POST['lstVilles'], null));

        // on crée une instance de AppartementRepository
        $unProprietaireRepository = new ProprietaireRepository();

        $ret = $unProprietaireRepository->modifProprietaire($proprio);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $gestionProprioRepository = new GestionProprioRepository();
            $gestionProprio = $gestionProprioRepository->GetGestionProprio();
            $villeRepository = new VilleRepository();
            $ville = $villeRepository->GetVille();
            $this->render(ROOT . "/templates/proprietaire/modif", array("title" => "Modification d'un propriétaire",  "leProprio" => $proprio, "lesModesGestions" => $gestionProprio, "lesVilles" => $ville, "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
            // on crée une instance de AppartementRepository
            $unProprietaireRepository = new ProprietaireRepository();

            // on demande au modèle la liste des appartements
            $lesProprios = $unProprietaireRepository->getLesProprios();
            $gestionProprioRepository = new GestionProprioRepository();
            $gestionProprio = $gestionProprioRepository->GetGestionProprio();
            $villeRepository = new VilleRepository();
            $ville = $villeRepository->GetVille();
            $this->render(ROOT . "/templates/proprietaire/modif", array("title" => "Modification d'un propriétaire",  "leProprio" => $proprio, "lesModesGestions" => $gestionProprio, "lesVilles" => $ville, "msg" => $msg));
        }
    }
    public function supprListe(): void
    {
        // on crée une instance de AppartementRepository
        $unProprietaireRepository = new ProprietaireRepository();

        // on demande au modèle la liste des appartements
        $lesProprios = $unProprietaireRepository->getLesProprios();

        $this->render(ROOT . "/templates/Proprietaire/supprListe", array("title" => "Liste des proprietaires", "lesProprietaires" => $lesProprios));
    }
    public function supprForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idProprio =  $_POST["lstProprios"];

        // on crée une instance de AppartementRepository
        $unProprietaireRepository = new proprietaireRepository();

        // on demande au modèle l'appartement à supprimer 
        $lesProprios = $unProprietaireRepository->getUnProprietaire($idProprio);

       

        $gestionProprioRepository = new GestionProprioRepository();
        $gestionProprio = $gestionProprioRepository->GetGestionProprio();
        $villeRepository = new VilleRepository();
        $ville = $villeRepository->GetVille();
        $this->render(ROOT . "/templates/Proprietaire/suppr", array("title" => "supprimer un proprietaire", "lesProprios" => $lesProprios,"lesModesGestions" => $gestionProprio, "lesVilles" => $ville));
    }

    public function supprTrait(): void
    {   
        if (isset($_POST["action"])) {
            $action = $_POST["action"];
    
            if ($action === "supprimer") {
        
            $lesProprios = new Proprietaire(
                    $_POST['idProprio'],
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null);
            
             
            var_dump($_POST);
        // on crée une instance de AppartementRepository
        $unProprietaireRepository = new ProprietaireRepository();
        $ret = $unProprietaireRepository->supprProprietaire($lesProprios);

        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : La suppression n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $gestionProprioRepository = new GestionProprioRepository();
            $gestionProprio = $gestionProprioRepository->GetGestionProprio();
            $villeRepository = new VilleRepository();
            $ville = $villeRepository->GetVille();
            $this->render(ROOT . "/templates/proprietaire/supprTrait", array("title" => "Supprimer un propriétaire",  "lesProprios" => $lesProprios, "lesModesGestions" => $gestionProprio, "lesVilles" => $ville, "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
            // on crée une instance de AppartementRepository
            $unProprietaireRepository = new ProprietaireRepository();

            // on demande au modèle la liste des appartements
            $lesProprios = $unProprietaireRepository->getLesProprios();
            $gestionProprioRepository = new GestionProprioRepository();
            $gestionProprio = $gestionProprioRepository->GetGestionProprio();
            $villeRepository = new VilleRepository();
            $ville = $villeRepository->GetVille();
            $this->render(ROOT . "/templates/proprietaire/supprListe", array("title" => "Supprimer un propriétaire",  "lesProprios" => $lesProprios, "lesModesGestions" => $gestionProprio, "lesVilles" => $ville, "msg" => $msg));
        }
        }elseif ($action === "annuler") {
            $msg = "<p class='text-success'>suppression annulé</p>";

            // on crée une instance de ProprietaireRepository

            $unProprietaireRepository = new ProprietaireRepository();
            // On demande au modèle la liste des proprietaires

        $lesProprios = $unProprietaireRepository->getLesProprios();

        $this->render(ROOT . "/templates/proprietaire/supprListe", array("title" => "Liste des propriétaires", "lesProprios" => $lesProprios, "msg" => $msg));
    }}
}
}   

