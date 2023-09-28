<h1 class="text-center">Modification d'un propriétaire </h1>
<form action="/proprietaire/modifTrait" method='post'>
<div class="row mb-3">

    <div class="row mb-3">
        <label for="nom" class="col-lg-4 col-form-label">Nom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nom" value="<?php if (isset($leProprio))  echo $leProprio->getNom();  ?>" id="nom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="prenom" class="col-lg-4 col-form-label">Prenom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="prenom" value="<?php if (isset($leProprio))  echo $leProprio->getPrenom();  ?>" id="prenom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="telephone" class="col-lg-4 col-form-label">Téléphone</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="telephone" value="<?php if (isset($leProprio))  echo $leProprio->getTelephone();  ?>" id="telephone">
        </div>
    </div>
    <div class="row mb-3">
        <label for="email" class="col-lg-4 col-form-label">Email</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="email" value="<?php if (isset($leProprio))  echo $leProprio->getEmail();  ?>" id="email">
        </div>
    </div>
    <div class="row mb-3">
        <label for="rue" class="col-lg-4 col-form-label">Rue</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="rue" value="<?php if (isset($leProprio))  echo $leProprio->getEmail();  ?>" id="rue">
        </div>
    </div>
    <div class="row mb-3">
        <label for="lesVilles" class="col-lg-4 col-form-label">Ville</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstVilles">
                <?php foreach ($lesVilles as $uneVille) {
                    $insee = $uneVille->GetInsee();
                    $nom = $uneVille->GetNom();
                    $code_postal = $uneVille->GetCodePostal();
                    if (isset($leProprio) && $leProprio->GetVille()->GetInsee() == $insee)
                        echo ("<option selected value=$insee>$nom, $code_postal</option>");
                    else
                        echo ("<option value=$insee>$nom, $code_postal</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="lesModeGestions" class="col-lg-4 col-form-label">Mode de Gestion</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstGestionProprios">
                <?php foreach ($lesModesGestions as $uneGestion) {
                    $id = $uneGestion->getId();
                    $lib = $uneGestion->getLibelle();
                    if (isset($leProprio) && $leProprio->getGestionProprio()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>
    
    <input type="hidden" name="idProprio" value="<?php if ($leProprio != null) echo $leProprio->getId(); ?>" <div class="row mb-3">

    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>