<?php
/**
 * MVC Router
 * Instantiates the controller and routes based on the 'route' GET parameter.
 * Default route: 'home'
 */
require_once './application/controller/controller.php';
require_once './application/model/model.php';
require_once './application/view/load.php';

// Get route from query string, fallback to 'home'
$pageURI = $_GET['route'] ?? 'home';

// Instantiate the controller (no auto-call to home)
$controller = new Controller(null);

// Call method if exists, otherwise fallback to home
if (!method_exists($controller, $pageURI)) {
    $controller->home();
} else {
    $controller->$pageURI();
}
