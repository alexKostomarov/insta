<?php
namespace App\Controllers;

use App\Request;
use App\Mysql;

class CurrencyController{

    public function list(Request $request, $params){

        $valuteId = $params[0];

        $from = $params[1];//в базе в виде 2020-03-04

        $to = $params[2];

        $sql = "SELECT * FROM currency";

        if($valuteId) $sql .= " WHERE valuteId = '$valuteId'";

        if($from) $sql .= " AND date >= '$from'";

        if( $to) $sql .= " AND date <= '$to'";

        elseif($from) $sql .= " AND date <= '$from'";


        if(array_key_exists("size", $request->params) ){

            $size = (int) $request->params['size'];

            $page = 0;

            if(array_key_exists("page", $request->params) ) $page = (int) $request->params['page'];

            $sql .= " LIMIT $size OFFSET ". ($size * $page);
        }



        $db = Mysql::getDb();

        $res = $db->get($sql);

        $this->responseJson($res);

        exit;
    }

    public function getValuteIds(){
        $sql = "SELECT valuteId FROM currency GROUP BY valuteId";
        $db = Mysql::getDb();
        $res = $db->get($sql);

        $ret = [];
        foreach( $res as $row) $ret[] = $row["valuteId"];

        $this->responseJson($ret);
        exit;
    }

    public function getDates(){
        $sql = "SELECT date FROM currency GROUP BY date ORDER BY date ASC";
        $db = Mysql::getDb();
        $res = $db->get($sql);

        $ret = [];
        foreach( $res as $row) $ret[] = $row["date"];

        $this->responseJson($ret);
        exit;
    }


    private function responseJson($str){

        header("Content-Type: application/json;charset=utf-8");

        echo json_encode($str);

    }

}