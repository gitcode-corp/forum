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

    public function onDispatch(\Soft\Request $request, \Soft\Response $response)
    {
        $this->request = $request;
        $this->response = $response;
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
        foreach ($params as $key=>$value) {
            $viewModel->assign($key, $value);
        }
        
        return $viewModel;
    }
}
