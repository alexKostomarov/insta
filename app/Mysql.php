<?php
namespace App;



class Mysql{

    protected  $host, $user, $password, $dbname;

    private static $instance = null;

    private function __construct()
    {
        $config = require ("config.php");

        $this->host  = $config['db']['host'];

        $this->user  = $config['db']['user'];

        $this->password  = $config['db']['password'];

        $this->dbname  = $config['db']['dbname'];
    }

    public static function getDb(){

        if(!self::$instance) self::$instance = new static();

        return self::$instance;
    }

    public function get($sql){

        $mysql = new \mysqli($this->host, $this->user, $this->password, $this->dbname);

        if(!$mysql) App\Errors::abort(500);

        $result = $mysql->query($sql);

        if(!$result){ print_r($mysql->error_list); Errors::abort(500);}

        $ret = [];

        while($row = $result->fetch_assoc()) $ret[] = $row;


        $result->free();

        $mysql->close();

        return $ret;
    }
}