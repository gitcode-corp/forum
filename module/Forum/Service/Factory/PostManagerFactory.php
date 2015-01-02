<?php

namespace Forum\Service\Factory;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\PostManager;

class PostManagerFactory
{
    /**
     * @return \Forum\Service\PostManager
     */
    public static function create()
    {
        $insertPostCommand = CommandFactory::create("Post\Insert");
        $updatePostCommand = CommandFactory::create("Post\Update");
        $removePostContentCommand = CommandFactory::create("Post\RemoveContent");
        
        return new PostManager($insertPostCommand, $updatePostCommand, $removePostContentCommand);
    }
}