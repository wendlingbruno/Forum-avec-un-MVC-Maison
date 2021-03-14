<h2>CATEGORIES</h2>
<?php
use App\Session;

$data = $result['data'];

if (Session::hasUser()){
    if (Session::hasRole('ROLE_ADMIN')){ ?>
        <a href="./?ctrl=forum&method=createCategorieForm"><button class="uk-button uk-button-secondary">Créer une catégorie</button></a>
        <?php

    }
}
?>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>Categorie</th>
            <th>Nb Topics</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data['categories'] as $resul){
        echo "<tr><td><a href='./?ctrl=forum&method=allTopicsCategorie&id=".$resul->getId()."'>".$resul->getNomcategorie()."</td>";
        echo "<td><span uk-icon='icon: comment'></span>".$resul->getNbsujets()."</td>";
        
        ?>
        <td><a class="uk-button uk-button-danger" href="https://www.youtube.com/watch?v=GDVUmMMl5Ns">Supprimer catégorie</a></td>
        <?php
        //var_dump($resul);
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Categorie</th>
            <th>Nb Topics</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>