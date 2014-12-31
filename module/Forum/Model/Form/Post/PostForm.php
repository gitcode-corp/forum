<?php

namespace Forum\Model\Form\Post;

class PostForm extends \Soft\AbstractForm
{
    public function __construct(\Soft\AbstractValidator $validator)
    {
        $validator->setFormFields($this->getFields());
        parent::__construct($validator);
    }
    
    public function getFields()
    {
        return [
            "p_content",
        ];
    }  
}
