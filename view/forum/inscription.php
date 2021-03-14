<?php
setcookie("pseudo", null);
?>
<h2>Inscription</h2>

<form action="./?ctrl=security&method=inscriptionOK" method="post">
    <fieldset class="uk-fieldset">

        <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="Pseudonyme, 4 caractères minimum" name="pseudo" minlength=4 maxlength=32 required>
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="mail" placeholder="E-mail" name="mail" required>
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="password" placeholder="Votre mot de passe, 6 caractères minimum" name="password1" minlength=6 maxlength=48 required>
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="password" placeholder="Répétez votre mot de passe" name="password2" required>
        </div>


        <button class="uk-button uk-button-secondary">S'inscrire</button>

    </fieldset>
</form>