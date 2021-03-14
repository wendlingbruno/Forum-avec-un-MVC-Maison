
<?php
    use App\Session;
    use App\Router;
    if (Session::hasUser()){
        if (SESSION::getUser()->getId() === $_GET['id']){?>
            <h2>Changer votre mot de passe</h2>

            <form action="./?ctrl=security&method=changermdpOK&id=<?= $_GET['id'];?>" method="post">
                <fieldset class="uk-fieldset">
                    <div class="uk-margin">
                        <input class="uk-input" type="password" placeholder="Ancien  mot de passe" name="passwordOld" minlength=6 maxlength=48 required>
                    </div>
                    <div class="uk-margin">
                        <input class="uk-input" type="password" placeholder="Nouveau mot de passe, 6 caractères minimum" name="password1" minlength=6 maxlength=48 required>
                    </div>
                    <div class="uk-margin">
                        <input class="uk-input" type="password" placeholder="Répétez votre nouveau mot de passe" name="password2" required>
                    </div>


                    <button class="uk-button uk-button-secondary">Changer le mot de passe</button>

                </fieldset>
            </form>
<?php
        }else{
            Router::redirectTo(); 
        }
    }else{
        Router::redirectTo();
    }