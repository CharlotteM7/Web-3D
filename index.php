<?php
// Bootstrap our MVC
$file = __DIR__ . '/mvc.php';
if (file_exists($file)) {
    require_once $file;
} else {
    die("Routing file not found!");
}

?>