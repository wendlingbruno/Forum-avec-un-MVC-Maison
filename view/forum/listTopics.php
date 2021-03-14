<?php

/*foreach ([$topics] as $topic){
    echo $topic['titre'];
}*/

/*while($topic = 'topics'->fetch(PDO::FETCH_ASSOC)){
}*/

$data = $result['data'];
foreach ($data['topics'] as $resul){
    $user = $resul->getUtilisateur();
    $cat = $resul->getCategorie();
    echo $resul->getId()." ".$resul->getTitreSujet()." par ".$user->getId()." ".$user->getPseudonyme()." à ".$resul->getDatesujet()." dans ".$cat->getId()." ".$cat->getNomCategorie()."</br>";
}

/*while($resul = $data['topics']->fetch(PDO::FETCH_ASSOC)){
    echo $resul;
}*/
