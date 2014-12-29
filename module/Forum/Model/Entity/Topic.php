<?php

namespace Forum\Model\Entity;

class Topic
{
    /**
     * @var int
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
    private $amountPosts;
    
    /**
     * @var bool
     */
    private $isClosed;
    
    /**
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @var Section
     */
    private $section;
    
    /**
     * @var Post
     */
    private $lastPost;
    
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

    public function getAmountPosts()
    {
        return $this->amountPosts;
    }

    public function isClosed()
    {
        return $this->isClosed;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function getSection()
    {
        return $this->section;
    }

    public function getLastPost()
    {
        return $this->lastPost;
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

    public function setAmountPosts($amountPosts)
    {
        $this->amountPosts = $amountPosts;
        return $this;
    }

    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;
        return $this;
    }

    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    public function setSection(Section $section = null)
    {
        $this->section = $section;
        return $this;
    }

    public function setLastPost(Post $lastPost = null)
    {
        $this->lastPost = $lastPost;
        return $this;
    }
}
