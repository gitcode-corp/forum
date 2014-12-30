<?php
namespace Soft;

class Request {
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';
    
    private $data = array();
    private $postParams = array();
    private $getParams = array();
    private $method = self::METHOD_GET;
    private $requestUri = null;
    private $domain = "";
    private $scheme = "http";
    
    public function __construct()
    {
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->data = $_REQUEST;
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        $this->setMethod($_SERVER['REQUEST_METHOD']);
        $this->domain = $_SERVER["HTTP_HOST"];
        $this->scheme = $_SERVER["REQUEST_SCHEME"];
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
    
    public function getPostParams()
    {
        return $this->postParams;
 
    }
    
    public function getDomain()
    {
        return $this->domain;
    }
    
    public function getScheme()
    {
        return $this->scheme;
    }
    
    public function setMethod($method)
    {
        $method = strtoupper($method);
        if (!defined('static::METHOD_' . $method)) {
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
        if (strtoupper($method) === $this->getMethod()) {
           return true;
        }
        
        return false;
    }
    
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }
    
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }
}
