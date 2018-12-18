<?php

namespace core;

require_once 'View.php';
require_once 'Model.php';
require_once 'Db.php';

class Controller
{
    public $view;

    public function __construct()
    {

    }

    public function display($tpl = "", $value_arr = [])
    {
        $value_arr['PUBLIC'] = '/';
        $this->view = new View($tpl, $value_arr);
        echo $this->view->render();
        exit();
    }


}