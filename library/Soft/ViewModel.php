<?php

namespace Soft;

class ViewModel
{
    private $view;
    private $path;
    private $layout;
    
    public function __construct($view, $path = 'module')
    {
        $this->view = $view;
        $this->path = $path;
    }
    
    public function setLayout($file, $path = 'module')
    {
        $this->layout = $this->generatePath($file, $path);
        return $this;
    }
    
    public function assign($name, $value)
    {
        $this->$name = $value;
        return $this;
    }
    
    public function render()
    {
        $viewPath = $this->generatePath($this->view, $this->path);
        if ($this->layout) {
            $this->assign('content', $this->view);
            $this->assign('contentPath', $this->path);
            $template = $this->layout;
        } else {
            $template = $viewPath;
        }
        
        ob_start();
        include $template;

        return ob_get_clean(); // filter output
    }
    
    public function generatePath($file, $path = 'module')
    {
        $template = getcwd() . '/'. $path . '/' . $file;
        if (!is_readable($template)) {
            throw new Exception\ViewNotFoundException($template);
        }
        
        return $template;
    }
    
    public function includeFile($file, $path = 'module')
    {
        return include $this->generatePath($file, $path);
    }
}
