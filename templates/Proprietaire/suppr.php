
<!-- code html de la page-->
<h1 class="text-center">Suppression d'un propriétaire </h1>
<form action="/proprietaire/supprTrait" method='post'>
    <div class="row mb-3">
            <table class="table table-bordered table-lg">
                <thead class="table-light">
                    <tr>
                    <th scope="col">nom</th>
                    <th class="col">prenom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telephone</th>
                    <th scope="col">Rue</th>
                    <th scope="col">Mode de gestion</th>
                    <th scope="col">Ville</th>
                    </tr>
                </thead>
                <tr>
                    <td><?php echo $lesProprios->getNom(); ?></td>
                    <td><?php echo $lesProprios->getPrenom(); ?></td>
                    <td><?php echo $lesProprios->getEmail();  ?></td>
                    <td><?php echo $lesProprios->getTelephone();  ?></td>
                    <td><?php echo $lesProprios->getRue();  ?></td>
                    <td><?php echo $lesProprios->getGestionProprio()->getLibelle();  ?></td>
                    <td><?php echo $lesProprios->getVille()->getNom() ?></td>
                </tr>   
        </table>
    </div>

    <input type="hidden" name="idProprio" value="<?php echo $lesProprios->getId();?>" ><div class="row mb-3">
    <input type="hidden" name="nom" value="<?php echo $lesProprios->getNom();?>" ><div class="row mb-3">
    <input type="hidden" name="prenom" value="<?php echo $lesProprios->getPrenom();?>" ><div class="row mb-3">
    <input type="hidden" name="email" value="<?php echo $lesProprios->getEmail(); ?>" ><div class="row mb-3">
    <input type="hidden" name="telephone" value="<?php  echo $lesProprios->getTelephone(); ?>" ><div class="row mb-3">
    <input type="hidden" name="rue" value="<?php echo $lesProprios->getRue(); ?>" ><div class="row mb-3">
    <input type="hidden" name="lstGestionProprios" value="<?php echo $lesProprios->getGestionProprio()->getID(); ?>" ><div class="row mb-3">
    <input type="hidden" name="lstVilles" value="<?php echo $lesProprios->getVille()->getInsee(); ?>" ><div class="row mb-3">


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