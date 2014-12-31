<?php

namespace Forum\Model\Form\Topic;

class TopicAdminValidator extends TopicValidator
{
    public function isValid(array $data, $csrfToken = "")
    {
        $isValidParent = parent::isValid($data, $csrfToken);
        $isValidClosed = $this->validIsClosed();

        if ($isValidParent && $isValidClosed) {
            return true;
        }
        
        return false; 
    }
    
    private function validIsClosed()
    {
        $fieldName = "t_is_closed";
        $fieldLabel = "Status";
        
        if (!$this->validIsFieldExist($this->data, $fieldName, $fieldLabel)) {
            return false;
        }
        
        return $this->validIsInArray($this->data, $fieldName, $fieldLabel, ["0","1"]);
    } 
}
