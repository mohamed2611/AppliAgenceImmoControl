<h1 class="text-center">Ajout d'un contrat</h1>
<form action="/contrat/ajoutTrait" method='post'>
    <div class="row mb-3">
    <label for="debut" class="col-lg-4 col-form-label">Date debut</label>
    <div class="col-sm-12">
        <input type="date" class="form-control" name="debut" value="<?php if (isset($contrat)) echo $contrat->getDebut()->format('Y-m-d'); ?>" id="debut">
    </div>
</div>
<div class="row mb-3">
    <label for="fin" class="col-lg-4 col-form-label">Date fin</label>
    <div class="col-sm-12">
        <input type="date" class="form-control" name="fin" value="<?php if (isset($contrat)) echo $contrat->getFin()->format('Y-m-d'); ?>" id="fin">
    </div>
</div>
    <div class="row mb-3">
        <label for="mtHC" class="col-lg-4 col-form-label">Montant loyer Hors charge :
</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="mtHC" value="<?php if (isset($contrat))  echo $contrat->getMontantLoyerHc();  ?>" id="mtHC">
        </div>
    </div>
    <div class="row mb-3">
        <label for="mtC" class="col-lg-4 col-form-label">Montant des charges</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="mtC" value="<?php if (isset($contrat))  echo $contrat->getMontantCharge();  ?>" id="mtC">
        </div>
    </div>
    <div class="row mb-3">
        <label for="mtCaution" class="col-lg-4 col-form-label">Montant de la caution</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="mtCaution" value="<?php if (isset($contrat))  echo $contrat->getMontantCaution();  ?>" id="mtCaution">
        </div>
    </div>
    <div class="row mb-3">
        <label for="SalaireLoc" class="col-lg-4 col-form-label">Salaire du locataire</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="SalaireLoc" value="<?php if (isset($contrat))  echo $contrat->getSalaireLocataire();  ?>" id="SalaireLoc">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Garant</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstGarant">
                <?php foreach ($lesGarants as $unGarant) {
                    $id = $unGarant->getId();
                    $garant_nom = $unGarant->getNom();
                    $garant_prenom = $unGarant->getPrenom();
                    if (isset($contrat) && $contrat->getLeGarant()->getId() == $id)
                        echo ("<option selected value=$id>$garant_nom,$garant_prenom</option>");
                    else
                        echo ("<option value=$id>$garant_nom,$garant_prenom</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Locataire</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstLocataire">
                <?php foreach ($lesLocataires as $leLocataire) {
                    $id = $leLocataire->getId();
                    $locataire_nom = $leLocataire->getNom();
                    $locataire_prenom = $leLocataire->getPrenom();
                    $locataire_telephone = $leLocataire->getTelephone();
                    if (isset($contrat) && $contrat->getLeLocataire()->getId() == $id)
                        echo ("<option selected value=$id>$locataire_nom,$locataire_prenom, $locataire_telephone </option>");
                    else
                        echo ("<option value=$id>$locataire_nom,$locataire_prenom, $locataire_telephone </option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Appartement</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstAppart">
                <?php foreach ($lesApparts as $unAppart) {
                    $id = $unAppart->getId();
                    $rue = $unAppart->getRue();
                    $laVille = $unAppart->getVille()->getNom();
                    if (isset($contrat) && $contrat->getLAppartement()->getId() == $id)
                        echo ("<option selected value=$id>$rue,$laVille</option>");
                    else
                        echo ("<option value=$id>$rue,$laVille</option>");
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