<?php
namespace Forum\Model;

class Breadcrumb
{
    /**
     * @var string
     */
    private $label;
    
    /**
     * @var string
     */
    private $url;
    
    /**
     * @param string $label
     * @param string $url
     */
    public function __construct($label, $url)
    {
        $this->label = $label;
        $this->url = $url;
    }
    
    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
