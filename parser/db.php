<?php
define('HOST','127.0.0.1');
define('USER', 'root');
define('PASSWORD', '');
define('DBNAME','currency');



function select($start, $end = null){

    $mysql = new mysqli(HOST, USER, PASSWORD , DBNAME);

    $query = "SELECT * FROM 'currency' WHERE ";

    $query .= $end ? " WHERE date >= $start AND date <= $end" : " WHERE date = $start";

    $result = $mysql->query($query);

    $ret = [];

    if($result && $result->num_rows !== 0){
        $ret = $result->fetch_assoc();
    }
    $result->free();

    $mysql->close();

    return $ret;
}

function insert($data){

    $mysql = new mysqli(HOST, USER, PASSWORD , DBNAME);

    if ($mysql->connect_errno) {
        printf("Connect failed: %s\n", $mysql->connect_error);
        exit();
    }
    //Дата приходит в формате 26.01.2020. Нужна в виде 2020-01-26
    $list= explode('.', $data['date']);
    $date = $list[2] . "-" .$list[1] .'-'.$list[0];

    $sql = "INSERT INTO currency VALUES ( NULL, '";
    $sql .= $data['valuteID']. "', '";
    $sql .= $data['numCode']. "', '";
    $sql .= $data['charCode']. "', ";
    $sql .= str_replace(",",".",$data['value']). ", '";
    $sql .= $date. "')";

    $ret = null;

    if($mysql->real_query($sql)) $ret = $mysql->insert_id;

    $mysql->close();

    return $ret;
}


?>