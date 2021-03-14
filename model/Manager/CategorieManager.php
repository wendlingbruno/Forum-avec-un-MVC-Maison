<?php
    namespace Model\Manager;
    
    use App\AbstractManager;
    
    class CategorieManager extends AbstractManager
    {
        private static $classname = "Model\Entity\Categorie";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function findAll(){

            $sql = "SELECT c.id, nomcategorie, COUNT(titresujet) AS Nbsujets
            FROM categorie c
            LEFT JOIN sujet s ON c.id = s.categorie_id
            GROUP BY c.id";

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
                        FROM categorie 
                        WHERE id = :id";
            return self::getOneOrNullResult(
                self::select($sql, 
                    ["id" => $id], 
                    false
                ), 
                self::$classname
            );
        }

        public function createCategorie($post){

            $sql = "INSERT INTO categorie(nomcategorie) 
            VALUES (:nomcategorie)";

            $nomCat = filter_var ($post["titre_categorie"], FILTER_SANITIZE_STRING);

                self::create($sql, 
                    ["nomcategorie" => $nomCat],
                    true
                );
        }


        /*SELECT COUNT(*) AS nbtopics
            FROM sujet s, categorie c
            WHERE s.categorie_id = c.ID
            AND c.ID = 1*/

    }