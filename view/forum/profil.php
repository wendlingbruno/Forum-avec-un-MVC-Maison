<?php

use App\Session;
use App\Router;


$data = $result['data'];

$user = $data['user'];

$last = json_decode($user->getRole());
$lastRole = end($last);
$lastRole1 = explode('_', $lastRole);
$lastRoleOk = end($lastRole1);

?>



<div class="uk-card uk-card-default uk-width-1-2@m uk-margin-auto">
    <div class="uk-card-header">
        <div class="uk-grid-small uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
            <div class="uk-card-badge uk-label"><?= $lastRoleOk; ?></div>
                <h3 class="uk-card-title uk-margin-remove-bottom">Profil de <?= $user->getPseudonyme(); ?></h3>
                <p class="uk-text-meta uk-margin-remove-top"><time>Inscrit depuis le <?= $user->getdateInscriptionUtilisateur() ?> </time></p>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <a href='./?ctrl=forum&method=listeMessagesUser&id=<?= $user->getId(); ?>'>Voir tous les messages de <?= $user->getPseudonyme(); ?></a><br/>
        <a href='./?ctrl=forum&method=listeTopicsUser&id=<?= $user->getId(); ?>'>Voir tous les sujets de <?= $user->getPseudonyme(); ?> </a>
    </div>
    <?php if ($_GET['id'] === Session::getUser()->getId()){ // uniquement si c'est la même personne ?>
        <div class="uk-card-footer">
            <a href="./?ctrl=security&method=changermdp&id=<?= Session::getUser()->getId(); ?>" class="uk-button uk-button-text">Changer votre mot de passe</a>
        </div>
    <?php } ?>
</div>
    <?php 

