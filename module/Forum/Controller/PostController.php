<?php

namespace Forum\Controller;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\Factory\BreadCrumbManagerFactory;

class PostController extends AbstractController
{
    public function listAction($sectionId, $topicId)
    {
        $topic = $this->retrieveTopic($sectionId, $topicId);
        $command = CommandFactory::create('Post\RetrieveAllInTopic');
        $command->setSectionId($sectionId);
        $command->setTopicId($topicId);
        $posts = $command->execute();
        
        return $this->createViewModel(
                'Forum/view/post/list.phtml', 
                [
                    'posts' => $posts,
                    'topic' => $topic
                ]
            );
    }
    
    private function createForm()
    {
        $validator = new \Forum\Model\Form\Post\PostValidator();
        $form = new \Forum\Model\Form\Post\PostForm($validator);
        $form->setCsrfToken($this->getAuthUserToken());
        
        return $form;
    }
    
    /**
     * @param int $id
     * @return \Forum\Model\Entity\Topic:
     */
    private function retrieveTopic($sectionId, $topicId)
    {
        $command = CommandFactory::create("Topic\RetrieveOne");
        $command->setSectionId($sectionId);
        $command->setTopicId($topicId);
        $topic = $command->execute();
        
        if (!$topic) {
            $this->throwPageNonFoundException();
        }
        
        return $topic;
    }
}
