<?php

namespace Forum\Entity;

class Post
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $username;
    
    /**
     * @var string
     */
    private $content;
    
    /**
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @var Topic
     */
    private $topic;
    
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    public function setTopic(Topic $topic)
    {
        $this->topic = $topic;
        return $this;
    }
}
