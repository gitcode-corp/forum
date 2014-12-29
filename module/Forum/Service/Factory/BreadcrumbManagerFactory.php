<?php

namespace Forum\Service\Factory;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\BreadcrumbManager;

class BreadCrumbManagerFactory
{
    /**
     * @return \Forum\Service\BreadcrumbManager
     */
    public static function create()
    {
        $retrieveSectionCommand = CommandFactory::create("Section\RetrieveOne");
        $retrirvrTopicCommand = CommandFactory::create("Topic\RetrieveOne");
        
        return new BreadcrumbManager($retrieveSectionCommand, $retrirvrTopicCommand);
    }
}
