<?php
    namespace Model\Manager;
    
    use App\AbstractManager;
    use App\Session;
    
    class SujetManager extends AbstractManager
    {
        private static $classname = "Model\Entity\Sujet";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function findAll(){

            $sql = "SELECT s.id, titresujet, s.datesujet, statutsujet, resolusujet, s.utilisateur_id, s.categorie_id
                    FROM sujet s
                    ORDER BY datesujet DESC";

            return self::getResults(
                self::select($sql,
                    null, 
                    true
                ), 
                self::$classname
            );
        }

        public function findOneById($id){
            $sql = "SELECT * 
                        FROM sujet 
                        WHERE id = :id";
            return self::getOneOrNullResult(
                self::select($sql, 
                    ["id" => $id], 
                    false
                ), 
                self::$classname
            );
        }

        public function findAllByCategorie($id){

            $sql = "SELECT s.id, titresujet, s.datesujet, statutsujet, resolusujet, s.utilisateur_id, s.categorie_id, COUNT(m.id) AS nbMessages2
            FROM sujet s, categorie c, message m
            WHERE s.categorie_id = c.ID
            AND c.ID = :id
            AND m.SUJET_ID = s.id
            GROUP BY s.id
            ORDER BY datesujet DESC";

            return self::getResults(
                self::select($sql, 
                    ["id" => $id], 
                    true
                ),  
                self::$classname
            );
        }

        public function findCategorieName($id){

            $sql = "SELECT id, nomcategorie
            FROM categorie c
            WHERE c.ID = :id";

            return self::getResults(
                self::select($sql, 
                    ["id" => $id], 
                    true
                ),  
                self::$classname
            );
        }

        public function createTopicForm($id){

            $sql = "SELECT id, nomcategorie
            FROM categorie c
            WHERE c.ID = :id";

            return self::getResults(
                self::select($sql, 
                    ["id" => $id], 
                    true
                ),  
                self::$classname
            );
        }

        public function createTopic($id, $titre, $message){

            $sql = "INSERT INTO sujet(categorie_id, titresujet, utilisateur_id) 
            VALUES (:id, :titresujet, :utilisateur)";

            $message = filter_var ($message, FILTER_SANITIZE_STRING);
            $titre = filter_var ($titre, FILTER_SANITIZE_STRING);
            $utilisateur = Session::getUser()->getId();

                self::create($sql, 
                    ["id" => $id,
                    "titresujet" => $titre,
                    "utilisateur" => $utilisateur],
                    true
                );
            return $last = self::getLastInsertId(); // récupère le last insert id
        }

        public function deleteTopic($id, $idc){

            $sql = "DELETE FROM sujet
            WHERE id = :id";
            

                self::delete($sql, 
                    ["id" => $id],
                    true
                );
                header("Location: index.php?ctrl=forum&method=allTopicsCategorie&id=".$idc);
        }


        public function findAllTopicsUser($id){

            $sql = "SELECT id, titresujet, datesujet, statutsujet, resolusujet, utilisateur_id, categorie_id
            FROM sujet
            WHERE utilisateur_id = :id
            ORDER BY datesujet DESC";
                return self::getResults(
                    self::select($sql, 
                        ["id" => $id], 
                        true
                    ),  
                    self::$classname
                );

        }

        public function lockTopic($id){
            $sql = "SELECT statutsujet
            FROM sujet
            WHERE id = :id";
                $statut = self::getOneOrNullResult(
                    self::select($sql, 
                        ["id" => $id], 
                        false
                    ), 
                    self::$classname
                );
                
                if ($statut->getStatutSujet()){
                    $lock = 0;
                }else{
                    $lock = 1;
                }

            $sql2 = "UPDATE sujet
            SET statutsujet = :statut
            WHERE id = :id";
            self::update($sql2, 
                ["id" => $id,
                 "statut" => $lock],
                true
            );
                

        }

        public function resolveTopic($id){
            $sql = "SELECT resolusujet
            FROM sujet
            WHERE id = :id";
                $statut = self::getOneOrNullResult(
                    self::select($sql, 
                        ["id" => $id], 
                        false
                    ), 
                    self::$classname
                );
                
                if ($statut->getResoluSujet()){
                    $resolu = 0;
                }else{
                    $resolu = 1;
                }

            $sql2 = "UPDATE sujet
            SET resolusujet = :statut
            WHERE id = :id";
            self::update($sql2, 
                ["id" => $id,
                 "statut" => $resolu],
                true
            );
                

        }

        }

        
