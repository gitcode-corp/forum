<?php
namespace Validator\Address;

use Zext;

class Put extends Zext\Validator {
    
    protected function valid() {
        parent::valid();
        $this->setRules(array(
            'LABEL' => array('not_empty','string_length'=>array('max'=>100)),
            'STREET' => array('not_empty','string_length'=>array('max'=>100)),
            'HOUSENUMBER' => array('not_empty','string_length'=>array('max'=>10)),
            'POSTALCODE' => array('not_empty','string_length'=>array('max'=>6)),
            'CITY' => array('not_empty','string_length'=>array('max'=>100)),
            'COUNTRY' => array('not_empty','string_length'=>array('max'=>100)),
        ));  
    }
    
}
