<?php
use App\Session;
$nomCat = $result['data'];
foreach ($data['categorie'] as $categorie){
    echo "<h3><a href='./?ctrl=forum&method=allTopicsCategorie&id=".$_GET['id']."'>".$categorie->getNomcategorie()."</a></h3>";
}

?>

<p uk-margin>
    <?php if (Session::hasUser()){ ?>
    <a href="./?ctrl=forum&method=createTopicForm&id=<?=$_GET['id'];?>"><button class="uk-button uk-button-secondary">Créer un topic</button></a>
    <?php } ?>
</p>
<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>Nom des sujets</th>
            <th>Auteur</th>
            <th>Nombre de messages</th>
            <th>Date de création</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

<?php

$data = $result['data'];
foreach ($data['topics'] as $resul){
    $user = $resul->getUtilisateur();
    $cat = $resul->getCategorie();
    echo "<tr";
    if ($resul->getResoluSujet()){
        echo " class='greenBackground'";
    }
    echo "><td>";
    if ($resul->getStatutsujet()){
        echo "<span uk-icon='lock'></span>";
    }
    echo "<a href='./?ctrl=forum&method=show&id=".$resul->getId()."'>".$resul->getTitreSujet()."</a></td>";
    echo "<td><a href='./?ctrl=user&method=profil&id=".$user->getId()."'>".$user->getPseudonyme()."</a></td>";
    echo "<td><span uk-icon='icon: comments'></span>".$resul->getNbMessages2()."</td>";
    echo "<td>".$resul->getDatesujet()."</td>";

    if (!$resul->getStatutsujet()){
        if (Session::hasUser()){
            if (Session::getUser()->getId() === $user->getId() || Session::hasRole('ROLE_ADMIN')){
                echo "<td><a class='uk-button uk-button-danger' href='./?ctrl=forum&method=deleteTopic&id=".$resul->getId()."&idc=".$cat->getId()."'>Supprimer le topic</a></td>"; 
            }
        }
    }

    echo "</tr>";




    





    //echo "./?ctrl=forum&method=show&id=".$resul->getId()."'>".$resul->getTitreSujet()."</a> ".$user->getId()." ".$user->getPseudonyme()." à ".$resul->getDatesujet()."</br>";
}
?>
    </tbody>
    <tfoot>
        <tr>
            <th>Nom des sujets</th>
            <th>Auteur</th>
            <th>Nombre de messages</th>
            <th>Date de création</th>
            <th></th>
        </tr>
    </tfoot>
</table>