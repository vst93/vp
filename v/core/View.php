<?php
namespace core;
/**
 * Created by PhpStorm.
 * User: vv
 * Date: 2018/9/17
 * Time: 11:59
 */
class View extends \Text_Template
{

    public function __construct($tpl, $arr)
    {
        $file_path = ROOT . 'view/' . $tpl . '.html';
        try{
            parent::__construct($file_path);
        }catch (Exception $e){
            echo $e->getMessage();
        }
        $this->setVar($arr);
    }


}