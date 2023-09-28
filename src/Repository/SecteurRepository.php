<?php
namespace App\Repository;


use PDO;
use PDOEXCEPTION;
use App\Repository\Repository;
use App\Entity\Secteur;

//class dont on a besoin (classe Repository.php obligatoire)


class SecteurRepository extends Repository
{
    //méthode permettant d'obtenir tous les Secteurs
    public function getLesSecteurs(): array
    {
        // on crèe le tableau qui contiendra la liste des Secteurs
        $lesSecteurs = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM immo_Secteur order by libelle");
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unSecteur = new Secteur(
                $enreg->id,
                $enreg->libelle,
            );
            // on ajout l'instance dans la liste
            array_push($lesSecteurs, $unSecteur);
        }
        return $lesSecteurs;
    }
   
    
    
}
