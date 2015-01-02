<?php

namespace Forum\Controller;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\Factory\PostManagerFactory;
use Security\Service\Factory\UserManagerFactory;

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
                    'postsData' => $this->assertAccess($posts),
                    'topic' => $topic,
                    'section' => $topic->getSection(),
                    'messages' => \Soft\FlashMessage::get()
                ]
            );
    }
    
    private function assertAccess(array $posts)
    {
        $data = [];
        foreach ($posts as $post) {
            $data[] = [
                "post" => $post,
                "canBeEdit" => $this->assertEditPost($post, false),
                "canBeDelete" => $this->assertDeletePost($post, false)
            ];
        }
        
        return $data;
    }
    
    public function addAction($sectionId, $topicId)
    {
        $topic = $this->retrieveTopic($sectionId, $topicId);
        $this->assertAddPost($topic);
        
        return $this->createViewModel(
                'Forum/view/post/form.phtml', 
                [
                    "_menu" => "post-add",
                    "form" => $this->createForm(),
                    "messages" => \Soft\FlashMessage::get(),
                    'topic' => $topic,
                    'section' => $topic->getSection(),
                ]
            );
    }
    
    public function createAction($sectionId, $topicId)
    {
        $topic = $this->retrieveTopic($sectionId, $topicId);
        $this->assertAddPost($topic);
        
        $form = $this->createForm();
        if ($form->isValid($this->request->getPostParams())) {
            $userManager = UserManagerFactory::create();
            $postManager = PostManagerFactory::create();
            $post = $postManager->create($form->getData());
            $post->setTopic($topic);
            $post->setUser($userManager->create(["u_id" => $this->getAuthUserId()]));
            $postManager->save($post);

            \Soft\FlashMessage::add("Formularz został zapisany.");
            $this->redirect("topic-view", ["sectionId" => $topic->getSection()->getId(), "topicId"=>$topic->getId()]);
        }
        
        return $this->createViewModel(
                'Forum/view/post/form.phtml', 
                [
                    "_menu" => "post-add",
                    "form" => $form,
                    "messages" => [],
                    'topic' => $topic,
                    'section' => $topic->getSection(),
                ]
            );
    }
    
    public function editAction($sectionId, $topicId, $postId)
    {
        $post = $this->retrievePost($sectionId, $topicId, $postId);
        $this->assertEditPost($post);
        
        $data = [
            "p_content" => $post->getContent(),
        ];

        $form = $this->createForm();
        $form->setData($data);

        return $this->createViewModel(
                'Forum/view/post/form.phtml', 
                [
                    "form" => $form,
                    "messages" => \Soft\FlashMessage::get(),
                    "topic" => $post->getTopic(),
                    'section' => $post->getTopic()->getSection(),
                ]
            );
    }
    
    public function updateAction($sectionId, $topicId, $postId)
    {
        $post = $this->retrievePost($sectionId, $topicId, $postId);
        $this->assertEditPost($post);
        
        $form = $this->createForm();
        if ($form->isValid($this->request->getPostParams())) {
            $data = $form->getData();
            $post->setContent($data['p_content']);
            
            $postManager = PostManagerFactory::create();
            $postManager->save($post);

            \Soft\FlashMessage::add("Formularz został zapisany.");
            $this->redirect("topic-view", ["sectionId"=>$post->getTopic()->getSection()->getId(), "topicId" => $post->getTopic()->getId()]);
        }

        return $this->createViewModel(
                'Forum/view/topic/form.phtml', 
                [
                    "form" => $form,
                    "messages" => [],
                    'topic' => $post->getTopic(),
                    'section' => $post->getTopic()->getSection(),
                ]
            );
        
    }
    
    public function removeAction($sectionId, $topicId, $postId)
    {
        $post = $this->retrievePost($sectionId, $topicId, $postId);
        $this->assertDeletePost($post);
        
        if ($this->request->getParam("token") !== $this->getAuthUserToken()) {
            $this->throwPageNonFoundException();
        }
        
        return $this->createViewModel(
                'Forum/view/post/remove.phtml', 
                [
                    "post" => $post,
                    "topic" => $post->getTopic(),
                    'section' => $post->getTopic()->getSection(),
                    "messages" => []
                ]
            );
    }
    
    public function deleteAction($sectionId, $topicId, $postId)
    {
        $post = $this->retrievePost($sectionId, $topicId, $postId);
        $this->assertDeletePost($post);
        
        if ($this->request->getParam("token") !== $this->getAuthUserToken()) {
            $this->throwPageNonFoundException();
        }
        
        $postManager = PostManagerFactory::create();
        $postManager->removeContent($post);
        
        \Soft\FlashMessage::add("Post został usunięty.");
            $this->redirect("topic-view", ["sectionId"=>$post->getTopic()->getSection()->getId(), "topicId" => $post->getTopic()->getId()]);
    }
    
    private function assertAddPost(\Forum\Model\Entity\Topic $topic)
    {
        $this->assertGranted("ROLE_ADD_POST");
        
        if ($topic->isClosed() || $topic->getSection()->isClosed()) {
            $this->throwPageNonFoundException();
        }
    }
    
    private function assertEditPost(\Forum\Model\Entity\Post $post, $throwException = true)
    {
        $topic = $post->getTopic();
        $isClosed = false;
        if ($topic->isClosed() || $topic->getSection()->isClosed()) {
            $isClosed = true;
        }
        
        $isGranted = false;
        if ($this->getGuardService()->isGranted("ROLE_EDIT_ALL_POSTS")) {
            $isGranted = true;
        } elseif (
            !$isClosed
            && !$post->isEditedByAdmin()
            && ($this->getGuardService()->isGranted("ROLE_EDIT_POST") 
            && $this->getGuardService()->isAuthUser($post->getUser()->getId()))
        ) {
            $isGranted = true;
        } 


        if ($throwException && !$isGranted) {
            $this->getGuardService()->throwForbiddenException();
        } else {
            return $isGranted;
        }  
    }
    
    private function assertDeletePost(\Forum\Model\Entity\Post $post, $throwException = true)
    {
        if ($this->getGuardService()->isGranted("ROLE_DELETE_POST")) {
            return true;
        }
        
        if ($throwException) {
            $this->getGuardService()->throwForbiddenException();
        } else {
            return false;
        } 
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
    
    /**
     * @param int $sectionId
     * @param int $topicId
     * @param int $postId
     * @return \Forum\Model\Entity\Post:
     */
    private function retrievePost($sectionId, $topicId, $postId)
    {
        $command = CommandFactory::create("Post\RetrieveOne");
        $command->setSectionId($sectionId);
        $command->setTopicId($topicId);
        $command->setPostId($postId);
        $post = $command->execute();
        
        if (!$post) {
            $this->throwPageNonFoundException();
        }
        
        return $post;
    }
}
