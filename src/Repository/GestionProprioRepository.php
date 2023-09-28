<?php
namespace App\Repository;

use App\Entity\GestionProprio;
use App\Repository\Repository;

//class dont on a besoin (classe Repository.php obligatoire)


class GestionProprioRepository extends Repository
{
    //méthode permettant d'obtenir tous les types d'appartements
    public function GetGestionProprio(): array
    {
        // on crèe le tableau qui contiendra la liste des types d'appartements
        $lesProprios = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id,libelle FROM immo_gestionproprio order by libelle");
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $uneGestionProprio = new GestionProprio(
                $enreg->id,
                $enreg->libelle,
            );
            // on ajout l'instance dans la liste
            array_push($lesProprios, $uneGestionProprio);
        }
        return $lesProprios;
    }
}