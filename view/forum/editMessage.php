

<form action="./?ctrl=forum&method=editMessageOk&id=<?=$_GET['id']?>" method="post">
    <fieldset class="uk-fieldset">
    <?php
    $nomCat = $result['data'];
    $infoMessage = $data['message'];
    $topic = $infoMessage->getSujet();

    //$topic = $categorie->getSujet();
        echo "<legend class='uk-legend'>Editer un message dans <a href='./?ctrl=forum&method=show&id=".$topic->getId()."'>".$topic->getTitresujet()."</a></legend>";

    ?>

        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Message" name="message_topic"><?= $infoMessage->getTexteMessage(); ?></textarea>
        </div>
        <button class="uk-button uk-button-secondary">Modifier le message</button>

    </fieldset>
</form>