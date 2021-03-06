<?php

namespace Forum\Model\Form\Section;

use \Soft\AbstractValidator as Validator;

class SectionValidator extends Validator
{
    private $data = [];

    public function isValid(array $data, $csrfToken = "")
    {
        $this->errors = [];
        $this->data = $data;
        
        $this->validName();
        $this->validDescription();
        $this->validIsClosed();
        $this->validUnexpectedFields($this->data);
        $this->validCsrfToken($this->data, $csrfToken);
        
        
        if ($this->getErrors()) {
            return false;
        }
        
        return true;
    }
    
    private function validName()
    {
        $fieldName = "s_name";
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
        $fieldName = "s_description";
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
    
    private function validIsClosed()
    {
        $fieldName = "s_is_closed";
        $fieldLabel = "Status";
        
        if (!$this->validIsFieldExist($this->data, $fieldName, $fieldLabel)) {
            return;
        }
        
        $this->validIsInArray($this->data, $fieldName, $fieldLabel, ["0","1"]);
    }
    
}
