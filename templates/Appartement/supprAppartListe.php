<!-- code html de la page-->
<h1 class="text-center">Supression d'un appartement</h1>
<form action="/appartement/supprAppartForm" method='post'>
    <div class=" row mb-3">
        <?php
        if (count($lAppart) == 0) {
            echo ("Aucun appartement");
        } else {
        ?>
            <label for="lesDem" class="col-lg-4 col-form-label">Choisissez l'appartement à supprimer</label>
            <div class="col-sm-12">
                <!-- liste déroulante -->
                <select class="form-select form-select-md" onChange="submit();" name="lstAppart">
                <option selected value=0>veuillez selectionné un appartement a suprimmé</option>
                    <?php foreach ($lAppart as $unAppart) {
                        $id = $unAppart->getId();
                        $libelle = $unAppart->getTypeAppartement()->getLibelle() . ' , superficie : ' . $unAppart->getSuperficie();
                        if (isset($_POST['lstAppart']) == true && $_POST['listAppart'] == $id)
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