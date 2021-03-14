<?php
	namespace App;
	
	abstract class Autoloader {

		public static function register() {
			spl_autoload_register(array(__CLASS__, 'autoload'));
		}

		public static function autoload($class) {

			//$class = Model\Manager\TopicManager (FullyQualifiedClassName)
			//namespace = Model\Manager, nom de la classe = TopicManager

			// on explose notre variable $class par \
			$parts = preg_split('#\\\#', $class);
			//$parts = ['Model', 'Manager', 'TopicManager']

			// on extrait le dernier element 
			$className = array_pop($parts);
			//$className = TopicManager

			// on créé le chemin vers la classe
			// on utilise DS car plus propre et meilleure portabilité entre les différents systèmes (windows/linux) 

			//avant : ['Model', 'Manager']
			//après implode : "model\manager"
			$path = strtolower(implode(DS, $parts));
			
			$file = $className.'.php';
			//$file = TopicManager.php

			$filepath = ROOT_DIR.$path.DS.$file;
			//$filepath = ./model/manager/TopicManager.php
			if(file_exists($filepath)){
				// require "./model/manager/TopicManager.php"
				require $filepath;
			}
		}
	}
