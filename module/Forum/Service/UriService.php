<?php

namespace Forum\Service;

class UriService
{
    private $routes = [];
    private $domain = "";
    
    public function __construct(array $routes, $domain)
    {
        $this->routes = $routes;
        $this->domain = $domain;
    }
    
    public function generate($name, $params = [])
    {
        if (!array_key_exists($name, $this->routes)) {
            throw new \InvalidArgumentException("Route name not found : " . $name);
        }
        
        $query = [];
        $pattern = $this->routes[$name]['pattern'];
        foreach ($params as $name=>$value) {
            $param = '[:' . $name . ']';
            if (strpos($pattern, $param) !== false) {
                $pattern = str_replace($param, $value , $pattern);
            } else {
                $query[] = $name . "=" . $value;
            }
        }
        
        if ($query) {
            $url = $pattern . "?" . implode("&", $query);
        } else {
            $url = $pattern;
        }
        
        if ($url == "/") {
            $url = \Soft\RouteMatcher::HOST;
        } elseif (\Soft\RouteMatcher::HOST !== "/") {
            $url = substr($url, 1);
        }
        
        return $url;
    }
}

