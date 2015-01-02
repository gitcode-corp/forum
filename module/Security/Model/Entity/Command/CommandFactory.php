<?php

namespace Security\Model\Entity\Command;

use Soft\AbstractCommandFactory;

class CommandFactory extends AbstractCommandFactory
{
    protected static $commandMap = [
        'User\RetrieveByUsername' => 'Security\Model\Entity\Command\User\RetrieveByUsernameCommand',
        'User\RetrieveByEmail' => 'Security\Model\Entity\Command\User\RetrieveByEmailCommand',
        'User\UpdateAmountPostCommand' => 'Security\Model\Entity\Command\User\UpdateAmountPostCommand',
        'User\Insert' => 'Security\Model\Entity\Command\User\InsertCommand',
        'Role\RetrieveAllByUserId' => 'Security\Model\Entity\Command\Role\RetrieveAllByUserIdCommand',
        'Group\RetrieveOneByName' => 'Security\Model\Entity\Command\Group\RetrieveOneByNameCommand',
        'UserGroup\Insert' => 'Security\Model\Entity\Command\UserGroup\InsertCommand'
        
    ];
}
