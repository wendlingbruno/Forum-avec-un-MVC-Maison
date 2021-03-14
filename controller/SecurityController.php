<?php
    namespace Controller;
    
    use App\Session;
    use App\Router;
    use Model\Manager\SujetManager;
    use Model\Manager\PostManager;
    use Model\Manager\CategorieManager;
    use Model\Manager\MessageManager;
    use Model\Manager\UtilisateurManager;

    class SecurityController {
        public function inscription(){     
            if (!Session::hasUser()){       
            return [
                "view" => "forum/inscription.php",
                "titrePage" => "FORUM | Inscription"
            ];
        }else{
            Session::addMessage('error', 'Vous êtes déjà connecté, et donc inscrit.');
            Router::redirectTo();
        }
        }

        public function connexion(){   
            if (!Session::hasUser()){    
                Router::redirectTo();     
            return [
                "view" => "forum/connexion.php",
                "titrePage" => "FORUM | Connexion"
            ];
        }else{
            Session::addMessage('error', 'Vous êtes déjà connecté.');
            Router::redirectTo();
        }
        }

        public function inscriptionOK(){
            if (!Session::hasUser()){   
                $searchPost = new UtilisateurManager();
                $searchPost2 = $searchPost->register($_POST);

                Router::redirectTo();
                return [
                    "view" => "forum/inscription.php",
                    "titrePage" => "FORUM | Inscription"
                ];
            }else{
                Session::addMessage('error', 'Vous êtes déjà connecté, et donc inscrit.');
                Router::redirectTo();
            }
        }

        public function connexionOK(){      
            if (!Session::hasUser()){      
                $connexion = new UtilisateurManager();
                $connexion2 = $connexion->connexion($_POST);

                Router::redirectTo();
                return [
                    "view" => "forum/home.php",
                    "titrePage" => "FORUM | Accueil"
                ];
            }else{
                Session::addMessage('error', 'Vous êtes déjà connecté.');
                Router::redirectTo();
            }
        }

        public function changerMDP(){            
            return [
                "view" => "forum/changermotdepasse.php",
                "titrePage" => "FORUM | Changer son mot de passe"
            ];
        }

        public function changerMDPOK(){ 
            $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT);
            if (Session::getUser()->getId() === $id){           
                $changermdp = new UtilisateurManager();
                $changermdp2 = $changermdp->changerMDP($_POST);

                
                return [
                    "view" => "forum/home.php",
                    "titrePage" => "FORUM | Accueil"
                ];
            }else{
                Router::redirectTo();
            }
        }

        public function deconnexion(){    
            if (Session::hasUser()){        
                Session::removeUser();

                Session::addMessage('success', 'Vous allez nous manquer. Revenez bientôt pour encore plus de lulz.');
                Router::redirectTo();
                return [
                    "view" => "forum/home.php",
                    "titrePage" => "FORUM | Accueil"
                ];
            }else{
                Session::addMessage('error', 'Essaierais-tu de deconnecter ton ordinateur ?');
                Router::redirectTo();
            }
        }
    }