<?php

namespace Forum\Service\Factory;

use Forum\Service\UriService;

class UriServiceFactory
{
    /**
     * @return \Forum\Service\UriService
     */
    public static function create()
    {
        $request = new \Soft\Request();
        $roteMatcher = new \Soft\RouteMatcher($request); 
        
        return new UriService($roteMatcher->getRoutes(), $request->getDomain(), $request->getScheme());
    }
}
