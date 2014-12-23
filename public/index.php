<?php
error_reporting(E_ALL|E_STRICT);

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'autoloader.php';

// Run the application!
Soft\Application::init();