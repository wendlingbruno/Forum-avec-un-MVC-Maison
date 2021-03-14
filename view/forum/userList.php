<?php

ob_start(); 

?>

<a href="./index.php">Retour</a>

<h2>Liste des utilisateurs</h2>

<h2>Nombre d'utilisateurs: <?= $users->rowCount(); ?></h2>
    <table>
        <thead>
            <tr>
            <th>Pseudo</th>
            <th>Inscrit depuis le</th>
            <th>Rôle</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while($user = $users->fetch(PDO::FETCH_ASSOC)){
               echo "<tr class='bordure'> <td><a href='index.php?action=detailUser&id=".$user['id_utilisateur']."'>".$user['pseudonyme']."</a></td>";
               echo "<td>". $user["date_inscription_utilisateur"]."</td>";
               echo "<td>". $user["role"]."</td>";
              echo "</tr>";

            }
            ?>
        </tbody>
    </table>

<?php

$titre = "Liste des utilisateurs";
$contenu = ob_get_clean();
require "views/template.php";