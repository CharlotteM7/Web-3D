<?php
$dir = "../assets/images/";
$images = glob($dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
echo json_encode($images);
?>
