<?php
    namespace App;

    abstract class Session {



        public static function addMessage($type, $text){
            if(!isset($_SESSION['msg'][$type])){
                $_SESSION["msg"][$type] = [];
            }
            
            $_SESSION['msg'][$type][] = $text;
        }

        public static function getValuesOf($index){
            return isset ($_SESSION[$index]) ? $_SESSION[$index] : false;
        }

        public static function hasMessages(){
            return isset($_SESSION["msg"]);
        }

        public static function getMessage($type){
            
            if(isset($_SESSION["msg"][$type])){
                $msgs = $_SESSION["msg"][$type];
                unset($_SESSION["msg"][$type]);
                return $msgs;
            }
            else return [];
            
        }

        public static function addUser($user){
            if(!isset($_SESSION['user'])){
                $_SESSION["user"] = [];
            }
            
            $_SESSION['user'] = $user;
        }



        public static function hasUser(){
            return isset($_SESSION["user"]);
        }

        public static function getUser(){
            
            if(isset($_SESSION["user"])){
                $infoUser = $_SESSION["user"];
                return $infoUser;
            }
            else return [];
            
        }

        public static function removeUser(){
            
            if(isset($_SESSION["user"])){
                unset($_SESSION["user"]);
            if(!isset($_SESSION['msg']['success'])){
                $msg = $_SESSION["msg"]['success'] = 'Bien déconnecté';
                unset($_SESSION["msg"]['success']);
                return $msg;
                }
            }
            else return []; // redirect ou message d'erreur ou les deux
            
        }

        public static function hasRole($nomRole){
            if(isset($_SESSION["user"])){
                //(json_decode(self::getUser()->getRole()));
                return (in_array($nomRole, (json_decode(self::getUser()->getRole()))));
            }
        }

        public static function getLastRoleSession(){
            if(isset($_SESSION["user"])){
                $last = json_decode(self::getUser()->getRole());
                return end($last);
            }
        }
    }