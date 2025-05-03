<?php
/**
 * Entry point for the Web 3D Application.
 * Loads the routing file (mvc.php) to bootstrap the MVC structure.
 */
$file = __DIR__ . '/mvc.php';
if (file_exists($file)) {
    require_once $file;
} else {
    die("Routing file not found!");
}

?>