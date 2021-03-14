

<form action="./?ctrl=forum&method=editTopicOk&id=<?=$_GET['id']?>" method="post">
    <fieldset class="uk-fieldset">
    <?php
    $message = $result['data'];
    $user = $message['topic']->getUtilisateur();
    $sujet = $message['topic']->getSujet();
        echo "<legend class='uk-legend'>Editer le topic <a href='./?ctrl=forum&method=show&id=".$sujet->getId()."'>".$sujet->getTitreSujet()."</a></legend>";

    ?>
        

        <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="Titre du topic" name="titre_topic" value="<?= $sujet->getTitreSujet();?>">
        </div>


        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Message" name="message_topic"><?=$message['topic']->getTexteMessage();?></textarea>
        </div>
        <button class="uk-button uk-button-secondary">Editer le topic</button>

    </fieldset>
</form>