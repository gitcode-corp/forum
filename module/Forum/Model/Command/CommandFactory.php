<?php

namespace Forum\Model\Command;

use Soft\AbstractCommandFactory;

class CommandFactory extends AbstractCommandFactory
{
    protected static $commandMap = [
        'Section\RetrieveAllWithLastTopic' => 'Forum\Model\Entity\Command\Section\RetrieveAllWithLastTopicCommand',
        'Topic\RetrieveAllWithLastPost' => 'Forum\Model\Entity\Command\Topic\RetrieveAllWithLastPostCommand',
        'Topic\RetrieveOne' => 'Forum\Model\Entity\Command\Topic\RetrieveOneCommand',
        'Post\RetrieveAllInTopic' => 'Forum\Model\Entity\Command\Post\RetrieveAllInTopicCommand',
    ];
    

}
