<?php

use App\Session;

foreach ($data['message'] as $resul){
    $topic = $resul->getSujet();
    //$idcat = $resul->getNomcategorie();
    $cat = $topic->getCategorie();
}
echo "<h2><a href='./?ctrl=forum&method=allTopicsCategorie&id=".$cat->getId()."'>".$cat->getNomcategorie()."</a></h2>";
echo "<h2>";
if ($topic->getResoluSujet()){
    echo "<span uk-icon='check'></span>";
}
echo $topic->getTitresujet()."</h2>";

?>
<p uk-margin>
<?php 
    if (Session::hasUser()){
        if (Session::getUser()->getId() === $topic->getUtilisateur()->getId() || Session::hasRole('ROLE_ADMIN')){
            if ($topic->getStatutsujet()){ 
                echo "<h3>Ce topic est fermé</h3>";
            }

            if (!$topic->getStatutsujet()){ ?>
                
                <a href="./?ctrl=forum&method=lockTopic&id=<?=$_GET['id'];?>"><button class="uk-button uk-button-secondary">Fermer le topic</button></a>
                <?php
                }else{?>
                    <a href="./?ctrl=forum&method=lockTopic&id=<?=$_GET['id'];?>"><button class="uk-button uk-button-secondary">Réouvrir le topic</button></a>
                    <?php
                }
            if (!$topic->getStatutsujet()){
                if (!$topic->getResolusujet()){ ?>
                        
                    <a href="./?ctrl=forum&method=resolveTopic&id=<?=$_GET['id'];?>"><button class="uk-button uk-button-secondary">Changer en résolu</button></a>
                        
                    <?php
                }else{?>
                    <a href="./?ctrl=forum&method=resolveTopic&id=<?=$_GET['id'];?>"><button class="uk-button uk-button-secondary">Ne plus être résolu</button></a>
                    <?php
                }
            }
        }
    }

$nb = 0;

$data = $result['data'];
foreach ($data['message'] as $resul){
   $user = $resul->getUtilisateur();
    $last = json_decode($user->getRole());
    $lastRole = end($last);
    $lastRole1 = explode('_', $lastRole);
    $lastRoleOk = end($lastRole1);

    ?> 
    </p>

<article class="uk-comment uk-comment-primary">
    <header class="uk-comment-header">
        <div class="uk-grid-medium uk-flex-middle" uk-grid>

            <div class="uk-width-expand">

                <?= "<p><td><a href='./?ctrl=user&method=profil&id=".$user->getId()."'>".$user->getPseudonyme()."</a> (".$lastRoleOk.")</td></p>";?>

                <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                    <li><?= $resul->getDatemessage(); ?></li>
                    <?php if ($nb == 0){
                        if (!$topic->getStatutsujet()){
                            if (Session::hasUser()){
                                if (Session::getUser()->getId() === $user->getId() || Session::hasRole('ROLE_ADMIN')){
                                    echo "<li><a class='uk-button uk-button-secondary textWhite' href='./?ctrl=forum&method=editTopic&id=".$resul->getId()."'>Editer le topic</a></li>";
                                }
                            }
                            if (Session::hasUser()){
                                if (Session::getUser()->getId() === $user->getId() || Session::hasRole('ROLE_ADMIN')){
                                    echo "<li><a class='uk-button uk-button-danger textWhite' href='./?ctrl=forum&method=deleteTopic&id=".$topic->getId()."&idc=".$cat->getId()."'>Supprimer le topic</a></li>";
                                }
                            }
                        }
                     $nb++;
                    }else{ 
                        if (!$topic->getStatutsujet()){
                            if (Session::hasUser()){
                                if (Session::getUser()->getId() === $user->getId() || Session::hasRole('ROLE_ADMIN')){
                                    echo "<li><a class='uk-button uk-button-secondary textWhite' href='./?ctrl=forum&method=editMessage&id=".$resul->getId()."'>Editer le message</a></li>";
                                }
                            }
                            if (Session::hasUser()){
                                if (Session::getUser()->getId() === $user->getId() || Session::hasRole('ROLE_ADMIN')){
                                    echo "<li><a class='uk-button uk-button-danger textWhite' href='./?ctrl=forum&method=deletePost&id=".$resul->getId()."&idt=".$topic->getId()."'>Supprimer le message</a></li>";
                                }
                            }
                        }
                    }
                    ?>
                </ul>
                <?php if ($resul->getDateEditionMessage() != NULL){?>
                <p class="uk-comment-meta">Dernière édition le <?= $resul->getDateEditionMessage(); ?></p>
                <?php }?>
            </div>
        </div>
    </header>
    <div class="uk-comment-body">
        <p><?= $resul->getTextemessage(); ?></p>
    </div>
</article>
<hr>



    
<?php

    }
    if (Session::hasUser()){
        if (!$topic->getStatutsujet()){ ?>
        <h3>Réponse rapide</h3>
        <form action="./?ctrl=forum&method=createPost&id=<?=$_GET['id']?>" method="post">
        <fieldset class="uk-fieldset">
        <?php
        $nomCat = $result['data'];

        ?>

            <div class="uk-margin">
                <textarea class="uk-textarea" rows="5" placeholder="Message" name="message_topic"></textarea>
            </div>
            <button class="uk-button uk-button-secondary">Poster le message</button>

        </fieldset>
    </form>
    <?php  }
    }