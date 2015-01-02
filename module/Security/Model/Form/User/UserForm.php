<?php

namespace Security\Model\Form\User;

class UserForm extends \Soft\AbstractForm
{
    public function __construct(\Soft\AbstractValidator $validator)
    {
        $validator->setFormFields($this->getFields());
        parent::__construct($validator);
    }
    
    public function getFields()
    {
        return [
            "u_username",
            "u_email",
            "u_password",
            "repeat_password"
        ];
    }  
}

