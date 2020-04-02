<?php
require ("db.php");
require ('xml.php');

$valutes = currencyList();



foreach ($valutes as $valute ){

    echo $valute["valuteId"] ."\n";

    $xml_res = currencyById($valute['valuteId'], '15/02/2020', '30/03/2020');


    foreach($xml_res as $rec){

        echo "\t".$rec['Date']."\n";

        $model['valuteID'] = $valute['valuteId'];

        $model['numCode'] = $valute['NumCode'];

        $model['charCode'] = $valute['CharCode'];

        $model['value'] = $rec['Value'];

        $model['date'] = $rec['Date'];

        echo insert($model);
    }

}




?>