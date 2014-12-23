<?php
namespace Soft;

class Request {
    const METHOD_GET     = 'GET';
    const METHOD_POST    = 'POST';
    
    private $data = array();
    private $postParams = array();
    private $getParams = array();
    private $method = self::METHOD_GET;
    private $requestUri = null;
    
    public function __construct()
    {
        $this->requestUri = $_SERVER['REQUEST_URI'];;
        $this->data = $_REQUEST;
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        $this->setMethod($_SERVER['REQUEST_METHOD']);
    }
    
    public function getRequestUri()
    {
        return $this->requestUri;
    }
    
    public function getParam($name, $default = null)
    {
        if(isset($this->getParams[$name])) {
            return $this->getParams[$name];
        }
        
        return $default;
    }
    
    public function getParams()
    {
        return $this->getParams;
    }
    
    public function getPostParam($name, $default = null)
    {
        if(isset($this->postParams[$name])) {
            return $this->postParams[$name];
        }
        
        return $default;
    }
    
    public function setMethod($method)
    {
        $method = strtolower($method);
        if (!defined('static::METHOD_' . strtoupper($method))) {
           $method = 'GET';
        }
        $this->method = $method;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function isMethod($method)
    {
        if (defined('static::METHOD_' . strtoupper($method))) {
           return true;
        }
        
        return false;
    }
}
