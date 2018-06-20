<?php

namespace Qcrawler\lib\route;

use Qcrawler\Core;

/**
 * Class Route
 * @package Qcrawler\route
 * @method Route get(string $route, Callable $callback)
 * @method Route post(string $route, Callable $callback)
 * @method Route put(string $route, Callable $callback)
 * @method Route delete(string $route, Callable $callback)
 * @method Route options(string $route, Callable $callback)
 * @method Route head(string $route, Callable $callback)
 */
class Route
{
    public $halts = false;
    public $routes = [];
    public $methods = [];
    public $callbacks = [];
    public $maps = [];
    public $patterns = [
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
        ':all' => '.*'
    ];
    public $error_callback;

    public function __call($name, $arguments)
    {
        if ($name == 'map') {
            $maps = array_map('strtoupper', $arguments[0]);
            $uri = strpos($arguments[1], '/') === 0 ? $arguments[1] : '/' . $arguments[1];
            $callback = $arguments[2];
        } else {
            $maps = null;
            $uri = strpos($arguments[0], '/') === 0 ? $arguments[0] : '/' . $arguments[0];
            $callback = $arguments[1];
        }

        array_push($this->maps, $maps);
        array_push($this->routes, $uri);
        array_push($this->methods, strtoupper($name));
        array_push($this->callbacks, $callback);
    }

    /**
     * Defines callback if route is not found
     */
    public function error($callback) {
        $this->error_callback = $callback;
    }

    public function haltOnMatch($flag = true) {
        $this->halts = $flag;
    }

    /**
     * Runs the callback for the given request
     */
    public function dispatch(){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $searches = array_keys($this->patterns);
        $replaces = array_values($this->patterns);

        $found_route = false;

        $this->routes = preg_replace('/\/+/', '/', $this->routes);

        // Check if route is defined without regex
        if (in_array($uri, $this->routes)) {
            $route_pos = array_keys($this->routes, $uri);
            foreach ($route_pos as $route) {

                // Using an ANY option to match both GET and POST requests
                if ($this->methods[$route] == $method || $this->methods[$route] == 'ANY' || in_array($method, $this->maps[$route])) {
                    $found_route = true;

                    // If route is not an object
                    if (!is_object($this->callbacks[$route])) {

                        // Grab all parts based on a / separator
                        $parts = explode('/',$this->callbacks[$route]);

                        // Collect the last index of the array
                        $last = end($parts);

                        // Grab the controller name and method call
                        $segments = explode('@',$last);
                        $controller = Core::param('controllers').$segments[0];

                        // Instanitate controller
                        $controller = new $controller();

                        // Call method
                        $controller->{$segments[1]}();

                        if ($this->halts) return;
                    } else {
                        // Call closure
                        call_user_func($this->callbacks[$route]);

                        if ($this->halts) return;
                    }
                }
            }
        } else {
            // Check if defined with regex
            $pos = 0;
            foreach ($this->routes as $route) {
                if (strpos($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route);
                }

                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    if ($this->methods[$pos] == $method || $this->methods[$pos] == 'ANY' || (!empty($this->maps[$pos]) && in_array($method, $this->maps[$pos]))) {
                        $found_route = true;

                        // Remove $matched[0] as [1] is the first parameter.
                        array_shift($matched);

                        if (!is_object($this->callbacks[$pos])) {

                            // Grab all parts based on a / separator
                            $parts = explode('/',$this->callbacks[$pos]);

                            // Collect the last index of the array
                            $last = end($parts);

                            // Grab the controller name and method call
                            $segments = explode('@',$last);
                            $controller = Core::param('controllers').$segments[0];

                            // Instanitate controller
                            $controller = new $controller();

                            // Fix multi parameters
                            if (!method_exists($controller, $segments[1])) {
                                echo "controller and action not found";
                            } else {
                                call_user_func_array(array($controller, $segments[1]), $matched);
                            }

                            if ($this->halts) return;
                        } else {
                            call_user_func_array($this->callbacks[$pos], $matched);

                            if ($this->halts) return;
                        }
                    }
                }
                $pos++;
            }
        }

        // Run the error callback if the route was not found
        if ($found_route == false) {
            if (!$this->error_callback) {
                $this->error_callback = function() {
                    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
                    echo '404';
                };
            } else {
                if (is_string($this->error_callback)) {
                    $this->get($_SERVER['REQUEST_URI'], $this->error_callback);
                    $this->error_callback = null;
                    $this->dispatch();
                    return ;
                }
            }
            call_user_func($this->error_callback);
        }
    }


}