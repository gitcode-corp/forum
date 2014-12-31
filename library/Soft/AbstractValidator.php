<?php

namespace Soft;

abstract class AbstractValidator
{
    const ERROR_EMPTY = "Pole '%s' nie moze byc puste.";
    const ERROR_TOO_LONG = "Pole '%s' moze miec max. %d znakow.";
    const ERROR_TOO_SHORT = "Pole '%s' musi miec min. %d znakow.";
    const ERROR_UNEXPECTED_FIELD = "Niedozwolone pole '%s'.";
    const ERROR_CSRF_TOKEN = "Zły token. Spróbuj ponownie.";
    const ERROR_OPTION_NOT_ALLOWED = "Pole '%s' zawiera niedozwoloną wartość.";
    const ERROR_FIELD_REQUIRED = "Pole '%s' jest wymagane.";
    
    protected $errors = [];
    protected $fields = [];
    
    /**
     * @param array $data
     * @param string $csrfToken
     * @return bool
     */
    public abstract function isValid(array $data, $csrfToken = "");
    
    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * @return void
     */
    public function setFormFields(array $fields)
    {
        $this->fields = $fields;
    }
    
    protected function addError($field, $error)
    {
        $this->errors[$field][] = $error;
    }
    
    protected function validUnexpectedFields($data)
    {
        $dataKeys = array_keys($data);
        $unexpectedFields = array_diff($dataKeys, array_merge($this->fields, ["csrf_token"]));
        
        $isValid = true;
        foreach ($unexpectedFields as $field) {
            $error = sprintf(self::ERROR_UNEXPECTED_FIELD, $field);
            $this->addError("unexpected", $error);
            
            $isValid = false;
        }
        
        return $isValid;
    }
    
    protected function validIsNotEmpty(array $data, $fieldName, $fieldLabel)
    {
        $isValid = true;
        if (!isset($data[$fieldName])) {
            $error = sprintf(self::ERROR_EMPTY, $fieldLabel);
            $this->addError($fieldName, $error);
            $isValid = false;
        }
        
        $value = trim($data[$fieldName]);
        if (empty($value)) {
            $error = sprintf(self::ERROR_EMPTY, $fieldLabel);
            $this->addError($fieldName, $error);
            $isValid = false;
        }
        
        return $isValid;
    }
    
    protected function validIsNotTooShort(array $data, $fieldName, $fieldLabel, $min)
    {
        $value = trim($data[$fieldName]);
        if (strlen($value) < $min) {
            $error = sprintf(self::ERROR_TOO_SHORT, $fieldLabel, $min);
            $this->addError($fieldName, $error);
            
            return false;
        }
        
        return true;
    }
    
    protected function validIsNotTooLong(array $data, $fieldName, $fieldLabel, $max)
    {
        $value = trim($data[$fieldName]);
        if (strlen($value) > $max) {
            $error = sprintf(self::ERROR_TOO_LONG, $fieldLabel, $max);
            $this->addError($fieldName, $error);
            
            return false;
        }
        
        return true;
    }
    
    protected function validCsrfToken(array $data, $csrfToken)
    {
        if(!isset($data["csrf_token"]) || $data["csrf_token"] !== $csrfToken) {
            $this->addError("csrf_token", self::ERROR_CSRF_TOKEN);
            return false;
        }
        
        return true;
    }
    
    protected function validIsInArray(array $data, $fieldName, $fieldLabel, array $allowed)
    {
        $value = $data[$fieldName];
        if (!in_array($value, $allowed)) {
            $error = sprintf(self::ERROR_OPTION_NOT_ALLOWED, $fieldLabel);
            $this->addError($fieldName, $error);
            
            return false;
        }
        
        return true;
    }
    
    protected function validIsFieldExist(array $data, $fieldName, $fieldLabel)
    {
        if (!array_key_exists($fieldName, $data)) {
            $error = sprintf(self::ERROR_FIELD_REQUIRED, $fieldLabel);
            $this->addError($fieldName, $error);
            return false;
        }
        
        return true;
    }
}

