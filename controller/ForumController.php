<?php
    namespace Controller;
    
    use App\Session;
    use App\Router;
    use Model\Manager\SujetManager;
    use Model\Manager\PostManager;
    use Model\Manager\CategorieManager;
    use Model\Manager\MessageManager;
    use Model\Manager\UtilisateurManager;
    // retirer les super globales de tous les controllers

    class ForumController {

        public function index(){
            Router::redirectTo("home","index");
        }

        /**
         * Afficher tous les topics
         */
        public function allTopics(){

            $manTopic = new SujetManager();
            $topics = $manTopic->findAll();
            //Session::addValueTo('ok', 'ok');
          
            return [
                "view" => "forum/listTopics.php", 
                "data" => [
                    "topics" => $topics
                ],
                "titrePage" => "FORUM | Sujets"
            ];
        }

        public function allCategories(){

            $manCategorie = new CategorieManager();
            $Categories = $manCategorie->findAll();
          
            return [
                "view" => "forum/listCategories.php", 
                "data" => [
                    "categories" => $Categories
                ],
                "titrePage" => "FORUM | Categories"
            ];
        }

        public function allTopicsCategorie(){
            $id = (isset($_GET['id'])) ? $_GET['id'] : null;
            $manTopic = new SujetManager();
            $topics = $manTopic->findAllByCategorie($id);
            $manCategorie = new SujetManager();
            $categorie = $manCategorie->findCategorieName($id);
          
            return [
                "view" => "forum/listTopicsCategorie.php", 
                "data" => [
                    "topics" => $topics,
                    "categorie" => $categorie
                ],
                "titrePage" => "FORUM | Sujets"
            ];
        }


        /**
         * Afficher les posts d'un topic
         */
        public function show($autreId = NULL, $retour = false){

            $id = (isset($_GET['id'])) ? $_GET['id'] : null;
            $manTopic = new SujetManager();
            $manPost = new MessageManager();

            if (!$retour){
            //$topic = $manTopic->findOneById($id);
            $posts = $manPost->findAllBySujet($id);
            }else{
                $posts = $manPost->findAllBySujet($autreId);
            }

            if ($posts){
            
            return [
                "view" => "forum/posts.php",
                "data" => [
                    "message" => $posts
                ],
                "titrePage" => "FORUM | Messages"
            ];
            }else Router::redirectTo();
        }

        public function createCategorieForm(){
            if (Session::hasUser()){         
                if (Session::hasRole('ROLE_ADMIN')){
                    return [
                        "view" => "forum/createCategorie.php", 

                        "titrePage" => "FORUM | Créer une catégorie"
                    ];
                }else{
                    Session::addMessage('error', 'Merci de vérifier vos autorisations.');
                    Router::redirectTo();
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour créer une catégorie.');
                Router::redirectTo(); 
            }
        }

        public function createCategorie(){
            if (Session::hasUser()){
                if (Session::hasRole('ROLE_ADMIN')){
                    $manCategorie2 = new CategorieManager();
                    $categories2 = $manCategorie2->createCategorie($_POST);

                    $manCategorie = new CategorieManager();
                    $Categories = $manCategorie->findAll();
                
                    return [
                        "view" => "forum/listCategories.php", 
                        "data" => [
                            "categories" => $Categories
                        ],
                        "titrePage" => "FORUM | Categories"
                    ];
                }else{
                    Session::addMessage('error', 'Merci de vérifier vos autorisations.');
                    Router::redirectTo();
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour créer une catégorie.');
                Router::redirectTo(); 
            }
        }


        public function createTopicForm(){
            if (Session::hasUser()){
                $id = (isset($_GET['id'])) ? $_GET['id'] : null;
                $manTopic = new SujetManager();
                $topics = $manTopic->createTopicForm($id);
            
                return [
                    "view" => "forum/createTopic.php", 
                    "data" => [
                        "topics" => $topics
                    ],
                    "titrePage" => "FORUM | Créer un sujet"
                ];
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour créer un topic.');
                Router::redirectTo(); 
            }
        }

        

        public function createTopic(){
            if (Session::hasUser()){
                $id = (isset($_GET['id'])) ? $_GET['id'] : null;
                $titre = (isset($_POST['titre_topic'])) ? $_POST['titre_topic'] : null;
                $message = (isset($_POST['message_topic'])) ? $_POST['message_topic'] : null;
                if ($titre != NULL && $message =! NULL){
                    $createTopic = new SujetManager();
                    $newTopic = $createTopic->createTopic($id, $titre, $message);
                    $message = (isset($_POST['message_topic'])) ? $_POST['message_topic'] : null;
                    $createMessage = new MessageManager();
                    $newMessage = $createMessage->createTopic2($newTopic, $titre, $message);

                    $manTopic = new SujetManager();
                    $topics = $manTopic->findAllByCategorie($id);
                    $manCategorie = new SujetManager();
                    $categorie = $manCategorie->findCategorieName($id);
                    Router::redirectTo('forum', 'show', $newTopic);
                    return [
                        "view" => "forum/listTopicsCategorie.php", 
                        "data" => [
                            "topics" => $topics,
                            "categorie" => $categorie
                        ],
                        "titrePage" => "FORUM | Sujets"
                    ];
                }else{
                    Session::addMessage('error', 'Merci de remplir les champs.');
                    Router::redirectTo(); 
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour créer un topic.');
                Router::redirectTo(); 
            }
        }


        /*public function createPostForm(){
            $id = (isset($_GET['id'])) ? $_GET['id'] : null;
            $manTopic = new MessageManager();
            $topics = $manTopic->createPostForm($id);
          
            return [
                "view" => "forum/createPost.php", 
                "data" => [
                    "topics" => $topics
                ],
                "titrePage" => "FORUM | Poster un message"
            ];
        }*/


        public function createPost(){
            if (Session::hasUser()){
                $id = (isset($_GET['id'])) ? $_GET['id'] : null;
                $message = (isset($_POST['message_topic'])) ? $_POST['message_topic'] : null;
                $message = filter_var ($message, FILTER_SANITIZE_STRING);
                if ($message){
                    $check = new SujetManager();
                    $checkLock = $check->findOneById($id);
                    if (!$checkLock->getStatutsujet()){
                        $createPost = new MessageManager();
                        $newTopic = $createPost->createPost($id, $message);    
                    }
                    $manTopic = new SujetManager();
                    $manPost = new MessageManager();

                    $posts = $manPost->findAllBySujet($id);

                    Router::redirectTo('forum', 'show', $id);
                    return [
                        "view" => "forum/posts.php",
                        "data" => [
                            "message" => $posts
                        ],
                        "titrePage" => "FORUM | Messages"
                    ];
                }else{
                    Session::addMessage('error', 'Merci de remplir les champs.');
                    Router::redirectTo(); 
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }
        }

        public function deleteTopic(){
            if (Session::hasUser()){
                $id = (isset($_GET['id'])) ? $_GET['id'] : null;
                $idc = (isset($_GET['idc'])) ? $_GET['idc'] : null;
                $manVerif = new SujetManager();
                $verif = $manVerif->findOneById($id);
                if (!$verif->getStatutsujet()){
                    if ($verif->getUtilisateur()->getId() === Session::getUser()->getId() || Session::hasRole('ROLE_ADMIN')){
                        $manMessage = new MessageManager();
                        $messages = $manMessage->deleteTopic($id);
                        $manTopic = new SujetManager();
                        $topics = $manTopic->deleteTopic($id, $idc);
                        $manTopic2 = new SujetManager();
                        $topics2 = $manTopic2->findAllByCategorie($id);
                        $manCategorie = new SujetManager();
                        $categorie = $manCategorie->findCategorieName($id);
                    }else{
                        Session::addMessage('error', 'Ce n\'est pas ton topic.');
                        Router::redirectTo();
                    }
                
                    return [
                        "view" => "forum/listTopicsCategorie.php", 
                        "data" => [
                            "topics" => $topics2,
                            "categorie" => $categorie
                        ],
                        "titrePage" => "FORUM | Sujets"
                    ];
                }else{
                    Session::addMessage('error', 'Ce topic est fermé.');
                    Router::redirectTo();
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }
        }

        
        public function deletePost(){
            if (Session::hasUser()){
                $id = (isset($_GET['id'])) ? $_GET['id'] : null;
                $idt = (isset($_GET['idt'])) ? $_GET['idt'] : null;
                $manVerif = new MessageManager();
                $verif = $manVerif->findOneById($id);
                if (!$verif->getSujet()->getStatutsujet()){
                    if ($verif->getUtilisateur()->getId() === Session::getUser()->getId() || Session::hasRole('ROLE_ADMIN')){
                        $deletePost = new MessageManager();
                        $newTopic = $deletePost->deletePost($id);
                        $manTopic = new SujetManager();
                        $manPost = new MessageManager();
                        $posts = $manPost->findAllBySujet($idt);
                    }else{
                        Session::addMessage('error', 'Ce n\'est pas ton message.');
                        Router::redirectTo();
                    }
                        Router::redirectTo('forum', 'show', $idt);
                        return [
                            "view" => "forum/posts.php",
                            "data" => [
                                "message" => $posts
                            ],
                            "titrePage" => "FORUM | Messages"
                        ];
                    }else{
                        Session::addMessage('error', 'Ce topic est fermé.');
                        Router::redirectTo();
                    }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }
        }

        public function searchMessage(){
            $searchPost = new MessageManager();
            $searchPost2 = $searchPost->searchPost($_POST);

            
            return [
                "view" => "forum/search.php",
                "data" => [
                    "message" => $searchPost2
                ],
                "titrePage" => "FORUM | Recherche"
            ];
        }


        public function advancedSearch(){      
            $manCategorie = new CategorieManager();
            $categories = $manCategorie->findAll();      
            return [
                "view" => "forum/advancedSearch.php",
                "data" => [
                    "categories" => $categories
                ],
                "titrePage" => "FORUM | Recherche avancée"
            ];
        }

        public function advancedSearch2(){
            $searchPost = new MessageManager();
            $searchPost2 = $searchPost->rechercheavancee($_POST);

            
            return [
                "view" => "forum/search.php",
                "data" => [
                    "message" => $searchPost2
                ],
                "titrePage" => "FORUM | Recherche"
            ];
        }

        public function listeMessagesUser(){

            $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT);
            $manPost = new MessageManager();
            $posts = $manPost->findAllMessagesUser($id);
            
            return [
                "view" => "forum/postsUser.php",
                "data" => [
                    "message" => $posts
                ],
                "titrePage" => "FORUM | Messages"
            ];
        }

        public function listeTopicsUser(){

            $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT); // changer
            $manTopic = new SujetManager();
            $topics = $manTopic->findAllTopicsUser($id);
            
            return [
                "view" => "forum/topicsUser.php",
                "data" => [
                    "topic" => $topics
                ],
                "titrePage" => "FORUM | Topics"
            ];
        }

        public function editMessage(){
            if (Session::hasUser()){
                $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT); // changer
                $manVerif = new MessageManager();
                $verif = $manVerif->findOneById($id);
                if (!$verif->getSujet()->getStatutsujet()){
                    if ($verif->getUtilisateur()->getId() === Session::getUser()->getId() || Session::hasRole('ROLE_ADMIN')){
                            $manPost = new MessageManager();
                            $message = $manPost->findOneById($id);
                        }else{
                            Session::addMessage('error', 'Ce n\'est pas ton message.');
                            Router::redirectTo();
                        }
                            return [
                                "view" => "forum/editMessage.php",
                                "data" => [
                                    "message" => $message
                                ],
                                "titrePage" => "FORUM | Editer un message"
                            ];
                }else{
                    Session::addMessage('error', 'Ce topic est fermé.');
                    Router::redirectTo();
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }
        }

        public function editMessageOk(){
            if (Session::hasUser()){
                $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT); // changer 
                $manVerif = new MessageManager();
                $verif = $manVerif->findOneById($id);
                if (!$verif->getSujet()->getStatutsujet()){
                    if ($verif->getUtilisateur()->getId() === Session::getUser()->getId() || Session::hasRole('ROLE_ADMIN')){
                        $message = (isset($_POST['message_topic'])) ? $_POST['message_topic'] : null;
                        $message = filter_var ($message, FILTER_SANITIZE_STRING);
                        if ($message){
                            $formPost = filter_var_array($_POST);
                            $manPost = new MessageManager();
                            $newId = $manPost->editMessage($id, $formPost);
                            Router::redirectTo('forum', 'show', $newId->getSujet()->getId(), true);
                            return $this->show($newId->getSujet()->getId(), true);
                        }else{
                            Session::addMessage('error', 'Merci de remplir les  champs');
                            Router::redirectTo();
                        }
                    }else{
                        Session::addMessage('error', 'Ce n\'est pas ton message.');
                        Router::redirectTo();
                    }
                }else{
                    Session::addMessage('error', 'Ce topic est fermé.');
                    Router::redirectTo();
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }
        }


        public function editTopic(){
            if (Session::hasUser()){
                $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT); // changer
                $manVerif = new MessageManager();
                $verif = $manVerif->findOneById($id);
                if (!$verif->getSujet()->getStatutsujet()){
                    if ($verif->getUtilisateur()->getId() === Session::getUser()->getId() || Session::hasRole('ROLE_ADMIN')){
                        $manTopic = new MessageManager();
                        $topic = $manTopic->findOneById($id);
                        return [
                            "view" => "forum/editTopic.php",
                            "data" => [
                                "topic" => $topic
                            ],
                            "titrePage" => "FORUM | Editer un topic"
                        ];
                    }else{
                        Session::addMessage('error', 'Ce n\'est pas ton topic.');
                        Router::redirectTo();
                    }
                }else{
                    Session::addMessage('error', 'Ce topic est fermé.');
                    Router::redirectTo();
                }

            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }
        }

        public function editTopicOk(){
            if (Session::hasUser()){
                $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT); // changer 
                $manVerif = new MessageManager();
                $verif = $manVerif->findOneById($id);
                if (!$verif->getSujet()->getStatutsujet()){
                    if ($verif->getUtilisateur()->getId() === Session::getUser()->getId() || Session::hasRole('ROLE_ADMIN')){
                        $formPost = filter_var_array($_POST);
                        $titre = (isset($formPost['titre_topic'])) ? $formPost['titre_topic'] : null;
                        $message = (isset($formPost['message_topic'])) ? $formPost['message_topic'] : null;
                        if ($titre != NULL && $message =! NULL){
                            $manPost = new MessageManager();
                            $newId = $manPost->editTopic($id, $formPost);
                            Router::redirectTo('forum', 'show', $newId->getSujet()->getId(), true);
                            return $this->show($newId->getSujet()->getId(), true);
                        }else{
                            Session::addMessage('error', 'Merci de remplir les  champs');
                            Router::redirectTo();
                        }


                        }else{
                            Session::addMessage('error', 'Ce n\'est pas ton topic.');
                            Router::redirectTo();
                        }                    
                    }else{
                        Session::addMessage('error', 'Ce topic est fermé.');
                        Router::redirectTo();
                    }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }

        }

        public function lockTopic(){
            $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT);
            if (Session::hasUser()){
                $manVerif = new SujetManager();
                $verif = $manVerif->findOneById($id);
                if ($verif->getUtilisateur()->getId() === Session::getUser()->getId() || Session::hasRole('ROLE_ADMIN')){
                    $manTopic = new SujetManager();
                    $topic = $manTopic->lockTopic($id);
                    Router::redirectTo('forum', 'show', $id);
                }else{
                    Session::addMessage('error', 'Ce n\'est pas ton topic.');
                    Router::redirectTo();
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }
        }

        
        public function resolveTopic(){
            $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT); // changer 
            if (Session::hasUser()){
                $manVerif = new SujetManager();
                $verif = $manVerif->findOneById($id);
                if (!$verif->getStatutsujet()){
                    if ($verif->getUtilisateur()->getId() === Session::getUser()->getId() || Session::hasRole('ROLE_ADMIN')){
                        $manTopic = new SujetManager();
                        $topic = $manTopic->resolveTopic($id);
                        Router::redirectTo('forum', 'show', $id);
                    }else{
                        Session::addMessage('error', 'Ce n\'est pas ton topic.');
                        Router::redirectTo();
                    }
                }else{
                    Session::addMessage('error', 'Ce topic est fermé.');
                    Router::redirectTo();
                }
            }else{
                Session::addMessage('error', 'Merci de vous connecter pour effectuer cette action.');
                Router::redirectTo();
            }
        }






        /*public function show(){

            $id = (isset($_GET['id'])) ? $_GET['id'] : null;
            $manTopic = new SujetManager();
            $manPost = new MessageManager();

            $topic = $manTopic->findOneById($id);
            $posts = $manPost->findByTopic($id);
            
            return [
                "view" => "forum/posts.php",
                "data" => [
                    "topic" => $topic,
                    "posts" => $posts,
                ],
                "titrePage" => "FORUM | ".$topic
            ];
        }*/
    }