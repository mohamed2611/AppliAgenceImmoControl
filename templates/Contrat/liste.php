<!-- code html de la page-->
<h2 class="text-center">Les contrats</h2>


    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th scope="col">date début</th>
                <th class="col">date fin</th>
                <th scope="col">montant loyer charge</th>
                <th scope="col">propriétaire</th>
                <th scope="col">gérant</th>
                <th scope="col">appartement</th>
            </tr>
        </thead>
        <?php foreach ($lesContrats as $unContrat) {
            echo ("<tr>");
            echo ("<td>" . $unContrat->getDebut()->format('Y-m-d') . "</td>"); // Format as 'YYYY-MM-DD'
            echo ("<td>" . $unContrat->getFin()->format('Y-m-d') . "</td>");   // Format as 'YYYY-MM-DD'
            echo ("<td>" . ($unContrat->getMontantCharge() + $unContrat->getMontantLoyerHc()) . "</td>");

            echo ("<td>" . $unContrat->getLeLocataire()->getNom() . $unContrat->getLeLocataire()->getPrenom()  . "</td>");
            echo ("<td>" . $unContrat->getLeGarant()->getNom().$unContrat->getLeGarant()->getPrenom()  . "</td>");
            echo ("<td>" . $unContrat->getLAppartement()->getRue() . "  ". $unContrat->getLAppartement()->getVille()->getNom() ."  ". $unContrat->getLAppartement()->getVille()->getCodePostal(). "</td>");
            echo ("</tr>");
        } ?>
    </table>
<?php
?>