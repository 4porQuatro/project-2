<?php


namespace App\Classes\Ui\Constants;


abstract class ConstantAbstract
{
    public $class_name;

    abstract protected function data();

    public function __construct()
    {
        $this->class_name = get_class($this);
    }

    public function routes()
    {
        $routes = [];

        foreach ($this->routes as $route)
        {
            $routes[$route] = $this->class_name;
        }

        return $routes;
    }

    public function getData($route_name)
    {
        $data = $this->data();

        return $data[$route_name];
    }
}
