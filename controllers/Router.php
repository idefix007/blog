<?php


class Router
{

    private $ctl;
    private $view;

    public function req(){

        try {

            spl_autoload_register(function($class){
                require('models/'.$class.'.php');
            });

            
            $url = '';


            if (isset($_GET['url'])) {

                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));

                $controller = ucfirst(strtolower($url[0]));
                $controllerClass = "Controller".$controller;
                $controllerFile = "controllers/".$controllerClass.".php";

                if (file_exists($controllerFile)) {


                    require_once($controllerFile);
                    $this->ctrl = new $controllerClass($url);
                }
                else {
                    throw new \Exception("Page introuvable", 1);

                }
            }

             else{

                 require_once('controllers/ControllerAccueil.php');
                 $this->ctrl = new ControllerAccueil($url);
            }

        } catch (\Exception $e){

            $error= $e->getMessage();
            require_once('views/viewError.php');

        }
    }

}