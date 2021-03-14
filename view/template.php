<?php 
    use App\Session;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.4.6/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.4.6/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.4.6/dist/js/uikit-icons.min.js"></script>
    
    <link rel="stylesheet" href="./public/css/style.css">
    <title><?= $titrePage ?></title>
</head>
<body>
    <!-- ------------------ NAV ------------------ -->
    <nav class="uk-navbar-container uk-background-secondary uk-dark" uk-navbar="mode: click">
        <div class="uk-navbar-left">
            <ul class="uk-navbar-nav">
                <li><a href="?ctrl=home&method=index">&nbsp;<img src="./public/img/logo2.png" alt="Logo Elan" width="50"></a></li>
            </ul>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav">
            <li>
                <form class="uk-search uk-search-default uk-margin-top uk-background-default" action="./?ctrl=forum&method=searchMessage" method="post">
                    <span uk-search-icon></span>
                    <input class="uk-search-input" type="search" placeholder="Rechercher" name="recherche">
                </form>
                <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li>
                                <a href="?ctrl=forum&method=advancedSearch">Recherche avancée</a>
                            </li>
                        </ul>
                </div>
            </li>
                <li>
                    <?php

                    if (!Session::hasUser()){
                        ?>
                    <a href="./?ctrl=security&method=inscription"></span>&nbsp;S'inscrire</a>
                <?php
                    }else{
                        echo '<a href="./?ctrl=user&method=profil&id='.Session::getUser()->getId().'"><span uk-icon="icon: user"></span>&nbsp;'.Session::getUser()->getPseudonyme().'</a>';
                    }
                        ?></li>
                <!-- <li><a href="./?ctrl=security&method=changermdp"></span>&nbsp;Changer MDP (temporaire)</a></li> -->
                <!-- <li><a href="./?ctrl=user&method=profil"></span>&nbsp;Profil (visible temporairement sans connexion et ID)</a></li> -->
                <li>
                    <?php
                        if (Session::hasUser()){
                            ?>
                            <a href="./?ctrl=security&method=deconnexion"></span>&nbsp;Se déconnecter</a>
                            <?php
                        }else{
                            ?>
                            <a href="#">Connexion</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li>
                                <form action="./?ctrl=security&method=connexionOK" method="post">
                                    <fieldset class="uk-fieldset">
                                        <div class="uk-margin">
                                            <input class="uk-input" type="mail" placeholder="E-mail" name="mail">
                                        </div>
                                        <div class="uk-margin">
                                            <input class="uk-input" type="password" placeholder="Votre mot de passe" name="password1">
                                        </div>
                                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                            <label><input class="uk-checkbox" type="checkbox" name="remember"> Se souvenir de moi</label>
                                        </div>
                                        <button class="uk-button uk-button-secondary">Connexion</button>
                                    </fieldset>
                            <?php
                        }
                        ?>
                    
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- <li><a href="./?ctrl=forum&method=connexion"></span>&nbsp;Se connecter</a></li> -->
            </ul>
        </div>
    </nav>
    <?php 
        if (Session::hasMessages()){

            foreach (Session::getMessage('success') as $success){
                ?>

                <div class="uk-alert-success uk-text-center uk-width-1-5 uk-margin-auto" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>
                <?= $success; ?>
                </p>
            </div>
                <?php
            }

            foreach (Session::getMessage('error') as $erreur){
                ?>

                <div class="uk-alert-danger uk-text-center uk-width-1-5 uk-margin-auto" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>
                <?= $erreur; ?>
                </p>
            </div>
                <?php
            }
        }
    ?>



    <!-- ------------------ MAIN ------------------ -->
    <div id="wrapper" class="uk-container uk-container-expand">
        <div id="mainPage">
            <main>
                <h1>FORUM</h1><hr>
                <div id="page">
                    <?= $page ?>
                </div>
            </main>
        </div>
        <footer>
            <p>
                &copy;2020 - COPYRIGHT de l'enfer brûlant - <!-- <a href="#">Règlement du forum</a> - <a href="#">Mentions légales</a> -->
            </p>
        </footer>

    </div>
</body>
</html>