<?php
namespace Soft;

class Response
{ 
    private $statusCodes = array(
		200 => 'OK',
                404 => 'Not Found'
        );
    
    private $mimeTypes = array(
		'html' => 'text/html', '*/*',
        );
    
    private $protocol = 'HTTP/1.1';
    private $httpResponseCode = 200;
    private $contentType = 'html';
    private $headers = array();
    private $body = null;
    
    
    public function getHeaders()
    {
        return $this->headers;
    }
    
    public function setHeader($name, $value, $replace = false)
    {
        $this->headers[] = array(
          'name' => $name,
          'value'=>$value,
          'replace'=>$replace
        );
    }
    
    public function sendHeaders()
    {
        foreach($this->headers as $header) {
            header($header['name'] . ': ' . $header['value'], $header['replace']);
        }
        
        if(empty($this->headers)) {
             header('Content-Type:'. $this->getMimeType());
        }
        
        header($this->protocol.' '. $this->httpResponseCode);
    }
    
    public function setHttpResponseCode($code)
    {
        if(isset($this->statusCodes[$code])) {
            $this->httpResponseCode = $code;
        } 
    }
    
    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }
    
     public function setBody($content)
    {
        $this->body = $content;

        return $this;
    }
    
    public function outputBody()
    {
        echo $this->body;
    }
    
    public function setContentType($type)
    {
        if(isset($this->mimeTypes[$type])) {
            $this->contentType = $type;
        }
    }
    
    public function getContentType()
    {
        return $this->contentType;
    }
    
    public function getMimeType()
    {
        return $this->mimeTypes[$this->getContentType()];
    }
    
    public function sendResponse()
    {
        $this->sendHeaders();
        $this->outputBody();
    }
}
