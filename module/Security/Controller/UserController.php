<?php

namespace Security\Controller;

use Forum\Controller\AbstractController;
use Security\Model\Entity\Command\CommandFactory;
use Security\Service\Factory\UserManagerFactory;

class UserController extends AbstractController
{
    public function registerAction()
    {
        if ($this->getGuardService()->isAuthenticated()) {
            $this->redirect("main");
        }
        
        $messages = \Soft\FlashMessage::get();
        return $this->createViewModel(
                'Security/view/user/registration.phtml', 
                [
                    "messages" => $messages,
                    "_menu" => "registration",
                    "form" => $this->createForm()
                ]
            );
    }

    public function createAction()
    {
        if ($this->getGuardService()->isAuthenticated()) {
            $this->redirect("main");
        }
        
        $form = $this->createForm();
        if ($form->isValid($this->request->getPostParams())) {
            $data = $form->getData();
            $userManager = UserManagerFactory::create();
            $password = \Security\Service\PasswordGenerator::generate($data["u_password"]);
            $user = $userManager->create($form->getData());
            $user->setPassword($password["password"]);
            $user->setSalt($password["salt"]);
            $userManager->save($user);

            \Soft\FlashMessage::add("Dane zostały zapisane. Mozesz sie zalogowac.");
            $this->redirect("login");
        }
        
        return $this->createViewModel(
                'Security/view/user/registration.phtml', 
                [
                    "_menu" => "section-add",
                    "form" => $form,
                    "messages" => []
                ]
            );
    }
    
    private function createForm()
    {
        $retrieveUserByUsername = CommandFactory::create("User\RetrieveByUsername");
        $retrieveUserByEmail = CommandFactory::create("User\RetrieveByEmail");
        $validator = new \Security\Model\Form\User\UserValidator($retrieveUserByUsername, $retrieveUserByEmail);
        
               
        $form = new \Security\Model\Form\User\UserForm($validator);
        
        return $form;
    }
}

