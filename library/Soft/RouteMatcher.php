<?php
 namespace Soft;
 
 class RouteMatcher
 {
     /**
      * @var Request
      */
     private $request;
     
     /**
      * @var array
      */
     private $uriParams = [];
     
     private $routes = [
         'main' => [
             'pattern' => '/',
             'controller' => 'Forum\Controller\DashboardController',
             'action' => 'viewAction',
             'method' => 'GET',
         ],
         'section-add' => [
             'pattern' => '/section/add',
             'controller' => 'Forum\Controller\SectionController',
             'action' => 'addAction',
             'method' => 'GET'
         ],
         'section-create' => [
             'pattern' => '/section/add',
             'controller' => 'Forum\Controller\SectionController',
             'action' => 'createAction',
             'method' => 'POST'
         ],
         'section-edit' => [
             'pattern' => '/section/edit/[:sectionId]',
             'controller' => 'Forum\Controller\SectionController',
             'action' => 'editAction',
             'method' => 'GET'
         ],
         'section-update' => [
             'pattern' => '/section/edit/[:sectionId]',
             'controller' => 'Forum\Controller\SectionController',
             'action' => 'updateAction',
             'method' => 'POST'
         ],
         'section-delete' => [
             'pattern' => '/section/remove/[:sectionId]',
             'controller' => 'Forum\Controller\SectionController',
             'action' => 'deleteAction',
             'method' => 'GET'
         ],
         'topic-list' => [
             'pattern' => '/section/[:sectionId]',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'listAction',
             'method' => 'GET'
         ],
         'topic-view' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'listAction',
             'method' => 'GET'
         ],
         'topic-add' => [
             'pattern' => '/section/[:sectionId]/topic/add',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'addAction',
             'method' => 'GET',
             'roles' => ['ROLE_ADD_TOPIC']
         ],
         'topic-save' => [
             'pattern' => '/section/[:sectionId]/topic/add',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'createAction',
             'method' => 'POST',
             'roles' => ['ROLE_ADD_TOPIC']
         ],
         'topic-edit' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/edit',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'editAction',
             'method' => 'GET'
         ],
         'topic-update' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/edit',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'updateAction',
             'method' => 'POST'
         ],
         'topic-delete' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/remove',
             'controller' => 'Forum\Controller\TopicController',
             'action' => 'deleteAction',
             'method' => 'GET'
         ],
         'post-add' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/add-post',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'addAction',
             'method' => 'GET'
         ],
         'post-create' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/add-post',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'createAction',
             'method' => 'POST',
         ],
         'post-edit' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/post/[:postId]/edit',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'editAction',
             'method' => 'GET'
         ],
         'post-update' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/post/[:postId]/edit',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'updateAction',
             'method' => 'POST'
         ],
         'post-remove' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/post/[:postId]/confirm-delete',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'removeAction',
             'method' => 'GET'
         ],
         'post-delete' => [
             'pattern' => '/section/[:sectionId]/topic/[:topicId]/post/[:postId]/delete',
             'controller' => 'Forum\Controller\PostController',
             'action' => 'deleteAction',
             'method' => 'GET'
         ],
         'login' => [
             'pattern' => '/login',
             'controller' => 'Security\Controller\AuthenticationController',
             'action' => 'loginAction', 
             'method' => 'GET'
         ],
         'authenticate' => [
             'pattern' => '/login',
             'controller' => 'Security\Controller\AuthenticationController',
             'action' => 'authenticateAction', 
             'method' => 'POST'
         ],
         'logout' => [
             'pattern' => '/logout',
             'controller' => 'Security\Controller\AuthenticationController',
             'action' => 'logoutAction',   
         ],
     ];
     
     public function __construct(Request $request)
    {
         $this->request = $request;
    }
    
    public function match()
    {
        $uri = str_replace("?" . $this->request->getQuery() , "", $this->request->getRequestUri());
        $uriParts = explode('/', $uri);
        $uriPartsNum = count($uriParts);

        foreach ($this->routes as $routeName => $options) {
            $method = isset($options['method']) ? $options['method'] : null;
            if ($uriPartsNum !== count(explode('/', $options['pattern'])) || !$this->isValidMethod($method)) {
                continue;
            }
            
            $routeParts = explode('/', $options['pattern']); 
            $isUriValid = true;
            foreach ($uriParts as $index=>$uriPart) {
                if (!$this->isValidPart($uriParts, $routeParts, $index)) {
                    $isUriValid = false;
                    continue;
                }
            }
            
            if ($isUriValid) {
                $options['params'] = $this->uriParams;
                return $options;
            }  
        }
        
        throw new Exception\PageNotFoundException();
    }
    
    /**
     * @param array $uriParts
     * @param array $routeParts
     * @param int $part
     * @return bool
     */
    private function isValidPart(array $uriParts, array $routeParts, $part)
    {
        if ($uriParts[$part] === $routeParts[$part]) { 
            return true;
        } elseif ($routeParts[$part] && $routeParts[$part][0] === '[' && $this->getParam($uriParts, $routeParts, $part)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @param array $uriParts
     * @param array $routeParts
     * @param int $part
     */
    private function getParam(array $uriParts, array $routeParts, $part)
    {
        $paramName = str_replace(["[:", "]"], "", $routeParts[$part]);
        $this->uriParams[$paramName] = (int) $uriParts[$part];
        
        return $this->uriParams[$paramName];
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
    
    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
 }
