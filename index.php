<?php
    namespace App;
    
    use App\Router;

    require_once "app\Autoloader.php";
    Autoloader::register();
  

    /* ------------------ CONSTANTES ------------------ */
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT_DIR', '.'.DS); // "./"
    define('PUBLIC_PATH', ROOT_DIR.'public'.DS); // "./public/"
    define('CSS_PATH', PUBLIC_PATH.'css'.DS); // "./public/css/"
    define('IMG_PATH', PUBLIC_PATH.'img'.DS); // "./public/img/"
    define('JS_PATH', PUBLIC_PATH.'js'.DS); // "./public/js/"

    define('SERVICE_PATH', ROOT_DIR.'app'.DS); // "./app/"
    define('CTRL_PATH', ROOT_DIR.'controller'.DS); // "./controller/"
    define('VIEW_PATH', ROOT_DIR.'view'.DS); // "./view/"

    define('ADMIN_MAIL', "admin@forummvc.com"); //mail de l'administrateur

    require SERVICE_PATH."Router.php"; // require "./app/Router.php"
    session_start();

    /* ------------------ TEMPORISATION DE SORTIE ------------------ */
    \ob_start();
    
    $result = Router::handleRequest($_GET);
    
    if (isset($_GET['ajax'])){
        echo json_encode($result['data']);
    }else{
        if(is_array($result) && array_key_exists('view', $result)){
            $data = isset($result['data']) ? $result['data'] : null;
            include VIEW_PATH.$result['view'];
            $titrePage = isset($result['titrePage']) ? $result['titrePage'] : null;
        }

        $page = ob_get_contents();
        \ob_end_clean();

        require VIEW_PATH."template.php"; // require "./view/layout.php"
    }

