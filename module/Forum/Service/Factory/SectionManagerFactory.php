<?php

namespace Forum\Service\Factory;

use Forum\Model\Entity\Command\CommandFactory;
use Forum\Service\SectionManager;

class SectionManagerFactory
{
    /**
     * @return \Forum\Service\SectionManager
     */
    public static function create()
    {
        $insertSectionCommand = CommandFactory::create("Section\Insert");
        $updateSectionCommand = CommandFactory::create("Section\Update");
        $deleteSectionCommand = CommandFactory::create("Section\Delete");
        
        return new SectionManager($insertSectionCommand, $updateSectionCommand, $deleteSectionCommand);
    }
}
