<?php

namespace Forum\Model\Entity\Command;

use Soft\AbstractCommandFactory;

class CommandFactory extends AbstractCommandFactory
{
    protected static $commandMap = [
        'Section\RetrieveAllWithLastTopic' => 'Forum\Model\Entity\Command\Section\RetrieveAllWithLastTopicCommand',
        'Section\RetrieveOne' => 'Forum\Model\Entity\Command\Section\RetrieveOneCommand',
        'Section\Insert' => 'Forum\Model\Entity\Command\Section\InsertCommand',
        'Section\Update' => 'Forum\Model\Entity\Command\Section\UpdateCommand',
        'Section\Delete' => 'Forum\Model\Entity\Command\Section\DeleteCommand',
        'Section\UpdateAmountTopic' => 'Forum\Model\Entity\Command\Section\UpdateAmountTopicCommand',
        'Topic\RetrieveAllWithLastPost' => 'Forum\Model\Entity\Command\Topic\RetrieveAllWithLastPostCommand',
        'Topic\RetrieveOne' => 'Forum\Model\Entity\Command\Topic\RetrieveOneCommand',
        'Topic\Insert' => 'Forum\Model\Entity\Command\Topic\InsertCommand',
        'Topic\Update' => 'Forum\Model\Entity\Command\Topic\UpdateCommand',
        'Topic\Delete' => 'Forum\Model\Entity\Command\Topic\DeleteCommand',
        'Topic\UpdatePostData' => 'Forum\Model\Entity\Command\Topic\UpdatePostDataCommand',
        'Post\RetrieveAllInTopic' => 'Forum\Model\Entity\Command\Post\RetrieveAllInTopicCommand',
        'Post\Insert' => 'Forum\Model\Entity\Command\Post\InsertCommand',
        'Post\Update' => 'Forum\Model\Entity\Command\Post\UpdateCommand',
        'Post\Delete' => 'Forum\Model\Entity\Command\Post\DeleteCommand',
        'Post\RetrieveOne' => 'Forum\Model\Entity\Command\Post\RetrieveOneCommand',
        'Post\RemoveContent' => 'Forum\Model\Entity\Command\Post\RemoveContentCommand',
    ];
}
