<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Entity\Locataire;
use App\Entity\Impression;
use App\Entity\Ville;
use App\Entity\CategorieSocioprofessionnelle;
use App\Repository\Repository;


class LocataireRepository extends Repository
{
    public function ajoutLocataire(Locataire $locataireACreeer) : bool
    {
        $db = $this->dbConnect();
        try {
            // On prépare la requête SELECT
            $req = $db->prepare("insert into immo_Locataire 
            values (0, :par_nom, :par_prenom, :par_mail, :par_telephone, :par_rue, :par_salaire_mensuel, :par_id_impression, :par_id_categSocioPro, :par_insee_ville)");
            $req->bindValue(':par_nom', $locataireACreeer->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $locataireACreeer->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_mail', $locataireACreeer->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':par_telephone', $locataireACreeer->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':par_rue', $locataireACreeer->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_salaire_mensuel', $locataireACreeer->getSalaireMens(), PDO::PARAM_STR);
            $req->bindValue(':par_id_impression', $locataireACreeer->getLImpression()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_categSocioPro', $locataireACreeer->getLaCategSocioPro()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_insee_ville', $locataireACreeer->getLaVille()->getInsee(), PDO::PARAM_INT);

            $ret = $req->execute();
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
    }
    
    public function getLesLocataires(): array
    {
        // ON CRÉE LE TABLEAU QUI CONTIENDRA LA LISTE DES LOCATAIRES
        $lesLocataires = array();
    
        // ON RÉCUPÈRE L'OBJET QUI PERMET DE TRAVAILLER AVEC LA BASE DE DONNÉES
        $db = $this->dbConnect();
    
        $req = $db->prepare("SELECT immo_locataire.id as id,
        immo_locataire.nom as nom, prenom,
        email,
        telephone,code_postal as codePostal,
        rue,salaire_mensuel as salaireMens,
        immo_Impression.libelle as libelle,
        immo_categorie_socioprofessionnelle.libelle as libelleS,
        immo_ville.nom as nomVille
         FROM immo_locataire 
         join immo_ville on id_ville = immo_ville.insee 
         join immo_impression on id_impression = immo_impression.id 
         join immo_categorie_socioprofessionnelle on immo_categorie_socioprofessionnelle.id = id_categSocioPro;");
    
        // ON DEMANDE L'EXÉCUTION DE LA REQUÊTE
        $req->execute();
    
        $lesEnregs = $req->fetchAll();
    
        foreach ($lesEnregs as $enreg) {

            // ON CRÉE UNE INSTANCE DE LOCATAIRE EN UTILISANT LES DONNÉES DE CHAQUE ENREGISTREMENT

            $locataire = new Locataire(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom,
                $enreg->email,
                $enreg->telephone,
                $enreg->rue,
                $enreg->salaireMens,
                new Impression(null,$enreg->libelle),
                new CategorieSocioProfessionnelle(null,$enreg->libelleS),
                new Ville(null,$enreg->nomVille,$enreg->codePostal)
            );
    
            // ON AJOUTE L'INSTANCE DE LOCATAIRE DANS LA LISTE
            array_push($lesLocataires, $locataire);
        }
    
        return $lesLocataires;   
    }
    public function getUnLocataire($id): ?Locataire
    {

        // ON RÉCUPÈRE L'OBJET QUI PERMET DE TRAVAILLER AVEC LA BASE DE DONNÉES
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT immo_locataire.id as id,
        immo_locataire.nom as nom, prenom,
        email,telephone,code_postal as codePostal, rue,salaire_mensuel as salaireMens, immo_Impression.libelle as libelle,immo_categorie_socioprofessionnelle.libelle as libelleS,
        immo_ville.nom as nomVille
         FROM immo_locataire 
         join immo_ville on id_ville = immo_ville.insee 
         join immo_impression on id_impression = immo_impression.id 
         join immo_categorie_socioprofessionnelle on immo_categorie_socioprofessionnelle.id = id_categSocioPro where immo_locataire.id = :par_id");

        // ON AFFECTE UNE VALEUR AU PARAMÈTRE DÉCLARÉ DANS LA REQUÊTE 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // ON DEMANDE L'EXÉCUTION DE LA REQUÊTE 
        $req->execute();
        $enreg = $req->fetch();
        if ($enreg == false) { // LE LOCATAIRE N'EXISTE PAS 

            return null;

        } else { // LE LOCATAIRE  EXISTE 
            // ON CRÉE UNE INSTANCE
            $unLocataire = new Locataire(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom,
                $enreg->email,
                $enreg->telephone,
                $enreg->rue,
                $enreg->salaireMens,
                new Impression(null,$enreg->libelle),
                new CategorieSocioProfessionnelle(null,$enreg->libelleS),
                new Ville(null,$enreg->nomVille,$enreg->codePostal)
            );
            return $unLocataire;
        }
    }
    public function modifLocataire(Locataire $locataireAModifier): bool
    {
        // ON RÉCUPÈRE L'OBJET QUI PERMET DE TRAVAILLER AVEC LA BASE DE DONNÉES
        $db = $this->dbConnect();

        try {

            // ON PRÉPARE LA REQUÊTE UPDATE
            $req = $db->prepare("UPDATE immo_locataire
            SET  nom = :par_nom,
            prenom = :par_prenom,
            email = :par_email,
            telephone = :par_telephone,
            rue = :par_rue,
            salaire_mensuel = :par_salaire_mensuel,
            id_impression = :par_id_impression
            WHERE immo_locataire.id = :par_id_locataire");

            // ON AFFECTE UNE VALEUR AU PARAMÈTRE DÉCLARÉ DANS LA REQUÊTE 
            $req->bindValue(':par_nom', $locataireAModifier->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $locataireAModifier->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_email', $locataireAModifier->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':par_telephone', $locataireAModifier->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':par_rue', $locataireAModifier->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_salaire_mensuel', $locataireAModifier->getSalaireMens(), PDO::PARAM_STR );
            $req->bindValue(':par_id_impression', $locataireAModifier->getLImpression()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_locataire', $locataireAModifier->getId(), PDO::PARAM_INT);
            
            // ON DEMANDE L'EXÉCUTION DE LA REQUÊTE 
            $ret = $req->execute();
            $ret = true;

        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
    
    //---------------------------------------------- SUPPRESSION----------------------------------------

    public function supprLocataire(Locataire $locataireASupprimer): bool
    {
        // ON RÉCUPÈRE L'OBJET QUI PERMET DE TRAVAILLER AVEC LA BASE DE DONNÉES
        $db = $this->dbConnect();
        try {

            // ON PRÉPARE LA REQUÊTE UPDATE

            $req = $db->prepare("DELETE 
            FROM immo_locataire
            WHERE immo_locataire.id = :par_id_locataire");
            
            // ON AFFECTE UNE VALEUR AU PARAMÈTRE DÉCLARÉ DANS LA REQUÊTE 

            $req->bindValue(':par_id_locataire', $locataireASupprimer->getId(), PDO::PARAM_INT);

            // ON DEMANDE L'EXÉCUTION DE LA REQUÊTE 
            
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
    
    
    }
    ?>