<?php
namespace App\Repository;

use PDO;
use PDOEXCEPTION;
use App\Entity\Appartement;
use App\Repository\Repository;
use App\Entity\TypeAppartement;
use App\Entity\Ville;
use App\Entity\Proprietaire;
use App\Entity\Secteur;



//class dont on a besoin (classe Repository.php obligatoire)

class AppartementRepository extends Repository
{

    public function ajoutAppartement(Appartement $appartACreer)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("insert into immo_Appartement 
            values (0,:par_rue,:par_batiment,:par_etage,:par_superficie,:par_orientation,:par_nbpiece,:par_id_type_appart,:par_id_proprietaire,:par_id_ville,:par_id_secteur)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_rue', $appartACreer->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_batiment', $appartACreer->getBatiment(), PDO::PARAM_STR);
            $req->bindValue(':par_etage', $appartACreer->getEtage(), PDO::PARAM_STR);
            $req->bindValue(':par_superficie', $appartACreer->getSuperficie(), PDO::PARAM_STR);
            $req->bindValue(':par_orientation', $appartACreer->getOrientation(), PDO::PARAM_STR);
            $req->bindValue(':par_nbpiece', $appartACreer->getNbPiece(), PDO::PARAM_STR);
            $req->bindValue(':par_id_type_appart', $appartACreer->getTypeAppartement()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_proprietaire', $appartACreer->getProprietaire()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_ville', $appartACreer->getVille()->getInsee(), PDO::PARAM_STR);
            $req->bindValue(':par_id_secteur', $appartACreer->getSecteur()->getId(), PDO::PARAM_STR);
            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $ret = false;
        }
        return $ret;
    }
    public function modifAppartement(Appartement $appartAModifier): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("update immo_appartement
            set  
            rue = :par_rue,
            batiment = :par_batiment,
            etage = :par_etage,
            superficie = :par_superficie,
            orientation = :par_orientation,
            nb_piece = :par_nb_piece,
            id_type_appart=:par_id_type_appart,
            id_proprietaire = :par_id_proprietaire,
            id_secteur = :par_id_secteur,
            id_ville = :par_id_ville
            where id = :par_id_appart");
            // on affecte une valeur au paramètre déclaré dans la requête 
           
            $req->bindValue(':par_rue', $appartAModifier->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_batiment', $appartAModifier->getBatiment(), PDO::PARAM_STR);
            $req->bindValue(':par_etage', $appartAModifier->getEtage(), PDO::PARAM_STR);
            $req->bindValue(':par_superficie', $appartAModifier->getSuperficie(), PDO::PARAM_STR);
            $req->bindValue(':par_orientation', $appartAModifier->getOrientation(), PDO::PARAM_STR);
            $req->bindValue(':par_nb_piece', $appartAModifier->getNbPiece(), PDO::PARAM_STR);
            $req->bindValue(':par_id_type_appart', $appartAModifier->getTypeAppartement()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_proprietaire', $appartAModifier->getProprietaire()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_secteur', $appartACreer->getSecteur()->getId(), PDO::PARAM_STR);
            $req->bindValue(':par_id_ville', $appartAModifier->getVille()->getInsee(), PDO::PARAM_INT);
            $req->bindValue(':par_id_appart', $appartAModifier->getId(), PDO::PARAM_INT);
            
            ;
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            var_dump($e -> getMessage());
            $ret = false;
        }

        return $ret;
    }
    public function getLesAppartSupp(Appartement $appartASupprimer): bool
    {
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("DELETE FROM immo_appartement WHERE id= :par_id_appart");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_id_appart', $appartASupprimer->getId(), PDO::PARAM_INT);
           
            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $ret = false;
        }
        return $ret;
    }
    public function getLesApparts(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lAppart = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select immo_appartement.id as id, 
                        immo_type_appart.libelle,
                        immo_appartement.rue,
                        batiment,etage,superficie,orientation,nb_piece as nbpiece,
                        immo_secteur.libelle as libSecteur,
                        immo_proprietaire.nom as nomProprio, 
                        immo_ville.nom as nomVille
                        from immo_appartement
                
                join immo_type_appart on immo_type_appart.id = id_type_appart
                join immo_secteur on immo_secteur.id = id_secteur
                join immo_proprietaire on immo_proprietaire.id = id_proprietaire
                join immo_ville on immo_ville.insee = immo_appartement.id_ville");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unAppart = new Appartement(
                $enreg->id,
                $enreg->rue,
                $enreg->batiment,
                $enreg->etage,
                $enreg->superficie,
                $enreg->orientation,
                $enreg->nbpiece,
                new TypeAppartement(null, $enreg->libelle,null),
                new Proprietaire(null, $enreg->nomProprio,null,null,null,null,null,null),
                new Ville(null, $enreg->nomVille),
                new Secteur(null, $enreg->libSecteur,null)


            );
            // on ajout l'instance dans la liste
            array_push($lAppart, $unAppart);
        }
        return $lAppart;
    }
    public function getLesAppartslib(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements libre
        $lAppart = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select immo_appartement.id as id, 
                        immo_type_appart.libelle, id_type_appart,immo_appartement.rue,batiment,etage,superficie,orientation,nb_piece as nbpiece,immo_proprietaire.nom as nomProprio, immo_ville.nom as nomVille
                        from immo_appartement
                join immo_type_appart on immo_type_appart.id = id_type_appart
                join immo_proprietaire on immo_proprietaire.id = id_proprietaire
                join immo_ville on immo_ville.insee = immo_appartement.id_ville
                join immo_contrat on immo_contrat.id = id_locataire
                where immo_appartement.id not in (select immo_contrat.id_appartement from immo_contrat)");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unAppart = new Appartement(
                $enreg->id,
                $enreg->rue,
                $enreg->batiment,
                $enreg->etage,
                $enreg->superficie,
                $enreg->orientation,
                $enreg->nbpiece,
                new TypeAppartement($enreg->id_type_appart, $enreg->libelle),
                new Proprietaire(null, $enreg->nomProprio,null,null,null,null,null,null),
                new Ville(null, $enreg->nomVille)

            );
            // on ajout l'instance dans la liste
            array_push($lAppart, $unAppart);
        }
        return $lAppart;
    }

    public function getUnAppart($id): ?Appartement
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select immo_appartement.id as id, 
        immo_type_appart.libelle, id_type_appart,id_proprietaire,immo_appartement.id_ville,immo_appartement.rue,batiment,etage,superficie,orientation,
        nb_piece as nbpiece,immo_proprietaire.nom as nomProprio,
        immo_ville.nom as nomVille
        from immo_appartement
