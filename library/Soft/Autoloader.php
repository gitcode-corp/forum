<?php
namespace Soft;

class Autoloader {
    const PATH = 'library';
    
    private $directory;
    
    private $namspaces = array(
      'Soft' => 'library/',  
      'Model' => 'model/',
      'Validator' => 'validator/',
      'Forum' => 'module/'
    );
    
    public function __construct($directory)
    {
        $dirname = realpath(dirname(__DIR__));
        $this->directory = str_replace(self::PATH, '', $dirname);
    }
    
    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }
    
    /**
     * @param  string $class
     * @return false|string
     */
    public function autoload($class)
    {
        $file = $this->getFilename($class);
        if (file_exists($file)) {
             return include $file;
        }

        $namespaces = $this->getNamespaces();
        foreach($namespaces as $name=>$path) {
            if(strpos($name.'\\',$class,0)!==null) {
                $file = $this->getFilename($class,$path);
                if (file_exists($file)) {
                    return include $file;
                }
            }
        }

        return false;
    }
    
    public function getDirectory()
    {
        return $this->directory;
    }
    
    
    public function registerNamespace($namespace,$path)
    {
        $this->namspaces[$namespace] = $path;
    }
    
    private function getFilename($class,$path ='')
    {
        return $this->getDirectory().$path.$class.'.php';
    }
    
    public function getNamespaces()
    {
        return $this->namspaces;
    } 
}
