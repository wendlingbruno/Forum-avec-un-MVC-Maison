

<form action="./?ctrl=forum&method=createPost&id=<?=$_GET['id']?>" method="post">
    <fieldset class="uk-fieldset">
    <?php
    $nomCat = $result['data'];
    foreach ($data['topics'] as $categorie){
    $topic = $categorie->getSujet();
        echo "<legend class='uk-legend'>Poster un message dans <a href='./?ctrl=forum&method=show&id=".$_GET['id']."'>".$topic->getTitresujet()."</a></legend>";
    }

    ?>

        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Message" name="message_topic" required></textarea>
        </div>
        <button class="uk-button uk-button-secondary">Poster le message</button>

    </fieldset>
</form>