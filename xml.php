<?php

function currencyList(){

    $page  = file_get_contents("http://www.cbr.ru/scripts/XML_daily.asp");

    $xml = new XMLReader();

    $xml->xml($page);

    $arr = xmlToArray($xml);

    $ret = [];

    foreach($arr[0]['ValCurs'] as $rec){

        $res = [];

        $valute = $rec['Valute'];

        foreach ($valute as $x){

            $res[key($x)] = $x[key($x)];
        }

        $res['valuteId'] = $rec['attributes']['ID'];

        $ret[] = $res;
    }

    return $ret;
}

/**
 * @param $id string id валюты
 * @param $start string начальная дата число/месяц/год
 * @param $end string конечная дата
 * @return array
 */
function currencyById($id, $start, $end){

    $page  = file_get_contents("http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1=$start&date_req2=$end&VAL_NM_RQ=$id");

    $xml = new XMLReader();

    $xml->xml($page);

    $arr = xmlToArray($xml);

    $ret= [];

    foreach($arr[0]['ValCurs'] as $a){
        $arr = [];

        $record = $a['Record'];

        //print_r($record);

        foreach ($record as $x){
            $arr[key($x)] = $x[key($x)];
        }


        $arr['Date'] = $a['attributes']['Date'];

        $ret[] = $arr;

    }


    return $ret;
}

/**
 * @param $xml- XMLReader
 * @return array|string|null
 */
function xmlToArray($xml){

    $tree = null;

    while($xml->read())

        switch ($xml->nodeType) {

            case XMLReader::END_ELEMENT: return $tree;

            case XMLReader::ELEMENT:

                $node = array($xml->name => $xml->isEmptyElement ? '' : xmlToArray($xml));

                if($xml->hasAttributes)

                    while($xml->moveToNextAttribute()) $node['attributes'][$xml->name] = $xml->value;

                $tree[] = $node;

                break;

            case XMLReader::TEXT:

            case XMLReader::CDATA:

                $tree .= $xml->value;
        }
    return $tree;
}



?>