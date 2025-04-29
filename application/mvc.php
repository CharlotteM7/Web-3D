<?php
// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload our core components
require __DIR__ . '/controller/controller.php';
require __DIR__ . '/model/model.php';
require __DIR__ . '/view/load.php';

// Instantiate the controller
$controller = new Controller();
?>
