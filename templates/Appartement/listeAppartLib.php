<!-- code html de la page-->
<h2 class="text-center">Les appartements libres</h2>

<?php
if (count($lAppart) == 0) {
    echo ("Il n'y a pas d'appartements libres");
} else {
?>
    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
            <th scope="col">Type d'appartement</th>
            
                <th class="col">rue</th>
                <th class="col">batiment</th>
                <th class="col">etage</th>
                <th class="col">superficie</th>
                <th scope="col">orientation</th>
                <th class="col">nbpiece</th>
                <th class="col">Proprietaire</th>
                <th class="col">Ville</th>
            </tr>
        </thead>
        <?php foreach ($lAppart as $unAppart) {
           echo ("<tr>");
           echo ("<td>" . $unAppart->getTypeAppartement()->getLibelle() . "</td>");
           echo ("<td>" . $unAppart->getRue() . "</td>");
           echo ("<td>" . $unAppart->getBatiment() . "</td>");
           echo ("<td>" . $unAppart->getEtage() . "</td>");
           echo ("<td>" . $unAppart->getSuperficie() . "</td>");
           echo ("<td>" . $unAppart->getOrientation()  . "</td>");
           echo ("<td>" . $unAppart->getNbPiece() . "</td>");
           echo ("<td>" . $unAppart->getProprietaire()->getNom() . "</td>");
           echo ("<td>" . $unAppart->getVille()->getnom() . "</td>");
           echo ("</tr>");
        } ?>
    </table>
<?php
}
?>