

<form action="./?ctrl=forum&method=createTopic&id=<?=$_GET['id']?>" method="post">
    <fieldset class="uk-fieldset">
    <?php
    $nomCat = $result['data'];
    foreach ($data['topics'] as $categorie){
        echo "<legend class='uk-legend'>Créer un topic dans <a href='./?ctrl=forum&method=allTopicsCategorie&id=".$_GET['id']."'>".$categorie->getNomcategorie()."</a></legend>";
    }

    ?>
        

        <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="Titre du topic" name="titre_topic" required>
        </div>


        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Message" name="message_topic" required></textarea>
        </div>
        <button class="uk-button uk-button-secondary">Créer le topic</button>

    </fieldset>
</form>