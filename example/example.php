<?php

class example{

    public function helloName($name){
        return 'Hello, '.$name;
    }

    public static function md5($string, $times){
        var_dump($string,$times);
        for($i = 1; $i < $times; $i++){
            $string = md5($string);
        }
        return $string;
    }

}