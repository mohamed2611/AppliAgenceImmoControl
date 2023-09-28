<?php
namespace App\Repository;

use App\Entity\Ville;
use App\Repository\Repository;

//class dont on a besoin (classe Repository.php obligatoire)


class VilleRepository extends Repository
{
    //méthode permettant d'obtenir tous les types d'appartements
    public function GetVille(): array
    {
        // on crèe le tableau qui contiendra la liste des villes
        $lesVilles = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT insee, nom, code_postal FROM immo_ville order by nom");
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $uneVille = new Ville(
                $enreg->insee,
                $enreg->nom,
                $enreg->code_postal,
            );
            // on ajout l'instance dans la liste
            array_push($lesVilles, $uneVille);
        }
        return $lesVilles;
    }
}