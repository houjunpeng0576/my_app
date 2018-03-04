<?php
namespace app\api\controller;

class Time{
    public function index(){
        return show('1','OK',time());
    }
}