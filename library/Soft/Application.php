<?php
namespace Soft;

class Application
{
    public static function init()
    {
        $request = new Request();
        $response = new Response();
        $routeMatcher = new RouteMatcher($request);
        $route = $routeMatcher->match();
        
        $controllerName = $route['controller'];
        $actionName = $route['action'];
        $params = isset($route['params']) ? $route['params'] : [];
        
        $controller = new $controllerName;
        
        call_user_func_array([$controller, 'onDispatch'], [$request, $response]);
        $viewModel = call_user_func_array([$controller, $actionName], $params);
        
        $response->setBody($viewModel->render());
        $response->sendHeaders();
        $response->sendResponse();
        
        self::terminate();
    }
    
    public static function terminate()
    {
        $connection = DatabaseConnectionFactory::create();
        $connection->close();
        
        die();
    }
}
