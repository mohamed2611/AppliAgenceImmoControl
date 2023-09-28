<?php
namespace App\Controller;

use DateTime;
use App\Entity\Garant;
use App\Entity\Contrat;
use App\Entity\Locataire;
use App\Entity\Appartement;
use App\Controller\Controller;
use App\Repository\GarantRepository;
use App\Repository\ContratRepository;
use App\Repository\LocataireRepository;
use App\Repository\AppartementRepository;
use App\Repository\TypeAppartementRepository;

 
class ContratController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ajoutForm(): void
    {
        
        // Il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
        $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        $garantRepository = new GarantRepository();
        $lesGarants = $garantRepository->getLesGarant();

        $AppartementRepository = new AppartementRepository();
        $lesApparts = $AppartementRepository->getLesApparts();

        
        
        // On appelle la vue pour afficher le formulaire d'ajout d'un appartement
        $this->render(ROOT . "/templates/Contrat/ajout", array("title" => "Ajout d'un contrat", "lesGarants" => $lesGarants
        ,"lesLocataires" => $lesLocataires
        , "lesApparts" => $lesApparts));
    }

    public function ajoutTrait()
    {
        // On crée une instance de la classe Contrat à partir des données saisies sur le formulaire
        $contrat = new Contrat(
            null,
            new DateTime($_POST['debut']),
            new DateTime($_POST['fin']),
            $_POST['mtC'],
            $_POST['mtCaution'],
            $_POST['mtHC'],
            $_POST['SalaireLoc'],
            new Locataire($_POST['lstLocataire'],null,null,null,null,null,null,null,null,null),
            new Garant($_POST['lstGarant'],null,null,null),
            new Appartement($_POST['lstAppart'],null,null,null,null,null,null,null,null,null)
        );

        // On crée une instance de ContratRepository
        $contratRepository = new ContratRepository();

        // On appelle la méthode qui permet d'ajouter le contrat
        // $ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
        // $ret contient true si l'ajout s'est bien passé
        $ret = $contratRepository->ajoutContrat($contrat);

        
        // Réaffichage du formulaire (la vue Appartement/ajout)
        // ----------------------------------------------------
        // Pour le formulaire, on récupère les types d'appartement
        // Il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante

        $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        $garantRepository = new GarantRepository();
        $lesGarants = $garantRepository->getLesGarant();

        $AppartementRepository = new AppartementRepository();
        $lesApparts = $AppartementRepository->getLesApparts();

        // Dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
        if ($ret == false) {
            // Affichage d'un message d'erreur : le contrat n'a pas été ajouté. On doit réafficher les données saisies (on passe un objet à la vue)
            $msg = "<p class='text-danger'>ERREUR : votre contrat n'a pas été enregistré</p>";
            $this->render(ROOT . "/templates/Contrat/ajout", array(
                "title" => "Ajout d'un contrat", 
                "lesApparts" => $lesApparts,  // Assurez-vous que $lesTypesAppartements est correctement défini
                "lesLocataires" => $lesLocataires,
                "lesGarants" => $lesGarants,
                "msg" => $msg,
                "lContrat" => $contrat
            ));
            
                } else {
            // Pas d'erreur : le contrat a été ajouté
            $msg = "<p class='text-success'>Votre contrat a été enregistré</p>";
            $this->render(ROOT . "/templates/Contrat/ajout", array("title" => "Ajout d'un contrat", "lesApparts" => $lesApparts,  // Assurez-vous que $lesTypesAppartements est correctement défini
            "lesLocataires" => $lesLocataires,
            "lesGarants" => $lesGarants,));
        }
    }

    public function liste(): void
    {
        // On crée une instance de ContratRepository
        $contratRepository = new ContratRepository();

        // On demande au modèle la liste des contrats
        $lesContrats = $contratRepository->getLesContrats();

        // On passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Contrat/liste", array("title" => "Liste des contrats", "lesContrats" => $lesContrats));
    }


    public function modifListe(): void
    {
        // On crée une instance de ContratRepository
        $contratRepository = new ContratRepository(); 

        // On demande au modèle la liste des contrats
        $lesContrats = $contratRepository->getLesContrats();
         // On passe les données à la vue pour qu'elle les affiche
         $this->render(ROOT . "/templates/Contrat/modifListe", array("title" => "Liste des contrats", "lesContrats" => $lesContrats));
    }
    public function modifForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idContrat =  $_POST["lstContrat"];

        $contratRepository = new ContratRepository();

        // On demande au modèle la liste des contrats
        $contrat = $contratRepository->getUnContrat($idContrat);

        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
        // on crée une instance de AppartementRepository
        $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        $garantRepository = new GarantRepository();
        $lesGarants = $garantRepository->getLesGarant();

        $AppartementRepository = new AppartementRepository();
        $lesApparts = $AppartementRepository->getLesApparts();
        
        $this->render(ROOT . "/templates/Contrat/modif", array("title" => "Modification d'un contrat", "lesGarants" => $lesGarants
        ,"lesLocataires" => $lesLocataires
        , "lesApparts" => $lesApparts,"contrat"=> $contrat));
    }

    public function modifTrait(): void
    {
        $contrat = new Contrat(
            $_POST['idContrat'],
            new DateTime($_POST['debut']),
            new DateTime($_POST['fin']),
            $_POST['mtC'],
            $_POST['mtCaution'],
            $_POST['mtHC'],
            $_POST['SalaireLoc'],
            new Locataire($_POST['lstLocataire'],null,null,null,null,null,null,null,null,null),
            new Garant($_POST['lstGarant'],null,null,null),
            new Appartement($_POST['lstAppart'],null,null,null,null,null,null,null,null,null)
        );

        // on crée une instance de ContratRepository();
        $contratRepository = new ContratRepository();

        $ret = $contratRepository->modifContrat($contrat);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        $garantRepository = new GarantRepository();
        $lesGarants = $garantRepository->getLesGarant();

        $AppartementRepository = new AppartementRepository();
        $lesApparts = $AppartementRepository->getLesApparts();
            $this->render(ROOT . "/templates/Contrat/modif", array("title" => "Modification d'un contrat", "lesGarants" => $lesGarants
            ,"lesLocataires" => $lesLocataires
            , "lesApparts" => $lesApparts,"contrat"=>$contrat, "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
            // on crée une instance de AppartementRepository
            $contratRepository = new ContratRepository();

        // On demande au modèle la liste des contrats
        $lesContrats = $contratRepository->getLesContrats();

            $this->render(ROOT . "/templates/Contrat/modifListe", array("title" => "Liste des appartements", "lesContrats" => $lesContrats, "msg" => $msg));
        }
    }



    public function supprListe(): void
    {
        // On crée une instance de ContratRepository
        $contratRepository = new ContratRepository(); 

        // On demande au modèle la liste des contrats
        $lesContrats = $contratRepository->getLesContrats();

        $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        $garantRepository = new GarantRepository();
        $lesGarants = $garantRepository->getLesGarant();

        $AppartementRepository = new AppartementRepository();
        $lesApparts = $AppartementRepository->getLesApparts();

        // On passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Contrat/supprList", array("title" => "Supprimer un contrat", "lesGarants" => $lesGarants
        ,"lesLocataires" => $lesLocataires
        , "lesApparts" => $lesApparts,"lesContrats" => $lesContrats));
    }
    public function supprForm(): void
    {

        $idContrat =  $_POST["tbContrat"];

        $contratRepository = new ContratRepository();
        
        // On demande au modèle la liste des contrats
        $contrat = $contratRepository->getUnContrat($idContrat);
        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
        // on crée une instance de AppartementRepository
        $locataireRepository = new LocataireRepository();
        $lesLocataires = $locataireRepository->getLesLocataires();

        $garantRepository = new GarantRepository();
        $lesGarants = $garantRepository->getLesGarant();

        $AppartementRepository = new AppartementRepository();
        $lesApparts = $AppartementRepository->getLesApparts();
        
        $this->render(ROOT . "/templates/Contrat/suppr", array("title" => "suppression d'un contrat","lesGarants" => $lesGarants,
        "lesLocataires" => $lesLocataires,
        "lesApparts" => $lesApparts,
        "contrat" => $contrat));
    }
    public function supprTrait(): void
    {
        if (isset($_POST["action"])) {
            $action = $_POST["action"];
    
            if ($action === "supprimer") {

                $contrat = new Contrat(
                    $_POST['idContrat'],
                    new DateTime($_POST['debut']),
                    new DateTime($_POST['fin']),
                    $_POST['mtC'],
                    $_POST['mtCaution'],
                    $_POST['mtHC'],
                    $_POST['SalaireLoc'],
                    new Locataire($_POST['lstLocataire'],null,null,null,null,null,null,null,null,null),
                    new Garant($_POST['lstGarant'],null,null,null),
                    new Appartement($_POST['lstAppart'],null,null,null,null,null,null,null,null,null)
                );
                // on crée une instance de ContratRepository();
                $contratRepository = new ContratRepository();
            
                $ret = $contratRepository->supprContrat($contrat);
                if ($ret == false) {
                    $msg = "<p class='text-danger'>ERREUR : votre suppression n'a pas été prise en compte</p>";
                    // on réaffiche le formulaire 

                $locataireRepository = new LocataireRepository();
                $lesLocataires = $locataireRepository->getLesLocataires();

                $garantRepository = new GarantRepository();
                $lesGarants = $garantRepository->getLesGarant();

                $AppartementRepository = new AppartementRepository();
                $lesApparts = $AppartementRepository->getLesApparts();

                    $this->render(ROOT . "/templates/Contrat/suppr", array("title" => "suppression d'un contrat", "lesGarants" => $lesGarants
                    ,"lesLocataires" => $lesLocataires
                    , "lesApparts" => $lesApparts,"contrat"=>$contrat, "msg" => $msg));
                } else {
                    $msg = "<p class='text-success'>Votre suppression a été enregistrée</p>";

                    // on crée une instance de AppartementRepository

                    $contratRepository = new ContratRepository();

                // On demande au modèle la liste des contrats

                $lesContrats = $contratRepository->getLesContrats();

                    $this->render(ROOT . "/templates/Contrat/supprList", array("title" => "Liste des appartements", "lesContrats" => $lesContrats, "msg" => $msg));
                }
            
            
        } elseif ($action === "annuler") {
            $msg = "<p class='text-success'>vous n'avez pas supprimer</p>";

            // on crée une instance de AppartementRepository

            $contratRepository = new ContratRepository();

        // On demande au modèle la liste des contrats

        $lesContrats = $contratRepository->getLesContrats();

            $this->render(ROOT . "/templates/Contrat/supprList", array("title" => "Liste des appartements", "lesContrats" => $lesContrats, "msg" => $msg));
        }}
    }
}   
 