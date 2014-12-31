<?php

namespace Forum\Model\Form\Topic;

class TopicAdminForm extends TopicForm
{    
    public function getFields()
    {
        return [
            "t_name",
            "t_description",
            "t_is_closed",
        ];
    }
    
    public function isAdminForm()
    {
        return true;
    }
    
}
