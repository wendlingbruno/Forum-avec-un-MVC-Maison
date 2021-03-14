<?php
    namespace Model\Manager;
    
    use App\AbstractManager;
    use App\Session;
    use App\Router;
    
    class MessageManager extends AbstractManager
    {
        private static $classname = "Model\Entity\Message";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function findAll(){

            $sql = "SELECT DISTINCT(s.id), textemessage, datemessage, dateeditionmessage, m.utilisateur_id, m.sujet_id
            FROM sujet s, categorie c, message m
            WHERE m.SUJET_ID = s.id";

            return self::getResults(
                self::select($sql,
                    null, 
                    true
                ), 
                self::$classname
            );
        }

        public function findOneById($id){
            $sql = "SELECT m.id, textemessage, datemessage, utilisateur_id, sujet_id
            FROM message m
            WHERE m.ID = :id";
            return self::getOneOrNullResult(
                self::select($sql, 
                    ["id" => $id], 
                    false
                ), 
                self::$classname
            );
        }

        public function findAllBySujet($id){

            $sql = "SELECT DISTINCT(m.id), textemessage, datemessage, dateeditionmessage, m.utilisateur_id, m.sujet_id
            FROM sujet s, message m, categorie c
            WHERE m.SUJET_ID = s.id
            AND c.ID = s.categorie_id
            AND s.id = :id";

            return self::getResults(
                self::select($sql, 
                    ["id" => $id], 
                    true
                ),  
                self::$classname
            );
        }

        public function createTopic2($last, $titre, $message){

            $message = filter_var ($message, FILTER_SANITIZE_STRING);
            $titre = filter_var ($titre, FILTER_SANITIZE_STRING);
            $utilisateur = Session::getUser()->getId();

            $sql2 = "INSERT INTO message(textemessage, utilisateur_id, sujet_id) 
            VALUES (:textemessage, :utilisateur, :sujet)";

                self::create($sql2, 
                    ["textemessage" => $message,
                    "sujet" => $last,
                    "utilisateur" => $utilisateur],
                    true
            );
        }

        public function createPostForm($id){

            $sql = "SELECT m.id, titresujet, sujet_id
            FROM sujet s, message m
            WHERE s.id = :id
            AND s.id = m.SUJET_ID";

            return self::getResults(
                self::select($sql, 
                    ["id" => $id], 
                    true
                ),  
                self::$classname
            );
        }

        public function createPost($id, $message){

            $sql = "INSERT INTO message(sujet_id, utilisateur_id, textemessage) 
            VALUES (:id, :utilisateur, :message)";
             $utilisateur = Session::getUser()->getId();

               return self::create($sql, 
                    ["id" => $id,
                    "utilisateur" => $utilisateur,
                    "message" => $message],
                    true
                );
        }

        
        public function deleteTopic($id){

            $sql = "DELETE FROM message
            WHERE sujet_id = :id";
            

                self::delete($sql, 
                    ["id" => $id],
                    true
                );
        }

        public function deletePost($id){

            $sql = "DELETE FROM message
            WHERE id = :id";
            

                self::delete($sql, 
                    ["id" => $id],
                    true
                );
        }

        public function searchPost($array){

            $sql = "SELECT id, textemessage, datemessage, utilisateur_id, sujet_id
            FROM message m
            WHERE textemessage LIKE :recherche
            ORDER BY datemessage DESC";
            $motRecherche = filter_var ($array["recherche"], FILTER_SANITIZE_STRING);
                return self::getResults(
                    self::select($sql, 
                        ["recherche" => '%'.$motRecherche.'%'], 
                        true
                    ),  
                    self::$classname
                );

        }
        public function rechercheavancee($array){

            $sql = "SELECT m.ID, textemessage, datemessage, m.utilisateur_id, m.sujet_id
            FROM message m, categorie c, sujet s
            WHERE textemessage LIKE :recherche
            AND m.SUJET_ID = s.id
            AND c.ID = s.categorie_id
            AND :daterecherche < datemessage
            AND c.ID = :categorieid
            ORDER BY datemessage DESC";
            $date2 = date_create($array["date_recherche"]);
            $dateY = date_format($date2, 'Y');
            $dateD = date_format($date2, 'm');
            $dateM = date_format($date2, 'd');
            if (checkdate($dateM,$dateD,$dateY)){
                if (isset($array["recherche"]) && isset($array["categorie_recherche"]) && isset($array["date_recherche"])){
                    $motRecherche = filter_var ($array["recherche"], FILTER_SANITIZE_STRING);
                    $categorie = filter_var ($array["categorie_recherche"], FILTER_SANITIZE_STRING);
                    $categorie = filter_var($categorie, FILTER_VALIDATE_INT); // vérifie bien que c'est un entier
                    $date = filter_var ($array["date_recherche"], FILTER_SANITIZE_STRING);
                    if ($categorie){
                        return self::getResults(
                            self::select($sql, 
                                ["recherche" => $motRecherche,
                                "categorieid" => $categorie,
                                "daterecherche" => $date], 
                                true
                            ),  
                            self::$classname
                        );
                    }
                }
            }else{
                header("Location: index.php");
                die();

            }
        }


        public function findAllMessagesUser($id){

            $sql = "SELECT id, textemessage, datemessage, utilisateur_id, sujet_id
            FROM message
            WHERE utilisateur_id = :id
            ORDER BY datemessage DESC";
                return self::getResults(
                    self::select($sql, 
                        ["id" => $id], 
                        true
                    ),  
                    self::$classname
                );

        }

        public function editMessage($id, $array){
            $date = ((new \DateTime())->format('Y-m-d H:i:s'));
            var_dump($date);
            $sql = "UPDATE message
            SET textemessage = :message, dateeditionmessage = NOW()
            WHERE id = :id";
            self::update($sql, 
                ["id" => $id,
                "message" => $array['message_topic']],
                true
            );
            return $this->findOneById($id);

        }

        public function editTopic($id, $array){
            if ($array['message_topic'] != NULL){
            //message
            $date = ((new \DateTime())->format('Y-m-d H:i:s'));
            $sql = "UPDATE message
            SET textemessage = :message, dateeditionmessage = NOW()
            WHERE id = :id";
            self::update($sql, 
                ["id" => $id,
                "message" => $array['message_topic']],
                true
            );


            $sql2 = "SELECT sujet_id
            FROM message
            WHERE id = :id";
             $idTopic = self::getOneOrNullResult(
                self::select($sql2, 
                    ["id" => $id], 
                    false
                ), 
                self::$classname
            );

            // topic

            $sql3 = "UPDATE sujet
            SET titresujet = :sujet
            WHERE id = :id";
            self::update($sql3, 
                ["id" => $idTopic->getSujet()->getId(),
                "sujet" => $array['titre_topic']],
                true
            );

            return $this->findOneById($id);
        }else{
            Session::addMessage('error', 'Merci de remplir les  champs');
            Router::redirectTo();
        }

        }


    }