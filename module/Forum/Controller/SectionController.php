<?php

namespace Forum\Controller;

use Forum\Model\Entity\Command\CommandFactory;
use Security\Service\Factory\UserManagerFactory;

class SectionController extends AbstractController
{
    public function addAction()
    {
        $this->assertGranted("ROLE_ADD_SECTION");
        
        return $this->createViewModel(
                'Forum/view/section/form.phtml', 
                [
                    "_menu" => "section-add",
                    "form" => $this->createForm(),
                    "messages" => \Soft\FlashMessage::get()
                ]
            );
    }
    
    public function createAction()
    {
        $this->assertGranted("ROLE_ADD_SECTION");
        
        $form = $this->createForm();
        if ($form->isValid($this->request->getPostParams())) {
            $sectionManager = \Forum\Service\Factory\SectionManagerFactory::create();
            $userManager = UserManagerFactory::create();
            $section = $sectionManager->create($form->getData());
            $section->setUser($userManager->create(["u_id" => $this->getAuthUserId()]));
            $sectionManager->save($section);

            \Soft\FlashMessage::add("Formularz został zapisany.");
            $this->redirect("section-add");
        }
        
        return $this->createViewModel(
                'Forum/view/section/form.phtml', 
                [
                    "_menu" => "section-add",
                    "form" => $form,
                    "messages" => []
                ]
            );
    }
    
    public function editAction($sectionId)
    {
        $this->assertGranted("ROLE_EDIT_SECTION");
        
        $section = $this->retrieveSection($sectionId);
        $data = [
            "s_name" => $section->getName(),
            "s_description" => $section->getDescription(),
            "s_is_closed" => ($section->isClosed()) ? "1" : "0",
        ];

        $form = $this->createForm();
        $form->setData($data);

        return $this->createViewModel(
                'Forum/view/section/form.phtml', 
                [
                    "form" => $form,
                    "messages" => \Soft\FlashMessage::get()
                ]
            );
    }
    
    public function updateAction($sectionId)
    {
        $this->assertGranted("ROLE_EDIT_SECTION");
        
        $section = $this->retrieveSection($sectionId);

        $form = $this->createForm();
        if ($form->isValid($this->request->getPostParams())) {
            $data = $form->getData();
            $section->setName($data['s_name']);
            $section->setDescription($data['s_description']);
            $isClosed = ($data["s_is_closed"] === "0")? false : true;
            $section->setIsClosed($isClosed);
            
            $sectionManager = \Forum\Service\Factory\SectionManagerFactory::create();
            $sectionManager->save($section);

            \Soft\FlashMessage::add("Formularz został zapisany.");
            $this->redirect("section-edit", ["sectionId"=>$section->getId()]);
        }
        
        return $this->createViewModel(
                'Forum/view/section/form.phtml', 
                [
                    "form" => $form,
                    "messages" => []
                ]
            );
    }
    
    private function createForm()
    {
        $validator = new \Forum\Model\Form\Section\SectionValidator();
        $form = new \Forum\Model\Form\Section\SectionForm($validator);
        $form->setCsrfToken($this->getAuthUserToken());
        
        return $form;
    }
    
    /**
     * @param int $id
     * @return \Forum\Model\Entity\Section:
     */
    private function retrieveSection($id)
    {
        $command = CommandFactory::create("Section\RetrieveOne");
        $command->setSectionId($id);
        $section = $command->execute();
        
        if (!$section) {
            $this->throwPageNonFoundException();
        }
        
        return $section;
    }
}
