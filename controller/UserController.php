<?php
    namespace Controller;
    
    use App\Session;
    use App\Router;
    use Model\Manager\SujetManager;
    use Model\Manager\PostManager;
    use Model\Manager\CategorieManager;
    use Model\Manager\MessageManager;
    use Model\Manager\UtilisateurManager;

    class UserController {
        public function profil(){    
            if (Session::hasUser()){
                $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT);  
                $manUser = new UtilisateurManager;
                $user = $manUser->findOneById($id);
                if ($user){
                    return [
                        "view" => "forum/profil.php",
                        "data" => [
                            "user" => $user
                        ],
                        "titrePage" => "FORUM | Profil"
                    ];
                }else{
                    Session::addMessage('error', 'Ce profil n\'existe pas.');
                    Router::redirectTo();
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour regarder un profil.');
                Router::redirectTo();
            }
        }

    }