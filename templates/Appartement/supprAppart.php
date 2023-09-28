<!-- code html de la page-->
<h1 class="text-center">Suppression d'un appartement</h1>
<form action="/appartement/supprAppartTrait" method='post'>
    <div class="row mb-3">
            <table class="table table-bordered table-lg">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Rue</th>
                        <th class="col">batiment</th>
                        <th scope="col">Etage</th>
                        <th class="col">Superficie</th>
                        <th scope="col">Orientation</th>
                        <th class="col">NbPiece</th>
                        <th scope="col">TypeAppartement</th>
                        <th scope="col">Proprietaire</th>
                        <th scope="col">Ville</th>
                    </tr>
                </thead>
                <tr>
                    <td><?php echo $lAppart->getRue(); ?></td>
                    <td><?php echo $lAppart->getBatiment(); ?></td>
                    <td><?php echo $lAppart->getEtage();  ?></td>
                    <td><?php echo $lAppart->getSuperficie();  ?></td>
                    <td><?php echo $lAppart->getOrientation();  ?></td>
                    <td><?php echo $lAppart->getNbPiece();  ?></td>
                    <td><?php echo $lAppart->getTypeAppartement()->getId() ?></td>
                    <td><?php echo $lAppart->getProprietaire()->getId()?></td>
                    <td><?php echo $lAppart->GetVille()->getInsee() ?></td>
                </tr>
        </table>
    </div>

    <input type="hidden" name="rue" value="<?php echo $lAppart->getRue();?>" ><div class="row mb-3">
    <input type="hidden" name="batiment" value="<?php echo $lAppart->getBatiment();?>" ><div class="row mb-3">
    <input type="hidden" name="etage" value="<?php echo $lAppart->getEtage();?>" ><div class="row mb-3">
    <input type="hidden" name="superficie" value="<?php echo $lAppart->getSuperficie(); ?>" ><div class="row mb-3">
    <input type="hidden" name="orientation" value="<?php  echo $lAppart->getOrientation(); ?>" ><div class="row mb-3">
    <input type="hidden" name="nbpiece" value="<?php echo $lAppart->getNbPiece(); ?>" ><div class="row mb-3">
    <input type="hidden" name="lstTypeAppart" value="<?php echo $lAppart->getTypeAppartement()->getId(); ?>" ><div class="row mb-3">
    <input type="hidden" name="lstProprietaire" value="<?php echo $lAppart->getProprietaire()->getId(); ?>" ><div class="row mb-3">
    <input type="hidden" name="lstVille" value="<?php echo $lAppart->GetVille()->getInsee(); ?>" ><div class="row mb-3">
    <input type="hidden" name="idAppart" value="<?php if ($lAppart != null) echo $lAppart->getId(); ?>" ><div class="row mb-3">


    <div class="p-3 mb-4">
      <div class="text-center">
      <button type="submit" name="action" value="supprimer" class="btn btn-danger">Supprimer</button>
        
      </div>
    </div>
</form>
    <div class="p-3 mb-4">
        <div class="text-center">
             <a class="btn btn-primary" href="/appartement/suppr">Annuler</a>
        </div>
    </div>
<?php

if (isset($msg)) echo $msg;
?> 