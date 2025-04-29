<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-Type: application/json');

require __DIR__ . '/application/model/model.php';

$model  = new Model();
$brands = $model->getBrands();

echo json_encode($brands);
