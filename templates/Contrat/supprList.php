<!-- code html de la page-->
<h1 class="text-center">Supprimer un contrat</h1>
<form action="/contrat/supprForm" method="post">
        <table class="table table-bordered table-lg">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Adresse Appartement</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            <?php foreach ($lesContrats as $unContrat) { ?>
                <tr>
                    <!-- ... Affichage des données du contrat ... -->
                    <div class="p-3 mb-4">
                        <div class="text-center">
                            <!-- Formulaire caché pour supprimer le contrat -->
                            <form action="/contrat/supprForm" method="post">
                            <td><?php echo (" locataire: " . $unContrat->getLeLocataire()->getNom()." ".$unContrat->getLeLocataire()->getPrenom() ." Adresse : ".$unContrat->getLAppartement()->getRue()." ".$unContrat->getLAppartement()->getVille()->getNom() ." ".$unContrat->getLAppartement()->getVille()->getCodePostal());?></td>
                            <td>    <input type="hidden" name="tbContrat" value="<?php echo $unContrat->getId(); ?>">
                                <button type="submit" class="btn btn-danger" name="supprContrat">Supprimer</button></td>
                            </form>
                        </div>
                    </div>
                </tr>
            <?php } ?>
        </table>
</form>
<?php
if (isset($msg)) echo $msg;
?> 