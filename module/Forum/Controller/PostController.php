<?php

namespace Forum\Controller;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\Factory\BreadCrumbManagerFactory;

class PostController extends AbstractController
{
    public function listAction($sectionId, $topicId)
    {
        $command = CommandFactory::create('Post\RetrieveAllInTopic');
        $command->setSectionId($sectionId);
        $command->setTopicId($topicId);
        $posts = $command->execute();
        
        $command = CommandFactory::create('Topic\RetrieveOne');
        $command->setSectionId($sectionId);
        $command->setTopicId($topicId);
        $topic = $command->execute();
        
        $breadcrumbManager = BreadCrumbManagerFactory::create();
        
        return $this->createViewModel(
                'Forum/view/post/list.phtml', 
                [
                    'posts' => $posts,
                    'topic' => $topic,
                    'breadcrumbs' => $breadcrumbManager->create($sectionId, $topicId)
                ]
            );
    }
}
