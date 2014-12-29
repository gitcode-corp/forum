<?php

namespace Forum\Model\Entity\Command;

use Soft\AbstractCommandFactory;

class CommandFactory extends AbstractCommandFactory
{
    protected static $commandMap = [
        'Section\RetrieveAllWithLastTopic' => 'Forum\Model\Entity\Command\Section\RetrieveAllWithLastTopicCommand',
        'Section\RetrieveOne' => 'Forum\Model\Entity\Command\Section\RetrieveOneCommand',
        'Topic\RetrieveAllWithLastPost' => 'Forum\Model\Entity\Command\Topic\RetrieveAllWithLastPostCommand',
        'Topic\RetrieveOne' => 'Forum\Model\Entity\Command\Topic\RetrieveOneCommand',
        'Post\RetrieveAllInTopic' => 'Forum\Model\Entity\Command\Post\RetrieveAllInTopicCommand',
    ];
}
