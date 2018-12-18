<?php
namespace core;
//version
define('version','0.1');

class App{
    public function autoload($class)
    {
        $file = ROOT . 'model/' . $class . '.php';
        if (is_file($file)) {
            require_once($file);
        }
    }
    function __construct()
    {

    }

    public function run(){
        spl_autoload_register("core\\App::autoload");
        include_once('function.php');
        if(file_exists('../common/function.php')){
            include_once('../common/function.php');
        }
        $controller = '';
        if(isset($_GET['c'])){
            $controller = isset($_GET['c'])?$_GET['c']:'Index';
            $activity = isset($_GET['a'])?$_GET['a']:'index';
        }else{
            $get_string = explode('/',trim(key($_GET),'/'));
            if(count($get_string)>=2){
                $controller = $get_string[0];
                $activity = $get_string[1];
                for($i=2;$i<count($get_string);$i=$i+2){
                    $_GET[$get_string[$i]] = isset($get_string[$i+1])?$get_string[$i+1]:'';
                }
            }else{
                $controller = 'Index';
                $activity = 'index';
            }
        }

        $controller=ucfirst($controller);
        if(file_exists(ROOT.'controller/'.$controller.'.php')) {
            require_once ROOT . 'controller/' . $controller . '.php';
        }

        $controller_name = 'controller\\'.$controller;
        if(class_exists($controller_name) && method_exists($controller_name,$activity)){
            $object = new $controller_name();
            $object->$activity();
        }else{
            die('404');
        }
    }
}