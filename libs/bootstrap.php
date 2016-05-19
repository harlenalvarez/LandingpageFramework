<?php
/**
 * User: harlenalvarez
 * Date: 11/6/15
 * Time: 9:28 PM
 */
class Bootstrap
{

    function __construct()
    {

        $url = array();
        if (isset($_GET['url']))
        {
            $url = $_GET['url'];
            $url = rtrim($url, '/');
            $url = explode('/', $url);
        } 
        else
        {
            $url[0] = "home";
        }
        $file = 'controllers/' . $url[0] . '.php';

        if (file_exists($file))
        {
            require_once($file);
        } 
        else
        {
            $url[0] = "error";
            $file = 'controllers/' . $url[0] . '.php';
            require_once($file);
        }



        if (count($url) > 2)
        {
            $args = array();

            for ($x = 2; $x < count($url); $x++)
            {
                if (!empty($url[$x]))
                {
                    $args[] = $url[$x];
                }
            }

            $controller = new $url[0]($args);

            if($url[0]!="index" && method_exists($controller,$url[1])){

                 $controller->$url[1]($args);

            }
            else
            {
                require_once('controllers/error.php');
                $controller = new Error();
                $controller->index();
            }
        } 
        elseif (count($url) == 2)
        {

            $controller = new $url[0]();

            if($url[0]!="index" && method_exists($controller,$url[1])){
                 $controller->$url[1]();
            }
            else
            {
                require_once('controllers/error.php');
                $controller = new Error();
                $controller->index();
            }
        } 
        else
        {
            if($url[0] == "favicon.ico"){
                
            }
            elseif (file_exists(ROOT . "controllers/home.php")){
                require_once("controllers/home.php");
                $controller = new Home();
                $controller->loadPage();
            }
            else
            {
                require_once('controllers/error.php');
                $controller = new Error();
                $controller->index();
            }
        }
    }

}
