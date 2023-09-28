<?php
namespace App\Controller;

use App\Entity\Appartement;
use App\Controller\Controller;
use App\Entity\TypeAppartement;
use App\Repository\AppartementRepository;
use App\Repository\TypeAppartementRepository;
use App\Repository\ProprietaireRepository;
use App\Repository\VilleRepository;
use App\Repository\SecteurRepository;
use App\Entity\Proprietaire;
use App\Entity\Ville;
use App\Entity\Secteur;



class AppartementController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    

       
        public function ajoutForm(): void
        {
            // il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
            $typeAppartementRepository = new TypeAppartementRepository();
            $lesTypes = $typeAppartementRepository->getLesTypes();

            $proprietaireRepository = new ProprietaireRepository();
            $lesProprietaires = $proprietaireRepository->getLesProprios();
            
            $villeRepository = new VilleRepository();
            $lesVilles = $villeRepository->GetVille();

            $secteurRepository = new SecteurRepository();
            $lesSecteurs = $secteurRepository->getLesSecteurs();

            
            // on appelle la vue pour afficher le formulaire d'ajout d'un appartement
            $this->render(ROOT . "/templates/Appartement/ajout", 
            array("title" => "Ajout d'un appartement", 
            "lesTypes" => $lesTypes,
            "lesProprio" => $lesProprietaires,
            "lesVilles" =>$lesVilles,
            "lesSecteurs" =>$lesSecteurs ));
        }
        public function ajoutTrait()
        {
            // on crée une instance de la classe Appartement à partir des données saisies sur le formulaire
            
            $appart = new Appartement(
                null,
                $_POST['rue'],
                $_POST['batiment'],
                $_POST['etage'],
                $_POST['superficie'],
                $_POST['orientation'],
                $_POST['nbpiece'],

                new TypeAppartement($_POST['lstTypeAppart'], null),
                new Proprietaire($_POST['lstProprietaire'], null),
                new Ville($_POST['lstVille'], null),
                new Secteur($_POST['lstSecteur'], null),
            );
            $unAppartVerif = new AppartementRepository();
            $ret = $unAppartVerif->verifAppartIdentique($appart);
            // on crée une instance de AppartementRepository
            $unAppartRepository = new AppartementRepository();
    
            // on appelle la méthode qui permet d'ajouter l'appartement
            // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
            // ret contient true si l'ajout s'est bien passé
            
            $ret = $unAppartRepository->ajoutAppartement($appart);
            
            // Réaffichage du formulaire (la vue Appartement/ajout)
            // ----------------------------------------------------
            // pour le formulaire, on récupère les types d'appartement
            // il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
            $typeAppartementRepository = new TypeAppartementRepository();
            $lesTypes = $typeAppartementRepository->getLesTypes();

            $proprietaireRepository = new ProprietaireRepository();
            $lesProprietaires = $proprietaireRepository->getLesProprios();
            
            $villeRepository = new VilleRepository();
            $lesVilles = $villeRepository->GetVille();

            $secteurRepository = new SecteurRepository();
            $lesSecteurs = $secteurRepository->getLesSecteurs();
            
            



            // dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
            if ($ret == false) {
                // affichage d'un message d'erreur : l'appartement n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
                $msg = "<p class='text-danger'>ERREUR : votre appartement n'a pas été enregistré</p>";
                $this->render(ROOT . "/templates/Appartement/ajout",  array("title" => "Ajout d'un appartement", 
                "lesTypes" => $lesTypes,
                "lesProprio" => $lesProprietaires,
                "lesVilles" =>$lesVilles , 
                "lesSecteurs" =>$lesSecteurs,
                "msg" => $msg, "lAppart" => $appart));
            } else {
                // pas de  : l'appartement n'a pas été ajouté
                $msg = "<p class='text-success'>Votre appartement a été enregistré</p>";
                $this->render(ROOT . "/templates/Appartement/ajout", array("title" => "Ajout d'un appartement",
                 "lesTypes" => $lesTypes,
                "lesProprio" => $lesProprietaires,
                "lesVilles" =>$lesVilles,
                "lesSecteurs" =>$lesSecteurs , "msg" => $msg));
            }
        }
        public function modifListe(): void
        {
            // on crée une instance de AppartementRepository
            $unAppartRepository = new AppartementRepository();
    
            // on demande au modèle la liste des appartements
            $lAppart = $unAppartRepository->getLesApparts();
    
            $this->render(ROOT . "/templates/Appartement/modifListe", array("title" => "Liste des appartements", "lAppart" => $lAppart));
        }
    
   
  
    public function modifForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idAppart =  $_POST["lstAppart"];

        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle l'appartement à modifier 
        $lAppart = $unAppartRepository->getUnAppart($idAppart);

        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
        // on crée une instance de AppartementRepository
        $typeAppartementRepository = new TypeAppartementRepository();
        $lesTypes = $typeAppartementRepository->getLesTypes();

        $proprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $proprietaireRepository->getLesProprios();

        $villeRepository = new VilleRepository();
        $lesVilles = $villeRepository->GetVille();

        $this->render(ROOT . "/templates/Appartement/modif", array("title" => "Modification d'un appartement", "lesTypes" => $lesTypes,
        "lesProprio" => $lesProprietaires,
        "lesVilles" =>$lesVilles , "lAppart" => $lAppart));
    }

    public function modifTrait(): void
    {
        $lAppart = new Appartement(
            
            $_POST['idAppart'],
            $_POST['rue'],
            $_POST['batiment'],
            $_POST['etage'],
            $_POST['superficie'],
            $_POST['orientation'],
            $_POST['nbpiece'],

            new TypeAppartement($_POST['lstTypeAppart'], null),
            new Proprietaire($_POST['lstProprietaire'], null),
            new Ville($_POST['lstVille'], null),
        );
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();
        $ret = $unAppartRepository->modifAppartement($lAppart);

        $typeAppartementRepository = new TypeAppartementRepository();
        $lesTypesAppartements = $typeAppartementRepository->getLesTypes();

        $proprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $proprietaireRepository->getLesProprios();

        $villeRepository = new VilleRepository();
        $lesVilles = $villeRepository->GetVille();
        $lAppart = $unAppartRepository->getLesApparts();
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $typeAppartementRepository = new TypeAppartementRepository();
            $lesTypes = $typeAppartementRepository->getLesTypes();
            $this->render(ROOT . "/templates/Appartement/modif", array("title" => "Modification d'un appartement",  "lesTypes" => $lesTypes,
            "lesProprio" => $lesProprietaires,
            "lesVilles" =>$lesVilles , "lAppart" => $lAppart, "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
           
            $this->render(ROOT . "/templates/Appartement/modifListe", array("title" => "Liste des appartements", "lAppart" => $lAppart, "msg" => $msg));
        }
    }
    public function supprAppartListe()
    {
        $unAppartRepository = new AppartementRepository();
        

        // on demande au modèle la liste des appartements
        $lAppart = $unAppartRepository->getLesApparts();
       
        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Appartement/supprAppartListe", array("title" => "Liste des appartements", "lAppart" => $lAppart));
    }
    public function supprAppartForm()
    {
      // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
      $idAppart =  $_POST["lstAppart"];

      // on crée une instance de AppartementRepository
      $unAppartRepository = new AppartementRepository();

      // on demande au modèle l'appartement à modifier 
      $lAppart = $unAppartRepository->getUnAppart($idAppart);

      // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
      // on crée une instance de AppartementRepository
      $typeAppartementRepository = new TypeAppartementRepository();
      $lesTypes = $typeAppartementRepository->getLesTypes();

      $proprietaireRepository = new ProprietaireRepository();
      $lesProprietaires = $proprietaireRepository->getLesProprios();

      $villeRepository = new VilleRepository();
      $lesVilles = $villeRepository->GetVille();

      $this->render(ROOT . "/templates/Appartement/supprAppart", array("title" => "suppression d'un appartement", "lesTypes" => $lesTypes,
      "lesProprio" => $lesProprietaires,
      "lesVilles" =>$lesVilles , "lAppart" => $lAppart));
    }

    public function supprAppartTrait()
    {
        
        $lAppart = new Appartement(
            
            $_POST['idAppart'],
            $_POST['rue'],
            $_POST['batiment'],
            $_POST['etage'],
            $_POST['superficie'],
            $_POST['orientation'],
            $_POST['nbpiece'],
            new TypeAppartement($_POST['lstTypeAppart'], null),
            new Proprietaire($_POST['lstProprietaire'], null),
            new Ville($_POST['lstVille'], null)
        );
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();
        $ret = $unAppartRepository->getLesAppartSupp($lAppart);

        $typeAppartementRepository = new TypeAppartementRepository();
        $lesTypesAppartements = $typeAppartementRepository->getLesTypes();

        $proprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $proprietaireRepository->getLesProprios();

        $villeRepository = new VilleRepository();
        $lesVilles = $villeRepository->GetVille();
        $lAppart = $unAppartRepository->getLesApparts();
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre suppression n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $typeAppartementRepository = new TypeAppartementRepository();
            $lesTypes = $typeAppartementRepository->getLesTypes();
            $this->render(ROOT . "/templates/Appartement/supprAppart", array("title" => "suppression d'un appartement",  "lesTypes" => $lesTypes,
            "lesProprio" => $lesProprietaires,
            "lesVilles" =>$lesVilles , "lAppart" => $lAppart, "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre suppression a été enregistrée</p>";
           
            $this->render(ROOT . "/templates/Appartement/supprAppartListe", array("title" => "Liste des appartements", "lAppart" => $lAppart, "msg" => $msg));
        }
    }
    
    public function liste(): void
    {
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle la liste des appartements
        $lAppart = $unAppartRepository->getLesApparts();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Appartement/consultListe", array("title" => "Liste des appartements", "lAppart" => $lAppart));
    }

    public function listeAppartLib(): void
    {
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle la liste des appartements
        $lAppart = $unAppartRepository->getLesAppartslib();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Appartement/consultListe", array("title" => "Liste des appartements", "lAppart" => $lAppart));
    }

    public function listeDesSecteur(): void
    {
        // on crée une instance de AppartementRepository
        $unSecteurRepository = new SecteurRepository();

        // on demande au modèle la liste des appartements
        $lesSecteurs = $unSecteurRepository->getLesSecteurs();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Appartement/listeDesSect", array("title" => "Liste par secteur", "lesSecteurs" => $lesSecteurs));
    }

    public function listeDesSectTrait(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idSecteur =  $_POST["lstSecteur"];

        // on cree une instance unAppartRepository
        $unAppartRepository = new AppartementRepository();
        // on demande au modele la liste des appartements pour le secteur choisis 
        $lesAppartsUnSecteur = $unAppartRepository->getLesAppartsUnSecteur($idSecteur);

        $unSecteurRepository = new SecteurRepository();
        $lesSecteurs = $unSecteurRepository->getLesSecteurs();

        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
       
        // on crée une instance de AppartementRepository
      
        $this->render(ROOT . "/templates/Appartement/listeDesSect", array("title" => "Liste par secteur", "lesAppartsUnSecteur" => $lesAppartsUnSecteur, "lesSecteurs" => $lesSecteurs));
    }


    

};
