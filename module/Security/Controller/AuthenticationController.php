<?php

namespace Security\Controller;

use Forum\Controller\AbstractController;
use Security\Service\Factory\AuthenticationServiceFactory;

class AuthenticationController extends AbstractController
{
    public function loginAction()
    {
        if ($this->getGuardService()->isAuthenticated()) {
            $this->redirect("main");
        }
        
        $messages = \Soft\FlashMessage::get();
        return $this->createViewModel(
                'Security/view/authentication/login.phtml', 
                [
                    "messages" => $messages,
                    "_menu" => "login"
                ]
            );
    }
    
    public function authenticateAction()
    {
        if ($this->getGuardService()->isAuthenticated()) {
            $this->redirect("main");
        }
        
        $username = $this->request->getPostParam('username');
        $password = $this->request->getPostParam('password');
        
        $autehnticationService = AuthenticationServiceFactory::create();
       
        if ($autehnticationService->authenticate($username, $password)) {
            $this->redirect("main");
        } else {
            \Soft\FlashMessage::add("Zly login lub haslo.");
            $this->redirect("login");
        }
    }
    
    public function logoutAction()
    {
        if (!$this->getGuardService()->isAuthenticated()) {
            $this->redirect("main");
        }
        
        $autehnticationService = AuthenticationServiceFactory::create();
        $autehnticationService->clear();
        $this->redirect("main");
    }
}
