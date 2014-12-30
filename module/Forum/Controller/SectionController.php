<?php

namespace Forum\Controller;

use Forum\Model\Entity\Command\CommandFactory;

class SectionController extends AbstractController
{
    public function addAction()
    {
        return $this->createViewModel(
                'Forum/view/section/add.phtml', 
                [
                    "_menu" => "section-add",
                    "form" => $this->createForm()
                ]
            );
    }
    
    public function createAction()
    {
        $form = $this->createForm();
        if ($form->isValid($this->request->getPostParams())) {
            $sectionManager = new \Forum\Service\SectionManager();
            $userManager = new \Security\Service\UserManager();
            $section = $sectionManager->create($form->getData());
            $section->setUser($userManager->create(["u_id" => $this->getAuthUserId()]));
            $sectionManager->save($section);
            
        }
        
        return $this->createViewModel(
                'Forum/view/section/add.phtml', 
                [
                    "_menu" => "section-add",
                    "form" => $form
                ]
            );
    }
    
    private function createForm()
    {
        $validator = new \Forum\Model\Form\Section\SectionValidator();
        return new \Forum\Model\Form\Section\SectionForm($validator);
    }
}
