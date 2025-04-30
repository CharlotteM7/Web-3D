<?php
require_once 'application/controller/controller.php';
require_once 'application/model/model.php';
require_once 'application/view/load.php';

$pageURI = $_GET['route'] ?? 'home';

$controller = new Controller(null);

if (!method_exists($controller, $pageURI)) {
    $controller->home();
} else {
    $controller->$pageURI();
}
