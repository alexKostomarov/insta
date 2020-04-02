<?php
namespace App;

use App\Request;
use App\Errors;

class Router{

    private static $routes = [
        '/' => 'App\Controllers\HomeController@index',

        //api

        '/api/dates' => 'App\Controllers\CurrencyController@getDates',//спсиок дат, на которые есть записи
        '/api/valuteId' => 'App\Controllers\CurrencyController@getValuteIds',//список Id валют
        '/api/(\w+)(?:/([-\w]+)(?:/([-\w]+))?)?' => 'App\Controllers\CurrencyController@list',// api/10-12-2020/id/.. вывод списка моделей с фильтром

    ];

    public static function route(Request $request){

         foreach (self::$routes as $pattern => $callback)
        {
            if (preg_match('#^'.$pattern.'$#U', $request->path, $params))
            {

                array_shift($params);

                list($controller_name, $action) = explode('@', $callback);

                $controller = new $controller_name();

                //Передаем в контроллер разобранный url - что с ним делать - забота контроллера
                $controller->$action($request, $params);

                return;
            }
        }

        Errors::abort(404);
    }


}