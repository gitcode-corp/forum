<?php

namespace Soft;

abstract class AbstractValidator
{
    const ERROR_EMPTY = "Pole '%s' nie moze byc puste.";
    const ERROR_TOO_LONG = "Pole '%s' moze miec max. %d znakow.";
    const ERROR_TOO_SHORT = "Pole '%s' musi miec min. %d znakow.";
    const ERROR_UNEXPECTED_FIELD = "Niedozwolone pole '%s'";
    
    protected $errors = [];
    protected $fields = [];
    
    /**
     * @param array $data
     * @return bool
     */
    public abstract function isValid(array $data);
    
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
        $unexpectedFields = array_diff($dataKeys, $this->fields);
        
        foreach ($unexpectedFields as $field) {
            $error = sprintf(self::ERROR_UNEXPECTED_FIELD, $field);
            $this->addError("unexpected", $error);
        }
    }
}

