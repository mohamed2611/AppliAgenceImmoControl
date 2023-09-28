<!-- code html de la page-->
<h2 class="text-center">Les locataires</h2>

<?php
if (count($lesLocataires) == 0) {
    echo ("Il n'y a pas de locataires");
} else {
?>

    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th scope="col">Prénom et nom du locataire</th>
                <th scope="col">e-Mail</th>
                <th scope="col">L'impression sur le locataire</th>
            </tr>
        </thead>
        <?php foreach ($lesLocataires as $locataire) {
            echo ("<tr>");
            echo ("<td>" . $locataire->getPrenom() ." " .strtoupper($locataire->getNom()). "</td>");
            echo ("<td>" . $locataire->getEmail() . "</td>");
            echo ("<td>" . $locataire->getLImpression()->getLibelle() . "</td>");
            echo ("</tr>");
        } ?>
    </table>
<?php
}
?>