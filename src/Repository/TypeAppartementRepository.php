<?php
namespace App\Repository;


use PDO;
use PDOEXCEPTION;
use App\Repository\Repository;
use App\Entity\TypeAppartement;

//class dont on a besoin (classe Repository.php obligatoire)


class TypeAppartementRepository extends Repository
{
    //méthode permettant d'obtenir tous les types d'appartements
    public function getLesTypes(): array
    {
        // on crèe le tableau qui contiendra la liste des types d'appartements
        $lesTypesAppart = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM immo_type_appart order by libelle");
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unTypeAppart = new TypeAppartement(
                $enreg->id,
                $enreg->libelle,
            );
            // on ajout l'instance dans la liste
            array_push($lesTypesAppart, $unTypeAppart);
        }
        return $lesTypesAppart;
    }
    public function ajoutTypeAppart(TypeAppartement $typeAppartACreer)
    {
        // On récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // On prépare la requête insert
            $req = $db->prepare("INSERT INTO immo_type_appart VALUES (0, :par_libelle)");
            // On affecte une valeur au paramètre déclaré dans la requête
            // Récupération de la date du jour
            $req->bindValue(':par_libelle', $typeAppartACreer->getLibelle(), PDO::PARAM_STR);
            // On demande l'exécution de la requête
            $ret = $req->execute();
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
    }
    
}
