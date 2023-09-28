<!-- code html de la page-->
<h1 class="text-center">Modification d'un contrat</h1>
<form action="/contrat/modifForm" method='post'>
    <div class=" row mb-3">
        <?php
        if (count($lesContrats) == 0) {
            echo ("Aucun contrat");
        } else {
        ?>
            <label for="lesDem" class="col-lg-4 col-form-label">Choisissez le contrat à modifier</label>
            <div class="col-sm-12">
                <!-- liste déroulante -->
                <select class="form-select form-select-md" onChange="submit();" name="lstContrat">
                    <?php foreach ($lesContrats as $unContrat) {
                        $id = $unContrat->getId();
                        $libelle = "<h5>Locataire : ".  $unContrat->getLeLocataire()->getNom()." " .$unContrat->getLeLocataire()->getPrenom()."  <h5>Garant :". $unContrat->getLeGarant()->getNom() . " " . $unContrat->getLeGarant()->getPrenom()."  <h5>lieu :"." " . $unContrat->getLAppartement()->getRue(). " ".$unContrat->getLAppartement()->getVille()->GetNom() ;
                        if (isset($_POST['lstContrat']) == true && $_POST['listContrat'] == $id)
                            echo ("<option selected value=$id>$libelle</option>");
                        else
                            echo ("<option value=$id>$libelle</option>");
                    } ?>
                </select>

            </div>
        <?php
        }
        ?>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>