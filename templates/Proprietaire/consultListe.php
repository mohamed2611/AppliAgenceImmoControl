<!-- code html de la page-->
<h2 class="text-center">Les Proprietaires</h2>

<?php
if (count($lesProprios) == 0) {
    echo ("Il n'y a pas de Propriétaires");
} else {
?>
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
        <?php foreach ($lesProprios as $unProprio) {
            echo ("<tr>");
            echo ("<td>" . $unProprio->getNom() . "</td>");
            echo ("<td>" . $unProprio->getPrenom()  . "</td>");
            echo ("<td>" . $unProprio->getEmail() . "</td>");
            echo ("<td>" . $unProprio->getTelephone() . "</td>");
            echo ("<td>" . $unProprio->getRue()  . "</td>");
            echo ("<td>" . $unProprio->getGestionProprio()->getLibelle() . "</td>");
            echo ("<td>" . $unProprio->getVille()->getNom() . "</td>");
            echo ("</tr>");
        } ?>
    </table>
<?php
}
?>