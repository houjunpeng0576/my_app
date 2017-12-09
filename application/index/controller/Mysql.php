<?php
namespace app\index\controller;

class Mysql {
    public function get(){
        $table = input('get.table');
        print_r($table);die;
    }

    public function getAll(){
        $array = [
            'hhh' =>'asd',
            'ddd' => 'aqwe',
            'eee' => 'qweqe',
        ];
        print_r(view($array));die;
        echo 444;
    }
}