join immo_type_appart on immo_type_appart.id = id_type_appart
join immo_proprietaire on immo_proprietaire.id = id_proprietaire
join immo_ville on immo_ville.insee = immo_appartement.id_ville
where immo_appartement.id = :par_id ");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $enreg = $req->fetch();
        if ($enreg == false) { // l'appartement n'existe pas 
            return null;
        } else { // l'appartement  existe 
            // on crée une instance
            $unAppart = new Appartement(
                $enreg->id,
                $enreg->rue,
                $enreg->batiment,
                $enreg->etage,
                $enreg->superficie,
                $enreg->orientation,
                $enreg->nbpiece,
                new Proprietaire(null, $enreg->nomProprio,null,null,null,null,null,null),
                new Ville(null, $enreg->nomVille),
                new Secteur(null, $enreg->libelle)
            );
            return $unAppart;
        }
    }

    public function getLesAppartsUnSecteur($id): array
    {
        $lAppart = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select immo_appartement.id as id,
        id_proprietaire, 
        id_secteur, 
        immo_appartement.id_ville, 
        immo_appartement.rue, 
        batiment,
        immo_proprietaire.nom as nomProprio, 
        immo_ville.nom as nomVille,
        immo_secteur.libelle as nomSecteur  
        from immo_appartement
        
        join immo_proprietaire on immo_proprietaire.id = id_proprietaire 
        join immo_ville on immo_ville.insee = immo_appartement.id_ville 
        join immo_secteur on immo_secteur.id = id_secteur
        WHERE id_secteur = :par_id");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unAppart = new Appartement(
                $enreg->id,
                $enreg->rue,
                $enreg->batiment,
                null,
                null,
                null,
                null,
                null,
                new Proprietaire(null, $enreg->nomProprio,null,null,null,null,null,null),
                new Ville(null, $enreg->nomVille),
                new Secteur(null, $enreg->nomSecteur)

            );
            // on ajout l'instance dans la liste
            array_push($lAppart, $unAppart);
        }
        return $lAppart;
    }
    public function verifAppartIdentique(Appartement $appartAVerif):bool
    {
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("SELECT count(*) as nb from immo_appartement where
             rue = :par_rue,
             batiment= :par_batiment,
             etage = :par_etage ,
             id_proprietaire = :par_id_proprietaire,
             id_ville = :par_id_ville");
             $req->bindValue( ':par_rue',$appartAVerif->getRue(), PDO::PARAM_STR);
             $req->bindValue( ':par_batiment',$appartAVerif->getBatiment(), PDO::PARAM_STR);
             $req->bindValue( ':par_etage',$appartAVerif->getEtage(), PDO::PARAM_INT);
             $req->bindValue( ':par_id_proprietaire',$appartAVerif->getProprietaire()->getId(), PDO::PARAM_INT);
             $req->bindValue( ':par_id_ville',$appartAVerif->getVille()->getinsee(), PDO::PARAM_INT);
             $ret = $req->execute();
             $enreg = $req->fetch();

            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            if($enreg->nb >0)
            {
              return false;
            }
            else
            {
               return true;
            }
         
            // on demande l'exécution de la requête 
           
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $ret = false;
        }
        return $ret;
    }

}

