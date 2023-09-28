<h1 class="text-center">Ajout d'un appartement</h1>
<form action="/appartement/ajoutTrait" method='post'>

    <div class="row mb-3">
        <label for="rue" class="col-lg-4 col-form-label">rue</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="rue" value="<?php if (isset($unAppart))  echo $unAppart->getRue();  ?>" id="rue">
        </div>
    </div>

    <div class="row mb-3">
        <label for="batiment" class="col-lg-4 col-form-label">batiment</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="batiment" value="<?php if (isset($unAppart))  echo $lAppart->getBatiment();  ?>" id="batiment">
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="etage" class="col-lg-4 col-form-label">etage</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="etage" value="<?php if (isset($unAppart))  echo $lAppart->getEtage();  ?>" id="etage">
        </div>
    </div>

   
    <div class="row mb-3">
        <label for="superficie" class="col-lg-4 col-form-label">Superficie</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="superficie" value="<?php if (isset($lAppart))  echo $lAppart->getSuperficie();  ?>" id="superficie">
        </div>
    </div>
   
    <div class="row mb-3">
        <label for="orientation" class="col-lg-4 col-form-label">Orientation</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="orientation" value="<?php if (isset($lAppart))  echo $lAppart->getOrientation();  ?>" id="orientation">
        </div>
    </div>

    <div class="row mb-3">
        <label for="nbpiece" class="col-lg-4 col-form-label">nombre de piece</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nbpiece" value="<?php if (isset($unAppart))  echo $lAppart->getNbPiece();  ?>" id="nbpiece">
        </div>
    </div>
   
    <div class="row mb-3">
        <label for="lstTypeAppart" class="col-lg-4 col-form-label">Type d'appartement</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstTypeAppart">
                <?php foreach ($lesTypes as $unType) {
                    $id = $unType->getId();
                    $lib = $unType->getLibelle();
                    if (isset($lAppart) && $lAppart->getTypeAppartement()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label for="lstProprietaire" class="col-lg-4 col-form-label">proprietaire</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstProprietaire">
                <?php foreach ($lesProprio as $unProprio) {
                    $id = $unProprio->getId();
                    $nom = $unProprio->getNom();
                    $prenom = $unProprio->getPrenom();
                    $email = $unProprio->getEmail();
                    $lib = $nom.'  '.$prenom.'  '.$email;
                    if (isset($unAppart) && $unAppart->getLesProprios()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label for="lstVille" class="col-lg-4 col-form-label">Ville</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstVille">
                <?php foreach ($lesVilles as $uneVille) {
                    $id = $uneVille->getInsee();
                    $lib = $uneVille->getNom();
                    if (isset($unAppart) && $unAppart->GetVille()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label for="lstSecteur" class="col-lg-4 col-form-label">Secteur</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstSecteur">
                <?php foreach ($lesSecteurs as $unSecteur) {
                    $id = $unSecteur->getId();
                    $lib = $unSecteur->getLibelle();
                    if (isset($lAppart) && $lAppart->getSecteurs()->getId() == $id)
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