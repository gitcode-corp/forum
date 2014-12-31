<?php

namespace Forum\Model\Form\Topic;

class TopicForm extends \Soft\AbstractForm
{
    public function __construct(\Soft\AbstractValidator $validator)
    {
        $validator->setFormFields($this->getFields());
        parent::__construct($validator);
    }
    
    public function getFields()
    {
        return [
            "t_name",
            "t_description",
        ];
    }
    
    public function isAdminForm()
    {
        return false;
    }
    
}
