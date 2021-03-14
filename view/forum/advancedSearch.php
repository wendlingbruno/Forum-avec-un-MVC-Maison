<h2>Recherche avancée</h2>

<form action="./?ctrl=forum&method=advancedSearch2" method="post">
    <fieldset class="uk-fieldset">

        <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="Champ à rechercher" name="recherche" required>
        </div>
        <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-select">Rechercher jusqu'à quelle date</label>
            <input class="uk-input" type="date" placeholder="" name="date_recherche" required>
        </div>


        <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-select">Sélectionnez la catégorie</label>
        <div class="uk-form-controls">
        <select class="uk-select" id="form-stacked-select" name="categorie_recherche" required>
<?php

$categories = $result['data'];
foreach ($categories['categories'] as $value){
    echo "<option value='".$value->getId()."'> ".$value->getNomcategorie()."</option>";
}
?>
            </select>
        </div>
    </div>


        <button class="uk-button uk-button-secondary">Rechercher</button>

    </fieldset>
</form>