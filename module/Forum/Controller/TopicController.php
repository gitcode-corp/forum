<?php

namespace Forum\Controller;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\Factory\TopicManagerFactory;
use Security\Service\Factory\UserManagerFactory;

class TopicController extends AbstractController
{
    public function listAction($sectionId)
    {
        $section = $this->retrieveSection($sectionId);
        
        $command = CommandFactory::create('Topic\RetrieveAllWithLastPost');
        $command->setSectionId($sectionId);
        $topics = $command->execute();
        
        return $this->createViewModel(
                'Forum/view/topic/list.phtml', 
                [
                    'topics' => $topics,
                    'section' => $section
                ]
            );
    }
    
    public function addAction($sectionId)
    {
        $section = $this->retrieveSection($sectionId);
        $this->assertAddTopic($section);
        
        return $this->createViewModel(
                'Forum/view/topic/form.phtml', 
                [
                    "_menu" => "topic-add",
                    "form" => $this->createForm(),
                    "messages" => \Soft\FlashMessage::get(),
                    'section' => $section,
                ]
            );
    }
    
    public function createAction($sectionId)
    {
        $section = $this->retrieveSection($sectionId);
        $this->assertAddTopic($section);
        
        $form = $this->createForm();
        if ($form->isValid($this->request->getPostParams())) {
            $userManager = UserManagerFactory::create();
            $topicManager = TopicManagerFactory::create();
            $topic = $topicManager->create($form->getData());
            $topic->setSection($section);
            $topic->setUser($userManager->create(["u_id" => $this->getAuthUserId()]));
            $topicManager->save($topic);

            \Soft\FlashMessage::add("Formularz został zapisany.");
            $this->redirect("topic-view", ["sectionId" => $section->getId(), "topicId"=>$topic->getId()]);
        }
        
        return $this->createViewModel(
                'Forum/view/topic/form.phtml', 
                [
                    "_menu" => "topic-add",
                    "form" => $form,
                    "messages" => [],
                    'section' => $section,
                ]
            );
    }
    
    public function editAction($sectionId, $topicId)
    {
        $topic = $this->retrieveTopic($sectionId, $topicId);
        $this->assertEditTopic($topic);
        
        $data = [
            "t_name" => $topic->getName(),
            "t_description" => $topic->getDescription(),
            "t_is_closed" => ($topic->isClosed()) ? "1" : "0",
        ];

        $form = $this->createForm();
        $form->setData($data);

        return $this->createViewModel(
                'Forum/view/topic/form.phtml', 
                [
                    "form" => $form,
                    "messages" => \Soft\FlashMessage::get()
                ]
            );
    }
    
    public function updateAction($sectionId, $topicId)
    {
        $topic = $this->retrieveTopic($sectionId, $topicId);
        $this->assertEditTopic($topic);
        
        $form = $this->createForm();
        if ($form->isValid($this->request->getPostParams())) {
            $data = $form->getData();
            $topic->setName($data['t_name']);
            $topic->setDescription($data['t_description']);
            $isClosed = ($data["t_is_closed"] === "0")? false : true;
            $topic->setIsClosed($isClosed);
            
            $topicManager = \Forum\Service\Factory\TopicManagerFactory::create();
            $topicManager->save($topic);

            \Soft\FlashMessage::add("Formularz został zapisany.");
            $this->redirect("topic-edit", ["sectionId"=>$topic->getSection()->getId(), "topicId" => $topic->getId()]);
        }

        return $this->createViewModel(
                'Forum/view/topic/form.phtml', 
                [
                    "form" => $form,
                    "messages" => []
                ]
            );
        
    }
    
    private function createForm()
    {
        if ($this->getGuardService()->isGranted("ROLE_CHANGE_TOPIC_STATUS")) {
            $validator = new \Forum\Model\Form\Topic\TopicAdminValidator();
            $form = new \Forum\Model\Form\Topic\TopicAdminForm($validator);
        } else {
            $validator = new \Forum\Model\Form\Topic\TopicValidator();
            $form = new \Forum\Model\Form\Topic\TopicForm($validator);   
        }
        
        $form->setCsrfToken($this->getAuthUserToken());
        
        return $form;
    }
    
    private function assertAddTopic(\Forum\Model\Entity\Section $section)
    {
        $this->assertGranted("ROLE_ADD_TOPIC");
        
        if ($section->isClosed()) {
            $this->throwPageNonFoundException();
        }
    }
    
    private function assertEditTopic(\Forum\Model\Entity\Topic $topic)
    {
        $isClosed = false;
        if ($topic->isClosed() || $topic->getSection()->isClosed()) {
            $isClosed = true;
        }
        $isGranted = false;
         
        if ($this->getGuardService()->isGranted("ROLE_EDIT_ALL_TOPICS")) {
            $isGranted = true;
        } elseif (
            !$isClosed
            && ($this->getGuardService()->isGranted("ROLE_EDIT_TOPIC") 
            && $this->getAuthService()->isUserAuthenticated($topic->getUser()->getId()))
        ) {
            $isGranted = true;
        } 

        if (!$isGranted) {
            $this->getGuardService()->throwForbiddenException();
        }
    }
    
    /**
     * @param int $id
     * @return \Forum\Model\Entity\Section:
     */
    private function retrieveSection($id)
    {
        $command = CommandFactory::create("Section\RetrieveOne");
        $command->setSectionId($id);
        $section = $command->execute();
        
        if (!$section) {
            $this->throwPageNonFoundException();
        }
        
        return $section;
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
