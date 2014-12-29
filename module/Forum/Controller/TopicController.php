<?php

namespace Forum\Controller;

use Forum\Model\Entity\Command\CommandFactory;

class TopicController extends AbstractController
{
    public function listAction($sectionId)
    {
        $command = CommandFactory::create('Topic\RetrieveAllWithLastPost');
        $command->setSectionId($sectionId);
        $topics = $command->execute();
        
        return $this->createViewModel('Forum/view/topic/list.phtml', ['topics' => $topics]);
    }
}
