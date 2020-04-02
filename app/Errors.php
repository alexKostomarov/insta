<?php
namespace App;

class Errors{
    public static function abort($code){
         switch ($code){
            case 404:
                header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
                break;
             case 500:
                 header($_SERVER['SERVER_PROTOCOL']." 500 Server Error");
                 break;
         }

        die;
    }
}