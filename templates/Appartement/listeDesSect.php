<h1 class="text-center">Liste des appartements par secteur </h1>
<form action="/appartement/listeDesSectTrait" method='post'>
    <div class=" row mb-3">
        
            <label for="lesDem" class="col-lg-4 col-form-label">Choisissez un secteur </label>
            <div class="col-sm-12">
                <!-- liste déroulante -->
                <select class="form-select form-select-md" onChange="submit();" name="lstSecteur">
                <option selected value=0>veuillez selectionné un secteur </option>
                    <?php foreach ($lesSecteurs as $unSecteur) {
                        $id = $unSecteur->getId();
                        $libelle = $unSecteur->getLibelle();
                        if (isset($_POST['lstSecteur']) == true && $_POST['lstSecteur'] == $id)
                            echo ("<option selected value=$id>$libelle</option>");
                        else
                            echo ("<option value=$id>$libelle</option>");
                    } ?>
                </select>

            </div>
    </div>


<?php  
    if (isset($lesAppartsUnSecteur)) {
?>
  <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                
                <th class="col">rue</th>
                <th class="col">batiment</th>
                <th class="col">Proprietaire</th>
                <th class="col">Ville</th>
            </tr>
        </thead>
        <?php foreach ($lesAppartsUnSecteur as $unAppart) {
            echo ("<tr>");
            echo ("<td>" . $unAppart->getRue() . "</td>");
            echo ("<td>" . $unAppart->getBatiment() . "</td>");
            echo ("<td>" . $unAppart->getProprietaire()->getNom() . "</td>");
            echo ("<td>" . $unAppart->getVille()->getnom() . "</td>");

            echo ("</tr>");
        } ?>
    </table>
<?php 
    }
?>

</form>
<?php
if (isset($msg)) echo $msg;
?>