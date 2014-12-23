<?php

namespace Forum\Entity;

class Section
{
    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var string
     */
    private $description;
    
    /**
     * @var int
     */
    private $amountTopic;
    
    /**
     * @var bool
     */
    private $isClosed;
    
    /**
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     *
     * @var Topic
     */
    private $lastTopic;
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAmountTopic()
    {
        return $this->amountTopic;
    }

    public function isClosed()
    {
        return $this->isClosed;
    }

    public function getCreatedOn() 
    {
        return $this->createdOn;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setAmountTopic($amountTopic)
    {
        $this->amountTopic = $amountTopic;
        return $this;
    }

    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;
        return $this;
    }

    public function seCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }
    
    public function getLastTopic()
    {
        return $this->lastTopic;
    }

    public function setLastTopic(Topic $lastTopic)
    {
        $this->lastTopic = $lastTopic;
        return $this;
    }
}
