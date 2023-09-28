<!-- code html de la page-->
<h1 class="text-center">Suppression d'un proprietaire</h1>
<form action="/proprietaire/supprForm" method='post'>
    <div class=" row mb-3">
        <?php
        if (count($lesProprietaires) == 0) {
            echo ("Aucun Proprietaires");
        } else {
        ?>
            <label for="lesProprietaires" class="col-lg-4 col-form-label">Choisissez le propriétaire à supprimer</label>
            <div class="col-sm-12">
                <!-- liste déroulante -->
                <select class="form-select form-select-md" onChange="submit();" name="lstProprios">
                    <?php foreach ($lesProprietaires as $unProprio) {
                        $id = $unProprio->getId();
                        $nom = $unProprio->getNom();
                        $rue = $unProprio->getRue();
                        $prenom = $unProprio->getPrenom();
                        $email = $unProprio->getEmail();
                        $telephone = $unProprio->getTelephone();
                        if (isset($_POST['lesProprietaires']) == true && $_POST['lesProprietaires'] == $id)
                            echo ("<option selected value=$id>$nom, $rue, $prenom, $email, $telephone </option>");
                        else
                            echo ("<option value=$id>$nom, $rue, $prenom, $email, $telephone</option>");
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