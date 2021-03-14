<?php
    namespace App;

    use Controller\HomeController;

    abstract class Router {

        public static function handleRequest($get){
            $ctrlname = "Controller\HomeController";
            $method = "index";

            // $get = "index.php?ctrl=forum&method=allTopics";
            // $get = "index.php?ctrl=forum&method=findTopic&id=3";
            
            if(isset($get['ctrl'])){
                // ctrl = forum
                // Controller\ForumController
                $ctrlname = "Controller\\".ucfirst($get['ctrl'])."Controller";
            }
            
            if(isset($get['method']) && class_exists($ctrlname)){
                // method = allTopics
                // $ctrl = new ForumController();
                $ctrl = new $ctrlname();
            } else $ctrl = new HomeController();

            if(isset($get['id'])){
                $id = $get['id'];
            } else $id = null;

            if(isset($get['method']) && method_exists($ctrl, $get['method'])){
                // $method = allTopics
                $method = $get['method'];
            }
            
            // ForumController->allTopics();
            // ForumController->findTopic($id)
            return $ctrl->$method($id);
        }

        public static function redirectTo($ctrl = null, $method = null, $id = null){
            header("Location:?ctrl=".$ctrl."&method=".$method."&id=".$id);
            die();
        }
    }