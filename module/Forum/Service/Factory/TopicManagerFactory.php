<?php

namespace Forum\Service\Factory;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\TopicManager;

class TopicManagerFactory
{  
    /**
     * @return \Forum\Service\TopicManager
     */
    public static function create()
    {
        $insertTopicCommand = CommandFactory::create("Topic\Insert");
        $updateTopicCommand = CommandFactory::create("Topic\Update");
        $deleteTopicCommand = CommandFactory::create("Topic\Delete");
        
        return new TopicManager($insertTopicCommand, $updateTopicCommand, $deleteTopicCommand);
    }
}
