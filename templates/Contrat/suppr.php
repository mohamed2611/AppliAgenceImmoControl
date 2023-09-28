<!-- code html de la page-->
<h1 class="text-center">Suppression d'un contrat</h1>
<form action="/contrat/supprTrait" method='post'>
    <div class="row mb-3">
            <table class="table table-bordered table-lg">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Date début</th>
                        <th class="col">Date fin</th>
                        <th scope="col">Montant loyer Hors charge</th>
                        <th class="col">Montant des charges</th>
                        <th scope="col">Montant de la caution</th>
                        <th class="col">Salaire du locataire</th>
                        <th scope="col">Garant</th>
                        <th scope="col">Locataire</th>
                        <th scope="col">Appartement</th>
                    </tr>
                </thead>
                <tr>
                    <td><?php echo $contrat->getDebut()->format('Y-m-d'); ?></td>
                    <td><?php echo $contrat->getFin()->format('Y-m-d'); ?></td>
                    <td><?php echo $contrat->getMontantLoyerHc();  ?></td>
                    <td><?php echo $contrat->getMontantCharge();  ?></td>
                    <td><?php echo $contrat->getMontantCaution();  ?></td>
                    <td><?php echo $contrat->getSalaireLocataire();  ?></td>
                    <td><?php echo $contrat->getLeGarant()->getId() ?></td>
                    <td><?php echo $contrat->getLeLocataire()->getId()?></td>
                    <td><?php echo $contrat->getLAppartement()->getId() ?></td>
                </tr>
        </table>
    </div>

    <input type="hidden" name="idContrat" value="<?php echo $contrat->getId();?>" ><div class="row mb-3">
    <input type="hidden" name="debut" value="<?php echo $contrat->getDebut()->format('Y-m-d');?>" ><div class="row mb-3">
    <input type="hidden" name="fin" value="<?php echo $contrat->getFin()->format('Y-m-d');?>" ><div class="row mb-3">
    <input type="hidden" name="mtHC" value="<?php echo $contrat->getMontantLoyerHc(); ?>" ><div class="row mb-3">
    <input type="hidden" name="mtC" value="<?php  echo $contrat->getMontantCharge(); ?>" ><div class="row mb-3">
    <input type="hidden" name="mtCaution" value="<?php echo $contrat->getMontantCaution(); ?>" ><div class="row mb-3">
    <input type="hidden" name="SalaireLoc" value="<?php echo $contrat->getSalaireLocataire(); ?>" ><div class="row mb-3">
    <input type="hidden" name="lstGarant" value="<?php echo $contrat->getLeGarant()->getId(); ?>" ><div class="row mb-3">
    <input type="hidden" name="lstLocataire" value="<?php echo $contrat->getLeLocataire()->getId(); ?>" ><div class="row mb-3">
    <input type="hidden" name="lstAppart" value="<?php echo $contrat->getLAppartement()->getId(); ?>"> <div class="row mb-3">


    <div class="p-3 mb-4">
      <div class="text-center">
      <button type="submit" name="action" value="supprimer" class="btn btn-danger">Supprimer</button>
        <button type="submit" name="action" value="annuler" class="btn btn-primary">Annuler</button>
      </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?> 