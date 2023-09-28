<h1 class="text-center">Ajout d'un locataire</h1>
<form action="/locataire/ajoutTrait" method='post'>
    <div class="row mb-3">
        <label for="superficie" class="col-lg-4 col-form-label">Nom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nom" value="<?php if (isset($leLocataire))  echo $leLocataire->getNom();  ?>" id="nom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="orientation" class="col-lg-4 col-form-label">Prénom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="prenom" value="<?php if (isset($leLocataire))  echo $leLocataire->getPrenom();  ?>" id="prenom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="orientation" class="col-lg-4 col-form-label">Mail</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="mail" value="<?php if (isset($leLocataire))  echo $leLocataire->getEmail();  ?>" id="mail">
        </div>
    </div>
    <div class="row mb-3">
        <label for="orientation" class="col-lg-4 col-form-label">Téléphone</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="telephone" value="<?php if (isset($leLocataire))  echo $leLocataire->getTelephone();  ?>" id="telephone">
        </div>
    </div>
    <div class="row mb-3">
        <label for="orientation" class="col-lg-4 col-form-label">Rue</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="rue" value="<?php if (isset($leLocataire))  echo $leLocataire->getRue();  ?>" id="rue">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Ville</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstVille">
                <?php foreach ($lesVilles as $uneVille) {
                    $insee = $uneVille->getInsee();
                    $nom = $uneVille->getNom().", ".$uneVille->getCodePostal();
                    $code_postal = $uneVille->GetCodePostal();

                    if (isset($lAppart) && $lAppart->getTypeAppartement()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                        // A MODIFIER
                    else
                        echo ("<option value=$insee>$nom</option>");
                    // à modifier
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="orientation" class="col-lg-4 col-form-label">Salaire mensuel</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="salaireMensuel" value="<?php if (isset($leLocataire))  echo $leLocataire->getSalaireMensuel();  ?>" id="salaireMensuel">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Impression</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstImpression">
                <?php foreach ($impressions as $uneImpression) {
                    $id = $uneImpression->getId();
                    $lib = $uneImpression->getLibelle();
                    if (isset($lImpression) && $lImpression->getLesImpressions()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Categorie socio-professionnelle</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstCategorieSocioprofessionnelle">
                <?php foreach ($categSociopro as $uneCategorieSocioprofessionnelle) {
                    $id = $uneCategorieSocioprofessionnelle->getId();
                    $lib = $uneCategorieSocioprofessionnelle->getLibelle();

                    if (isset($lCategorieSocioprofessionnelle) && $lCategorieSocioprofessionnelle->getLesCategorieSocioprofessionnelles()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>

    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>