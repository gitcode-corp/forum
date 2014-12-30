<?php

namespace Forum\Controller;

abstract class AbstractController
{
    /**
     * @var \Soft\Request
     */
    protected $request;
    
    /**
     *
     * @var \Soft\Response
     */
    protected $response;
    
    /**
     * @var \Forum\Service\UriService
     */
    private $uriService;
    
    /**
     * @var \Forum\Service\GuardService
     */
    private $guardService;
    
    /**
     * @var \Security\Service\AuthenticationService
     */
    private $authService;

    public function onDispatch(\Soft\Request $request, \Soft\Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    
    /**
     * @return \Forum\Service\UriService
     */
    protected function getUriService()
    {
        if ($this->uriService) {
            return $this->uriService;
        }
        
        $this->uriService = \Forum\Service\Factory\UriServiceFactory::create();
        
        return $this->uriService;
    }
    
    /**
     * @return \Forum\Service\GuardService
     */
    protected function getGuardService()
    {
        if ($this->guardService) {
            return $this->guardService;
        }
        
        $this->guardService = \Security\Service\Factory\GuardServiceFactory::create();
        
        return $this->guardService;
    }
    
    protected function getAuthService()
    {
        if ($this->authService) {
            return $this->authService;
        }
        
        $this->authService = \Security\Service\Factory\AuthenticationServiceFactory::create();
        
        return $this->authService;
    }
    
    /**
     * @return \Soft\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @param string $viewPath
     * @param array $params
     * @return \Soft\ViewModel
     */
    public function createViewModel($viewPath, $params = [])
    {
        $viewModel = new \Soft\ViewModel($viewPath);
        $viewModel->setLayout('Forum/view/layout/layout.phtml');
        $viewModel->assign('_uri', $this->getUriService());
        $viewModel->assign('_guard', $this->getGuardService());
        $viewModel->assign('_menu', "");
        foreach ($params as $key=>$value) {
            $viewModel->assign($key, $value);
        }
        
        return $viewModel;
    }
    
    public function redirect($name, array $params = [])
    {
        $url = $this->getUriService()->generate($name, $params);
        header("Location: " . $url);
        \Soft\Application::terminate();
    }
    
    public function getAuthUserId()
    {
        if (!$this->getAuthService()->isUserAuthenticated()) {
            return null;
        }
        
        $user = $this->getAuthService()->getUser();
        return $user["id"];
    }
}
