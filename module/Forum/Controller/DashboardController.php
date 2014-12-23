<?php

namespace Forum\Controller;

use Forum\Entity\Command\CommandFactory;

class DashboardController extends AbstractController
{
    public function viewAction()
    {
        $command = CommandFactory::create('Section\RetriveAllWithLastTopic');
        $sections = $command->execute();
        return $this->createViewModel('Forum/view/dashboard/view.phtml', ['sections' => $sections]);
    }
}

