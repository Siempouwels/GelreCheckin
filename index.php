<?php

/**
 * Autoload Classes
 */
require 'vendor/autoload.php';

/**
 * Require routes file
 */
require 'App/routes.php';

/**
 * Require configuration file
 */
require 'App/config.php';

/**
 * Handle routes from Route helper class
 */

use App\Helpers\Route;


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
return $path;
Route::handle($path);