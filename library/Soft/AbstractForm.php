<?php

namespace Soft;

abstract class AbstractForm
{
    /**
     * @var array
     */
    private $data = [];
    
    /**
     * @var array
     */
    private $errors = [];
    
    /**
     * @var \Soft\Validator 
     */
    private $validator;
    
    public function __construct(\Soft\AbstractValidator $validator)
    {
        $this->validator = $validator;
    }
    
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->data)) {
            return htmlspecialchars($this->data[$key]);
        }

        return $default;
    }
    
    public function getError($key)
    {
        if ($this->hasError($key)) {
            return $this->errors[$key];
        }
        
        return [];
    }
    
    public function hasError($key)
    {
        return array_key_exists($key, $this->errors);
    }
    
    public function isValid(array $data = [])
    {
        $this->data = $data;
        $isValid = $this->validator->isValid($data);
        $this->errors = $this->validator->getErrors();
        
        return $isValid;
    }
    
    /**
     * @return array
     */
    public abstract function getFields();
    
    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
