<?php
namespace App\Repository;

use PDO;
use DateTime;
use PDOEXCEPTION;
use App\Entity\Ville;
use App\Entity\Garant;
use App\Entity\Contrat;
use App\Entity\Locataire;
use App\Entity\Appartement;
use App\Repository\Repository;
use App\Entity\TypeAppartement;



//class dont on a

class ContratRepository extends Repository
{

    public function ajoutContrat(Contrat $contratACreer)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("insert into immo_contrat 
            values (0,:par_debut,:par_fin,:par_montantCharge,:par_montantCaution,:par_montantLoyerHc,:par_salaireLocataire,:par_leLocataire,:par_leGarant,:par_lAppartement)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            
            $req->bindValue(':par_debut', $contratACreer->getDebut()->format('Y-m-d'), PDO::PARAM_STR);
            $req->bindValue(':par_fin', $contratACreer->getFin()->format('Y-m-d'), PDO::PARAM_STR);
            $req->bindValue(':par_montantCharge', $contratACreer->getMontantCharge(), PDO::PARAM_INT);
            $req->bindValue(':par_montantCaution', $contratACreer->getMontantCaution(), PDO::PARAM_INT);
            $req->bindValue(':par_montantLoyerHc', $contratACreer->getMontantLoyerHc(), PDO::PARAM_INT);
            $req->bindValue(':par_salaireLocataire', $contratACreer->getSalaireLocataire(), PDO::PARAM_STR);
            $req->bindValue(':par_leLocataire', $contratACreer->getLeLocataire()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_leGarant', $contratACreer->getLeGarant()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_lAppartement', $contratACreer->getLAppartement()->getId(), PDO::PARAM_INT);
    
            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $ret = false;
        }
        return $ret;
    }
    public function getLesContrats(): array
{
    // On crée le tableau qui contiendra la liste des contrats
    $lesContrats = array();

    // On récupère l'objet qui permet de travailler avec la base de données
    $db = $this->dbConnect();

    $req = $db->prepare("SELECT immo_contrat.id AS id,
                            immo_contrat.debut,
                            immo_contrat.fin,
                            immo_contrat.montant_charge,
                            immo_contrat.montant_caution,
                            immo_contrat.montant_loyer_hc,
                            immo_contrat.salaire_locataire,
                            immo_locataire.id AS locataire_id,
                            immo_locataire.nom AS locataire_nom,
                            immo_locataire.prenom AS locataire_prenom,
                            immo_locataire.telephone AS locataire_telephone,
                            immo_garant.id AS garant_id,
                            immo_garant.nom AS garant_nom,
                            immo_garant.prenom AS garant_prenom,
                            immo_appartement.id AS appartement_id,
                            immo_appartement.rue AS appartement_rue,
                            immo_ville.nom AS nomVille,
                            immo_ville.code_postal AS codePostal
                        FROM immo_contrat
                        JOIN immo_locataire ON immo_locataire.id = id_locataire
                        JOIN immo_garant ON immo_garant.id = id_garant
                        JOIN immo_appartement ON immo_appartement.id = id_appartement
                        JOIN immo_ville ON immo_appartement.id_ville = immo_ville.insee"
                    );

    // On demande l'exécution de la requête
    $req->execute();

    $lesEnregs = $req->fetchAll();

    foreach ($lesEnregs as $enreg) {
        // On crée une instance de Contrat en utilisant les données de chaque enregistrement
        $contrat = new Contrat(
            $enreg->id,
            new DateTime($enreg->debut),
            new DateTime($enreg->fin),
            $enreg->montant_charge,
            $enreg->montant_caution,
            $enreg->montant_loyer_hc,
            $enreg->salaire_locataire,
            new Locataire(null,$enreg->locataire_nom,$enreg->locataire_prenom,null,$enreg->locataire_telephone,null,null,null,null,null),
            new Garant(null,$enreg->garant_nom,$enreg->garant_prenom,null),
            new Appartement(null,$enreg->appartement_rue,null,null,null,null,null,null,null, new Ville(null,$enreg->nomVille,$enreg->codePostal))
        );

        // On ajoute l'instance de Contrat dans la liste
        array_push($lesContrats, $contrat);
    }

    return $lesContrats;
}

    public function getUnContrat($id): ?Contrat
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        
        $req = $db->prepare("SELECT immo_contrat.id ,
        immo_contrat.debut,
        immo_contrat.fin,
        immo_contrat.montant_charge,
        immo_contrat.montant_caution,
        immo_contrat.montant_loyer_hc,
        immo_contrat.salaire_locataire,
        immo_locataire.id AS locataire_id,
        immo_locataire.nom AS locataire_nom,
        immo_locataire.prenom AS locataire_prenom,
        immo_locataire.telephone AS locataire_telephone,
        immo_garant.id AS garant_id,
        immo_garant.nom AS garant_nom,
        immo_garant.prenom AS garant_prenom,
        immo_appartement.id AS appartement_id,
        immo_appartement.rue AS appartement_rue,
        immo_ville.nom AS nomVille,
        immo_ville.code_postal AS codePostal,
        immo_ville.insee AS idVille
    FROM immo_contrat
    JOIN immo_locataire ON immo_locataire.id = id_locataire
    JOIN immo_garant ON immo_garant.id = id_garant
    JOIN immo_appartement ON immo_appartement.id = id_appartement
    JOIN immo_ville ON immo_appartement.id_ville = immo_ville.insee
    where immo_contrat.id = :par_id");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $enreg = $req->fetch();
        if ($enreg == false) { // l'appartement n'existe pas 
            return null;
        } else { // l'appartement  existe 
            // on crée une instance
            $unContrat = new Contrat(
                $enreg->id,
                new DateTime($enreg->debut),
                new DateTime($enreg->fin),
                $enreg->montant_charge,
                $enreg->montant_caution,
                $enreg->montant_loyer_hc,
                $enreg->salaire_locataire,
                new Locataire($enreg->locataire_id,$enreg->locataire_nom,$enreg->locataire_prenom,null,null,null,null,null,null,null),
                new Garant($enreg->garant_id,$enreg->garant_nom,$enreg->garant_prenom,null),
                new Appartement($enreg->appartement_id,$enreg->appartement_rue,null,null,null,null,null,null,null, new Ville($enreg->idVille,$enreg->nomVille,$enreg->codePostal))
            );
            return $unContrat;
        }
    }

   
    public function modifContrat(Contrat $contratAModifier): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            
            // on prépare la requête update
            $req = $db->prepare("update immo_contrat set 
            debut =:par_debut,
            fin =:par_fin,
            montant_charge =:par_montantCharge,
            montant_caution =:par_montantCaution,
            montant_loyer_hc =:par_montantLoyerHc,
            salaire_locataire =:par_salaireLocataire,
            id_locataire =:par_leLocataire,
            id_garant =:par_leGarant,
            id_appartement =:par_lAppartement
            where id = :par_id_contrat");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_debut', $contratAModifier->getDebut()->format('Y-m-d'), PDO::PARAM_STR);
            $req->bindValue(':par_fin', $contratAModifier->getFin()->format('Y-m-d'), PDO::PARAM_STR);
            $req->bindValue(':par_montantCharge', $contratAModifier->getMontantCharge(), PDO::PARAM_INT);
            $req->bindValue(':par_montantCaution', $contratAModifier->getMontantCaution(), PDO::PARAM_INT);
            $req->bindValue(':par_montantLoyerHc', $contratAModifier->getMontantLoyerHc(), PDO::PARAM_INT);
            $req->bindValue(':par_salaireLocataire', $contratAModifier->getSalaireLocataire(), PDO::PARAM_STR);
            $req->bindValue(':par_leLocataire', $contratAModifier->getLeLocataire()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_leGarant', $contratAModifier->getLeGarant()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_lAppartement', $contratAModifier->getLAppartement()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_contrat', $contratAModifier->getId(), PDO::PARAM_INT);
    
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {

            $ret = false;
        }

        return $ret;
    }

    public function supprContrat(Contrat $contratASuppr): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            
            // on prépare la requête update
            $req = $db->prepare("DELETE FROM immo_contrat WHERE id= :par_id_contrat");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_contrat', $contratASuppr->getId(), PDO::PARAM_INT);
    
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {

            $ret = false;
        } 

        return $ret;
    }
}
