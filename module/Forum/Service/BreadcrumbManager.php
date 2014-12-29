<?php

namespace Forum\Service;

use Forum\Model\Entity\Command\Topic\RetrieveOneCommand as RetrieveTopicCommand;
use Forum\Model\Entity\Command\Section\RetrieveOneCommand as RetrieveSectionCommand;
use Forum\Model\Breadcrumb;

class BreadcrumbManager
{
    /**
     * @var RetrieveSectionCommand
     */
    private $retrieveSectionCommand;
    
    /**
     * @var RetrieveTopicCommand
     */
    private $retrieveTopicCommand;
    
    /**
     * @param RetrieveOneCommand $retrieveSectionCommand
     * @param RetrieveOneCommand $retrieveTopicCommand
     */
    public function __construct(RetrieveSectionCommand $retrieveSectionCommand, RetrieveTopicCommand $retrieveTopicCommand)
    {
        $this->retrieveSectionCommand = $retrieveSectionCommand;
        $this->retrieveTopicCommand = $retrieveTopicCommand;
    }
    
    /**
     * @param int $sectionId
     * @param int $topicId
     * @return Breadcrumb[]
     */
    public function create($sectionId, $topicId = null)
    {
        $breadcrumbs = [];
        
        $this->retrieveSectionCommand->setSectionId($sectionId);
        $section = $this->retrieveSectionCommand->execute();
        
        $uri = "/section/" . $section->getId();
        $breadcrumbs[] = new Breadcrumb($section->getName(), $uri);
        
        if ($topicId === null) {
            return $breadcrumbs;
        }
        
        $this->retrieveTopicCommand->setSectionId($sectionId);
        $this->retrieveTopicCommand->setTopicId($topicId);
        $topic = $this->retrieveTopicCommand->execute();
        
        $uri = "/section/" . $section->getId() . "/topic/" . $topic->getId();
        $breadcrumbs[] = new Breadcrumb($topic->getName(), $uri);
        
        return $breadcrumbs;
    }
}
