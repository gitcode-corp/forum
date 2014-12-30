<?php

namespace Forum\Model\Form\Section;

class SectionForm extends \Soft\AbstractForm
{
    public function __construct(\Soft\AbstractValidator $validator)
    {
        $validator->setFormFields($this->getFields());
        parent::__construct($validator);
    }
    
    public function getFields()
    {
        return [
            "s_name",
            "s_description"
        ];
    }
    
}

