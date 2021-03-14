<?php if (!empty($_GET['id'])){ ?>
<h2>Recherche</h2>
<?php
$data = $result['data'];
$totalRows = count($data['message']);
if ($totalRows > 0){ ?>
<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>Nom de la catégorie</th>
            <th>Nom du sujet</th>
            <th>Auteur</th>
            <th>Message</th>
            <th>Date du message</th>
        </tr>
    </thead>
    <tbody>

<?php
foreach ($data['message'] as $resul){

    $user = $resul->getUtilisateur();
    $sujet = $resul->getSujet();
    $cat = $sujet->getCategorie();
    //var_dump($cat->getNomcategorie());
    echo "<tr><td>";
    echo "<a href='./?ctrl=forum&method=allTopicsCategorie&id=".$cat->getId()."'>".$cat->getNomcategorie()."</a></td><td>";
    if ($sujet->getStatutsujet()){
        echo "<span uk-icon='lock'></span>";
    }
    echo "<a href='./?ctrl=forum&method=show&id=".$sujet->getId()."'>".$sujet->getTitreSujet()."</a></td>";
    echo "<td><a href='./?ctrl=user&method=profil&id=".$user->getId()."'>".$user->getPseudonyme()."</a></td>";
    echo "<td>".$resul->getTextemessage()."</td>";
    echo "<td>".$resul->getDatemessage()."</td></tr>";

}
?>
    </tbody>
    <tfoot>
        <tr>
            <th>Nom de la catégorie</th>
            <th>Nom du sujet</th>
            <th>Auteur</th>
            <th>Message</th>
            <th>Date du message</th>
        </tr>
    </tfoot>
</table>

<?php
    }else{
        echo "<h3>Aucun message ne correspond à votre recherche.</h3>";
    }
}else{
    header('Location: ./?ctrl=home&method=index');
}