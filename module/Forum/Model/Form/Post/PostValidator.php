<?php

namespace Forum\Model\Form\Post;

use \Soft\AbstractValidator as Validator;

class PostValidator extends Validator
{
    private $data = [];

    public function isValid(array $data, $csrfToken = "")
    {
        $this->errors = [];
        $this->data = $data;
        
        $this->validContent();
        $this->validUnexpectedFields($this->data);
        $this->validCsrfToken($this->data, $csrfToken);
        
        
        if ($this->getErrors()) {
            return false;
        }
        
        return true;
    }
    
    
    private function validContent()
    {
        $fieldName = "p_content";
        $fieldLabel = "Treść";
        
        if (!$this->validIsFieldExist($this->data, $fieldName, $fieldLabel)) {
            return;
        }
        
        $this->validIsNotEmpty($this->data, $fieldName, $fieldLabel);
        $this->validIsNotTooLong($this->data, $fieldName, $fieldLabel, 2000);
    }  
}
