<?php

namespace Security\Model\Entity\Command;

use Soft\AbstractCommandFactory;

class CommandFactory extends AbstractCommandFactory
{
    protected static $commandMap = [
        'User\RetrieveByUsername' => 'Security\Model\Entity\Command\User\RetrieveByUsernameCommand',
        'Role\RetrieveAllByUserId' => 'Security\Model\Entity\Command\Role\RetrieveAllByUserIdCommand'
    ];
}
