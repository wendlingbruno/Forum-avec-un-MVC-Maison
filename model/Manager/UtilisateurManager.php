<?php
    namespace Model\Manager;
    
    use App\AbstractManager;
    use App\Session;
    // mettre tous les messages d'erreur dans Session


    class UtilisateurManager extends AbstractManager
    {
        private static $classname = "Model\Entity\Utilisateur";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function findAll(){

            $sql = "SELECT * FROM utilisateur";

            return self::getResults(
                self::select($sql,
                    null, 
                    true
                ), 
                self::$classname
            );
        }

        public function findOneById($id){
            $sql = "SELECT id, pseudonyme, emailutilisateur, dateinscriptionutilisateur, role
                    FROM utilisateur 
                    WHERE id = :id";
            return self::getOneOrNullResult(
                self::select($sql, 
                    ["id" => $id], 
                    false
                ), 
                self::$classname
            );
        }

        public function privateProfil($id){
            $sql = "SELECT id, pseudonyme, emailutilisateur, dateinscriptionutilisateur, role
            FROM utilisateur
            WHERE id = :id";
            return self::getOneOrNullResult(
                self::select($sql,
                ["id" => $id],
                false
            ),
            self::$classname
        );
        }

        public function register($array){

            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[a-zA-Z0-9]{4,32}/"]]);
            $mail = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password1", FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[a-zA-Z0-9!_-]{6,48}/"]
            ]);
            $password_repeat = filter_input(INPUT_POST, "password2", FILTER_DEFAULT);

            if ($pseudo && $mail && $password){
                if ($password === $password_repeat){
                    // VERIF SI PSEUDO EXISTE
                    $sqlVerifPseudo = "SELECT pseudonyme FROM utilisateur 
                    WHERE pseudonyme = :pseudo";
                    $verifPseudo = self::getOneOrNullResult(
                        self::select($sqlVerifPseudo, 
                            ["pseudo" => $pseudo], 
                            false
                        ), 
                        self::$classname
                    );

                    // VERIF SI MAIL EXISTE
                    $sqlVerifMail = "SELECT emailutilisateur FROM utilisateur 
                    WHERE emailutilisateur = :email";
                    $verifMail = self::getOneOrNullResult(
                        self::select($sqlVerifMail, 
                            ["email" => $mail], 
                            false
                        ), 
                        self::$classname
                    );


                    // VERIF FINALE
                    if ($verifPseudo || $verifMail){
                        Session::addMessage('error', 'Le pseudo ou l\'email est déjà utilisé.');
                    }else{
                        $sqlInscription = "INSERT INTO utilisateur(pseudonyme, mdputilisateur, emailutilisateur) 
                        VALUES (:pseudo, :mdp, :email)";
            
                            self::create($sqlInscription, 
                                ["pseudo" => $pseudo,
                                "mdp" => password_hash($password, PASSWORD_ARGON2I),
                                "email" => $mail],
                                true
                            );
                            Session::addMessage('success', 'Inscription réussie !');
                    }
                }else{
                    Session::addMessage('error', 'Les mots de passes ne correspondent pas');
                }
            }else{
                Session::addMessage('error', 'Une erreur est survenue.');
            }
                
            

                /*self::create($sql, 
                    ["id" => $id,
                    "utilisateur" => 1,
                    "message" => $message],
                    true
                );*/
            }


            public function connexion($array){

                $mail = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL);
                $password = filter_input(INPUT_POST, "password1", FILTER_DEFAULT);
                $remember = filter_input(INPUT_POST, "remember", FILTER_VALIDATE_BOOLEAN);
    
                if ($mail && $password){
                        // VERIF SI MAIL EXISTE
                        $sqlVerifMail = "SELECT pseudonyme, emailutilisateur, mdputilisateur FROM utilisateur 
                        WHERE emailutilisateur = :email";
                        $verifMail = self::getOneOrNullResult(
                            self::select($sqlVerifMail, 
                                ["email" => $mail], 
                                false
                            ), 
                            self::$classname
                        );
    
    
                        // VERIF FINALE
                        if ($verifMail){                            
                            if (password_verify($password, $verifMail->getMdputilisateur())){// compare  le mdp envoyé et le hash


                                $sqlInfos = "SELECT id, pseudonyme, emailutilisateur, DATEINSCRIPTIONUTILISATEUR, role, banniutilisateur FROM utilisateur 
                                WHERE emailutilisateur = :email";
                                $infosUser = self::getOneOrNullResult(
                                    self::select($sqlInfos, 
                                        ["email" => $mail], 
                                        false
                                    ), 
                                    self::$classname
                                );



                                Session::addUser($infosUser);
                                Session::addMessage('success', 'Vous vous êtes bien connecté.');
                                //echo "Bienvenue ".$infosUser->getPseudonyme();
                                if (isset($remember)){
                                    if ($array['remember']){
                                        setcookie("pseudo", $verifMail->getPseudonyme(),time() + 60, null, null, false, true); // les null true etc permettent d'éviter des failles XSS avec JS (le dernier plus particulièrement avec true et httponly)
                                    }

                                }
                                /*if (Session::hasUser()){
                                    echo "test";
                                }else{
                                    echo "vide";
                                }*/
                            }else{
                                Session::addMessage('error', 'L\'email ou le mot de passe est invalide.');
                            }
                        }else{
                            Session::addMessage('error', 'L\'email ou le mot de passe est invalide.');
                        }
                    }else{
                        Session::addMessage('error', 'Une erreur est survenue.');
                    }
                }

                public function changerMDP($array){

                    $passwordOld = filter_input(INPUT_POST, "passwordOld", FILTER_DEFAULT);
                    $password1 = filter_input(INPUT_POST, "password1", FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[a-zA-Z0-9!_-]{6,48}/"]]);
                    $password2 = filter_input(INPUT_POST, "password2", FILTER_DEFAULT);
        
                    if ($passwordOld && $password1 && $password2){
                            // VERIF SI ID existe
                            $sqlVerifId = "SELECT id, pseudonyme, emailutilisateur, mdputilisateur FROM utilisateur 
                            WHERE id = :id";
                            $verifId = self::getOneOrNullResult(
                                self::select($sqlVerifId, 
                                    ["id" => Session::getUser()->getId()], 
                                    false
                                ), 
                                self::$classname
                            );
        
        
                            // VERIF FINALE
                            if ($verifId){                        
                                if (password_verify($passwordOld, $verifId->getMdputilisateur())){ // compare  le mdp envoyé et le hash
                                    if ($password1 === $password2){
                                        $sqlChangementMDP = "UPDATE utilisateur
                                        SET mdputilisateur = :mdp
                                        WHERE id = :id";                            
                                            self::update($sqlChangementMDP, 
                                                ["mdp" => password_hash($password1, PASSWORD_ARGON2I),
                                                "id" => Session::getUser()->getId()],
                                                true
                                            );
                                            Session::addMessage('success', "Mot de passe changé pour ".$verifId->getPseudonyme());
                                    }else{
                                        Session::addMessage('error', 'Les deux mots de passe ne sont pas identiques.');
                                    }
                                }else{
                                    Session::addMessage('error', 'L\'email ou le mot de passe est invalide.');
                                }
                            }else{
                                Session::addMessage('error', 'L\'email ou le mot de passe est invalide.');
                            }
                        }else{
                            Session::addMessage('error', 'Une erreur est survenue.');
                        }
                    }
                    


    }