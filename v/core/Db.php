<?php

namespace core;
require_once '../vendor/autoload.php';

use Medoo\Medoo;

class Db extends Medoo
{

    private $dbHost = '';
    private $dbName = 'xz';
    private $dbUser = 'root';
    private $dbPwd = 'root';

    public function __construct()
    {
        $info = [
            'database_type' => 'mysql',
            'database_name' => $this->dbName,
            'server' => $this->dbHost,
            'username' => $this->dbUser,
            'password' => $this->dbPwd
        ];
        parent::__construct($info);
    }


    public function vInsert(string $tableName, array $data)
    {
        $do = parent::insert($tableName, $data);
        if ($do->errorCode() === '00000') {
            return $this->id();
        } else {
            return false;
        }
    }


    public function vSelect(string $tableName, $columns='*', array $where=[], string $order = '', string $limit = '')
    {
        $order = trim($order);
        if (!empty($order)) {
            unset($where['ORDER']);
            $order_arr = explode(',', $order);
            if (is_array($order_arr) && count($order_arr) > 0) {
                foreach ($order_arr as $order_arr_value) {
                    $order_arr_values = explode(' ', trim($order_arr_value));
                    $where['ORDER'][$order_arr_values[0]] = isset($order_arr_values[1]) ? strtoupper($order_arr_values[1]) : 'ASC';
                }
            }
        }

        $limit = trim($limit);
        if (!empty($limit)) {
            unset($where['LIMIT']);
            $limit_arr = explode(',', $limit);
            if (is_array($order_arr) && count($order_arr) > 0) {
                if (count($limit_arr) == 1) {
                    $where['LIMIT'] = $limit_arr[0];
                } else {
                    $where['LIMIT'] = [$limit_arr[0], $limit_arr[1]];
                }
            }
        }


        $do = parent::select($tableName, $columns, $where);
        return $do;
    }

    public function vUpdate($tableName, $data, $where)
    {
        $do = parent::update($tableName, $data, $where);
        if ($do->errorCode() === '00000') {
            return $do->rowCount();
        } else {
            return false;
        }
    }

    public function vDelete($tableName, $where)
    {
        $do = parent::delete($tableName, $where);
        if ($do->errorCode() === '00000') {
            return $do->rowCount();
        } else {
            return false;
        }
    }


    public function vGet(string $tableName, $columns='*', array $where=[], string $order = '')
    {
        $order = trim($order);
        if (!empty($order)) {
            unset($where['ORDER']);
            $order_arr = explode(',', $order);
            if (is_array($order_arr) && count($order_arr) > 0) {
                foreach ($order_arr as $order_arr_value) {
                    $order_arr_values = explode(' ', trim($order_arr_value));
                    $where['ORDER'][$order_arr_values[0]] = isset($order_arr_values[1]) ? strtoupper($order_arr_values[1]) : 'ASC';
                }
            }
        }
        $do = parent::get($tableName, $columns, $where);
        return $do;
    }

    public function vCount($tableName, $where = [])
    {
        return parent::count($tableName, $where);
    }

    public function vSum($tableName, $column, $where = [])
    {
        return parent::sum($tableName, $column, $where);
    }

}