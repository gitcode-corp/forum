<?php

namespace Forum\Model\Form\Section;

use \Soft\AbstractValidator as Validator;

class SectionValidator extends Validator
{
    private $data = [];

    public function isValid(array $data)
    {
        $this->errors = [];
        $this->data = $data;
        
        $this->validName();
        $this->validDescription();
        $this->validUnexpectedFields($this->data);
        
        if ($this->getErrors()) {
            return false;
        }
        
        return true;
    }
    
    private function validName()
    {
        $field = "s_name";
        if (!isset($this->data[$field])) {
            $error = sprintf(Validator::ERROR_EMPTY, "Tytul");
            $this->addError($field, $error);
        }
        
        $name = trim($this->data[$field]);
        if (empty($name)) {
            $error = sprintf(Validator::ERROR_EMPTY, "Tytul");
            $this->addError($field, $error);
        }
        
        if (strlen($name) < 5) {
            $error = sprintf(Validator::ERROR_TOO_SHORT, "Tytul", 5);
            $this->addError($field, $error);
        }
        
        if (strlen($name) > 250) {
            $error = sprintf(Validator::ERROR_TOO_LONG, "Tytul", 250);
            $this->addError($field, $error);
        }
    }
    
    private function validDescription()
    {
        $field = "s_description";
        if (!isset($this->data[$field])) {
            return;
        }
        
        $value = trim($this->data[$field]);
        if (empty($value)) {
            return;
        }
        
        if (strlen($value) > 2000) {
            $error = sprintf(Validator::ERROR_TOO_LONG, "Podsumowanie", 2000);
            $this->addError($field, $error);
        }
    }
    
}
