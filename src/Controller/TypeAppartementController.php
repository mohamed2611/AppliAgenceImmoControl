<?php
namespace App\Controller;

use App\Entity\Appartement;
use App\Entity\TypeAppartement;
use App\Controller\Controller;
use App\Repository\TypeAppartementRepository;
use App\Repository\AppartementRepository;

class TypeAppartementController extends Controller
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

        // on appelle la vue pour afficher le formulaire d'ajout d'un appartement
        $this->render(ROOT . "/templates/TypeAppartement/ajout", array("title" => "Ajout d'un type d'appartement"));
    }
    public function ajoutTrait()
    {
        // on crée une instance de la classe Appartement à partir des données saisies sur le formulaire
        $typeAppart = new TypeAppartement(
            $_POST['id'],
            $_POST['libelle'],
        );
        // on crée une instance de typeAppartementRepository
        $unTypeAppartRepository = new TypeAppartementRepository();

        // on appelle la méthode qui permet d'ajouter l'appartement
        // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
        // ret contient true si l'ajout s'est bien passé
        $ret = $unTypeAppartRepository->ajoutTypeAppart($typeAppart);

        // Réaffichage du formulaire (la vue Appartement/ajout)
        // ----------------------------------------------------
        // pour le formulaire, on récupère les types d'appartement
        // il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
        $typeAppartementRepository = new TypeAppartementRepository();
        $lesTypes = $typeAppartementRepository->getLesTypes();
        // dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
        if ($ret == false) {
            // affichage d'un message d'erreur : l'appartement n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
            $msg = "<p class='text-danger'>ERREUR : votre categorie d'appartement n'a pas été enregistré</p>";
            $this->render(ROOT . "/templates/TypeAppartement/ajoutTypeAppart", array("title" => "Ajout d'une catégorie appartement", "lesTypesApparts" => $lesTypes, "msg" => $msg,));
        } else {
            // pas de  : l'appartement n'a pas été ajouté
            $msg = "<p class='text-success'>Votre catégorie appartement a été enregistré</p>";
            $this->render(ROOT . "/templates/TypeAppartement/ajoutTypeAppart", array("title" => "Ajout d'un appartement", "lesTypesApparts" => $lesTypes, "msg" => $msg));
        }
    }
    


};
