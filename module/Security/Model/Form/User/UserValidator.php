<?php

namespace Security\Model\Form\User;

use \Soft\AbstractValidator as Validator;
use Security\Model\Entity\Command\User\RetrieveByEmailCommand;
use Security\Model\Entity\Command\User\RetrieveByUsernameCommand;

class UserValidator extends Validator
{
    private $data = [];
    private $retrieveUserByUsernameCommand;
    private $retrieveUserByEmailCommand;
    
    public function __construct(
        RetrieveByUsernameCommand $retrieveUserByUsernameCommand,
        RetrieveByEmailCommand $retrieveUserByEmailCommand
    ){
        $this->retrieveUserByUsernameCommand = $retrieveUserByUsernameCommand;
        $this->retrieveUserByEmailCommand = $retrieveUserByEmailCommand;
    }

    public function isValid(array $data, $csrfToken = "")
    {
        $this->errors = [];
        $this->data = $data;
        
        $this->validUsername();
        $this->validEmail();
        $this->validPassword();
        $this->validUnexpectedFields($this->data);
        $this->validCsrfToken($this->data, $csrfToken);
        
        
        if ($this->getErrors()) {
            return false;
        }
        
        return true;
    }
    
    private function validUsername()
    {
        $fieldName = "u_username";
        $fieldLabel = "Login";
        
        if (!$this->validIsFieldExist($this->data, $fieldName, $fieldLabel)) {
            return;
        }
        
        $this->validIsNotEmpty($this->data, $fieldName, $fieldLabel);
        $this->validIsNotTooShort($this->data, $fieldName, $fieldLabel, 5);
        $this->validIsNotTooLong($this->data, $fieldName, $fieldLabel, 250);
        $this->validIsUniqueUsername($this->data, $fieldName, $fieldLabel);
    }
    
    private function validEmail()
    {
        $fieldName = "u_email";
        $fieldLabel = "E-mail";
        
        if (!$this->validIsFieldExist($this->data, $fieldName, $fieldLabel)) {
            return;
        }
        
        $this->validIsNotEmpty($this->data, $fieldName, $fieldLabel);
        $this->validIsEmail($this->data, $fieldName, $fieldLabel);
        $this->validIsUniqueEmail($this->data, $fieldName, $fieldLabel);
    }
    
    private function validPassword()
    {
        $fieldName = "u_password";
        $fieldLabel = "Hasło";
        
        $fieldNameRepeated = "repeat_password";
        $fieldLabelRepeated = "Powtórz hasło";
        
        if (
            !$this->validIsFieldExist($this->data, $fieldName, $fieldLabel)
            || !$this->validIsFieldExist($this->data, $fieldNameRepeated, $fieldLabelRepeated)
        ) {
            return;
        }
        
        $this->validIsNotTooShort($this->data, $fieldName, $fieldLabel, 5);
        $this->validIsNotTooLong($this->data, $fieldName, $fieldLabel, 25);
        
        $value = $this->data[$fieldName];
        $valueRepeated = $this->data[$fieldNameRepeated];
        
        if ($value !== $valueRepeated) {
            $this->addError($fieldName, "Pole haslo i powtorz haslo musza byc takie same");
        }
    }
    
    private function validIsUniqueUsername(array $data,$fieldName, $fieldLabel)
    {
        $value = $data[$fieldName];
        $this->retrieveUserByUsernameCommand->setUsername($value);
        $user = $this->retrieveUserByUsernameCommand->execute();
        
        if ($user) {
            $this->addError($fieldName, "Login jest juz zajety.");
            
            return false;
        }
        
        return true;
    }
    
    private function validIsUniqueEmail(array $data,$fieldName, $fieldLabel)
    {
        $value = $data[$fieldName];
        $this->retrieveUserByEmailCommand->setEmail($value);
        $user = $this->retrieveUserByEmailCommand->execute();
        
        if ($user) {
            $this->addError($fieldName, "E-mail jest juz zajety.");
            
            return false;
        }
        
        return true;
    }
    
    private function validIsEmail(array $data,$fieldName, $fieldLabel)
    {
        $value = trim($data[$fieldName]);
        
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $error = "Wpisz poprawnie e-mail.";
            $this->addError($fieldName, $error);
            
            return false;
        }
        
        return true;
    }
}
