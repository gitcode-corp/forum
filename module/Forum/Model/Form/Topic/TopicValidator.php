<?php

namespace Forum\Model\Form\Topic;

use \Soft\AbstractValidator as Validator;

class TopicValidator extends Validator
{
    protected $data = [];

    public function isValid(array $data, $csrfToken = "")
    {
        $this->errors = [];
        $this->data = $data;
        
        $this->validName();
        $this->validDescription();
        $this->validUnexpectedFields($this->data);
        $this->validCsrfToken($this->data, $csrfToken);
        
        
        if ($this->getErrors()) {
            return false;
        }
        
        return true;
    }
    
    private function validName()
    {
        $fieldName = "t_name";
        $fieldLabel = "Tytuł";
        
        if (!$this->validIsFieldExist($this->data, $fieldName, $fieldLabel)) {
            return;
        }
        
        $this->validIsNotEmpty($this->data, $fieldName, $fieldLabel);
        $this->validIsNotTooShort($this->data, $fieldName, $fieldLabel, 5);
        $this->validIsNotTooLong($this->data, $fieldName, $fieldLabel, 250);
    }
    
    private function validDescription()
    {
        $fieldName = "t_description";
        $fieldLabel = "Podsumowanie";
        
        if (!$this->validIsFieldExist($this->data, $fieldName, $fieldLabel)) {
            return;
        }
        
        if (!isset($this->data[$fieldName])) {
            return;
        }
        
        $value = trim($this->data[$fieldName]);
        if (empty($value)) {
            return;
        }
        
        $this->validIsNotTooLong($this->data, $fieldName, $fieldLabel, 2000);
    }
}
