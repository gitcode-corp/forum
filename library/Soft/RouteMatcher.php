<?php
 namespace Soft;
 
 class RouteMatcher
 {
     /**
      * @var Request
      */
     private $request;
     
     private $routes = [
         'main' => [
             'pattern' => '/',
             'controller' => 'Forum\Controller\DashboardController',
             'action' => 'viewAction',
             'method' => 'GET',
         ],
         'section' => [
             'pattern' => '/sections',
             'controller' => 'Forum\Controller\SectionController',
             'action' => 'listAction',
             'method' => 'GET'
         ],
         'topic-list' => [
             'pattern' => 'section/[:sectionId]/topics',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'listAction',
             'method' => 'GET'
         ],
         'topic-view' => [
             'pattern' => 'section/[:sectionId]/topic/[:topicId]',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'viewAction',
             'method' => 'GET'
         ],
         'topic-add' => [
             'pattern' => 'section/[:sectionId]/topic/add',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'addAction',
             'method' => 'GET'
         ],
         'topic-save' => [
             'pattern' => 'section/[:sectionId]/topic/add',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'createAction',
             'method' => 'POST'
         ],
         'post-add' => [
             'pattern' => 'section/[:sectionId]/topic/[:topicId]/add-post',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'addAction',
             'method' => 'GET'
         ],
         'post-save' => [
             'pattern' => 'section/[:sectionId]/topic/[:topicId]/add-post',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'createAction',
             'method' => 'POST'
         ]
     ];
     
     public function __construct(Request $request)
    {
         $this->request = $request;
    }
    
    public function match()
    {
        $uriParts = explode('/', $this->request->getRequestUri());
        $uriPartsNum = count($uriParts);
        
        foreach ($this->routes as $routeName => $options) {
            $method = isset($options['method']) ? $options['method'] : null;
            if ($uriPartsNum !== count(explode('/', $options['pattern'])) || !$this->isValidMethod($method)) {
                continue;
            }
            
            $routeParts = explode('/', $options['pattern']);   
            foreach ($uriParts as $index=>$uriPart) {
                if (!$this->isValidPart($uriParts, $routeParts, $index)) {
                    continue;
                }
            }
            
            //$options['params']['id'] = $this->getParam($uriParts);
            return $options;
            
            
        }
        
        throw new Exception\PageNotFoundException();
    }
    
    /**
     * @param array $uriParts
     * @param array $routeParts
     * @return bool
     */
    private function isValidPart(array $uriParts, array $routeParts, $part)
    {
        if ($uriParts[$part] === $routeParts[$part]) {
            return true;
        } elseif ($routeParts[$part][0] === '[' && $this->getParam($uriParts, $part)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @param array $uriParts
     * @param int $part
     * @return int
     */
    private function getId(array $uriParts, $part)
    {
        return (int) $uriParts[$part];
    }
    
    /**
     * @param string $method
     * @return boolean
     */
    private function isValidMethod($method)
    {
        if (null === $method) {
            return true;
        }
        
        return $this->request->isMethod($method);
    }
 }
