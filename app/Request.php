<?php
namespace App;

Class Request{

    public $method;
    public $uri;
    public $params;
    public $path;

    public function __construct()
    {
        $struct = parse_url($_SERVER['REQUEST_URI']);

        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->uri = $_SERVER['REQUEST_URI'];

        $this->path = $struct['path'];

        $this->params = $_REQUEST;


    }
}