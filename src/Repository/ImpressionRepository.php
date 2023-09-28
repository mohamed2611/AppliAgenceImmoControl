<?php
namespace App\Repository;

use App\Entity\Impression;
use App\Repository\Repository;

class ImpressionRepository extends Repository
{
    //méthode permettant d'obtenir tous les impressions
    public function getLesImpressions(): array
    {
        // on crèe le tableau qui contiendra la liste des impressions
        $lesImpressions = array();
        
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM immo_impression order by libelle");
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $uneImpression = new Impression(
                $enreg->id,
                $enreg->libelle,
            );
            // on ajout l'instance dans la liste
            array_push($lesImpressions, $uneImpression);
        }
        return $lesImpressions;
    }

}