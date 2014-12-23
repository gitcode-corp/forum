<?php
namespace Validator\Address;

class Post extends Put  {
    
    protected function valid() {
        parent::valid();
        $this->setRule('ADDRESSID',array('not_empty','greater_than'=>array('min'=>0)));  
    }
    
}
