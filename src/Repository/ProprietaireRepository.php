<?php
namespace App\Repository;

use PDO;
use PDOEXCEPTION;
use App\Entity\Proprietaire;
use App\Repository\Repository;
use App\Entity\GestionProprio;
use App\Entity\Ville;



//class dont on a besoin (classe Repository.php obligatoire)

class ProprietaireRepository extends Repository
{

    public function ajoutProprietaire(Proprietaire $proprioACreer)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("insert into immo_proprietaire 
            values (0,:par_nom, :par_rue,:par_prenom,:par_email,:par_telephone,:par_id_gestionProprio,:par_id_ville)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_nom', $proprioACreer->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_rue', $proprioACreer->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $proprioACreer->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_email', $proprioACreer->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':par_telephone', $proprioACreer->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':par_id_gestionProprio', $proprioACreer->getGestionProprio()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_ville', $proprioACreer->getVille()->getInsee(), PDO::PARAM_INT);
            
            // on demande l'exécution de la requête 
           
            $ret = $req->execute();
           
        } catch (PDOException $e) {
            $ret = false;

        }
        return $ret;
    }
    public function verifProprietaire(Proprietaire $proprioACreer)
    {
        try{ 
            
            // on récupère l'objet qui permet de travailler avec la base de données
            $db = $this->dbConnect();
            $req = $db->prepare("select count(*)  as nb from immo_proprietaire 
                                join immo_ville on immo_ville.insee = id_ville
                                where immo_proprietaire.nom = :par_nom and prenom = :par_prenom and immo_ville.nom = :par_id_ville ");
            $req->bindValue(':par_nom', $proprioACreer->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $proprioACreer->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_id_ville', $proprioACreer->getVille()->getInsee(), PDO::PARAM_INT);
            $ret = $req->execute();
            $enreg = $req->fetch();

            if($enreg -> nb > 0){
              $ret = false;

            }else{
              $ret = true;
            }
            var_dump($ret);
            return $ret;
          
        } catch (PDOException $e) {
            $ret = false;
            var_dump($e ->GetMessage()) ;
        }
        
    }
        public function getLesProprios(): array
        {
        // on crèe le tableau qui contiendra la liste des propriétaires
        $lesProprios = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select immo_proprietaire.id as id, nom, prenom, email, telephone, rue, id_ville,
                        immo_gestionProprio.libelle
                        from immo_proprietaire
                        join immo_GestionProprio on immo_GestionProprio.id = id_GestionProprio");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unProprio = new Proprietaire(
                $enreg->id,
                $enreg->nom,
                $enreg->rue,
                $enreg->prenom,         
                $enreg->email,
                $enreg->telephone,
                new GestionProprio(null, $enreg->libelle),
                new Ville(null, $enreg->nom),
                
            );
            // on ajout l'instance dans la liste
            array_push($lesProprios, $unProprio);
        }
        return $lesProprios;
        
    }
    public function modifProprietaire(Proprietaire $proprioAModifier): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("update immo_proprietaire
            set  nom = :par_nom,
            rue = :par_rue,
            prenom = :par_prenom,
            email = :par_email,
            telephone = :par_telephone,
            id_gestionProprio = :par_id_gestionProprio,
            id_ville = :par_id_ville
            where immo_proprietaire.id = :par_id_proprietaire");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_nom', $proprioAModifier->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_rue', $proprioAModifier->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $proprioAModifier->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_email', $proprioAModifier->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':par_telephone', $proprioAModifier->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':par_id_gestionProprio', $proprioAModifier->getGestionProprio()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_ville', $proprioAModifier->GetVille()->getInsee(), PDO::PARAM_INT);
            $req->bindValue(':par_id_proprietaire', $proprioAModifier->getId(), PDO::PARAM_INT);

            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $ret = false;
        }

        return $ret;
    }
    public function getUnProprietaire(int $id): Proprietaire
    {
       
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select immo_proprietaire.id, immo_proprietaire.nom, rue, prenom, email, telephone, libelle, immo_ville.nom,
        immo_ville.insee
                from immo_proprietaire
                join immo_gestionproprio on immo_gestionproprio.id = id_gestionProprio
                join immo_ville on insee = id_ville
                where immo_proprietaire.id = :par_id");
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);

        // on demande l'exécution de la requête 
        $req->execute();
        $enreg = $req->fetch();
            // on crée une instance
            $unProprio = new Proprietaire(
                $enreg->id,
                $enreg->nom,
                $enreg->rue,
                $enreg->prenom,
                $enreg->email,
                $enreg->telephone,
                new GestionProprio($enreg->id, $enreg->libelle),
                new Ville($enreg->insee, $enreg->nom,null)
            );
            // on ajout l'instance dans la liste
        
        return $unProprio;
    }
    public function supprProprietaire(Proprietaire $proprioASupprimer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("delete from immo_proprietaire
            where id = :par_id_proprietaire");
            // on affecte une valeur au paramètre déclaré dans la requête 
           
            $req->bindValue(':par_id_proprietaire', $proprioASupprimer->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $ret = false;
        }
        return $ret;
    }
                    // a verifier//

      // public function getLesProprios(): ?Proprietaire
      // {
      //     // on crèe le tableau qui contiendra la liste des proprietaires
      //     $lesProprios = array();
      //     // on récupère l'objet qui permet de travailler avec la base de données
      //     $db = $this->dbConnect();
      //     $req = $db->prepare("select .id as id, nom, prenom, email, telephone, rue, id_ville, gestionProprio.libelle
      //                     from Proprietaire
      //                     join Gestion_Proprio on GestionProprio.id = id_GestionProprio = :par_id" );
      //     // on demande l'exécution de la requête 
      //     $req->execute();
      //     $lesEnregs = $req->fetchAll();
      //     foreach ($lesEnregs  as $enreg) {
      //         // on crée une instance
      //         $unProprio = new Proprietaire(
      //             $enreg->id,
      //             $enreg->nom,
      //             $enreg->prenom,
      //             $enreg->email,
      //             $enreg->telephone,
      //             $enreg->rue,
      //             new id_ville(null, $enreg->libelle),
      //             new gestion_proprio(null, $enreg->libelle)
      //         );
      //         // on ajout l'instance dans la liste
      //         array_push($lesProprios, $unProprio);
      //     }
      //     return $lesProprios;}
     
    









    /*
    public function modifAppartement(Appartement $appartAModifier): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("update appartement
            set  superficie = :par_superficie,
            orientation = :par_orientation,
            id_type_appartement=:par_id_type_appart
            where id = :par_id_appart");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_superficie', $appartAModifier->getSuperficie(), PDO::PARAM_STR);
            $req->bindValue(':par_orientation', $appartAModifier->getOrientation(), PDO::PARAM_STR);
            $req->bindValue(':par_id_type_appart', $appartAModifier->getTypeAppartement()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_appart', $appartAModifier->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
    public function getLesApparts(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesApparts = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select appartement.id as id, 
                        type_appartement.libelle,superficie, orientation
                        from appartement
                join type_appartement on type_appartement.id = id_type_appartement");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unAppart = new Appartement(
                $enreg->id,
                $enreg->superficie,
                $enreg->orientation,
                new TypeAppartement(null, $enreg->libelle)
            );
            // on ajout l'instance dans la liste
            array_push($lesApparts, $unAppart);
        }
        return $lesApparts;
    }
    public function getUnAppartement($id): ?Appartement
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select appartement.id,superficie, orientation, id_type_appartement
                            from appartement 
                            join type_appartement on type_appartement.id = id_type_appartement where appartement.id = :par_id");
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
                $enreg->superficie,
                $enreg->orientation,
                new TypeAppartement($enreg->id_type_appartement, null)
            );
            return $unAppart;
        }
    }
    */

}