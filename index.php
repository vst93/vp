<?php
/**
 * Created by PhpStorm.
 * User: vv
 * Date: 2018/9/12
 * Time: 18:51
 */
include_once('class/db.php');
$pdo = new db();

// SELECT * FROM users WHERE id = ?
$data = $pdo->vDelete('users',['id[<]'=>2]);


var_dump($data);
