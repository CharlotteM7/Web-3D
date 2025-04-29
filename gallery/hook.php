<?php
$drink = $_GET['drink'] ?? 'coke'; // default to coke
$dir = "../gallery/$drink/";

$images = glob($dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

echo json_encode($images);
?>
