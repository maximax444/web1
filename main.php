<?php
session_start();
date_default_timezone_set('Europe/Moscow');
$start = microtime(true);
$now = date("H:i:s");

// Validate 
function validateX($xVal) {
  if(!isset($xVal)) {
      return false;
  }
  $X = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
  return in_array($xVal, $X);
}

function validateY($yVal) {
  $Y_MIN = -3;
  $Y_MAX = 5;

  if (!isset($yVal)) {
    return false;
  }

  $numY = str_replace(',', '.', $yVal);
  return is_numeric($numY) && $numY >= $Y_MIN && $numY <= $Y_MAX;
}

function validateR($rVal) {
    if(!isset($rVal)) {
        return false;
    }
    $R = [1, 2, 3, 4, 5];
    return in_array($rVal, $R);
}

function validateAll($xVal, $yVal, $rVal) {
  return validateX($xVal) && validateY($yVal) && validateR($rVal);
}



// Hit check functions
function checkTriangle($xVal, $yVal, $rVal) {
  return $xVal <= 0 && $yVal >= 0 && $yVal <= $xVal + $rVal/2;
}

function checkRectangle($xVal, $yVal, $rVal) {
  return $xVal <= 0 && $yVal <= 0 && $xVal <= $rVal && $yVal <= $rVal/2;
}

function checkCircle($xVal, $yVal, $rVal) {
  return $xVal >=0 && $yVal >= 0 && ($xVal*$xVal + $yVal*$yVal) <= ($rVal/2)*($rVal/2);
}

function checkHit($xVal, $yVal, $rVal) {
  return checkTriangle($xVal, $yVal, $rVal) || checkRectangle($xVal, $yVal, $rVal) || checkCircle($xVal, $yVal, $rVal);
}


$coordX = $_POST['coordX'];
$coordY = $_POST['coordY'];
$coordR = $_POST['coordR'];

$isValid = validateAll($coordX, $coordY, $coordR);

$converted_isValid = $isValid ? 'true' : 'false';
$isHit = $isValid ? checkHit($coordX, $coordY, $coordR) : 'false';
$converted_isHit = $isHit ? 'true' : 'false';

$executionTime = microtime(true) - $start;

$jsonData = '{' .
  "\"validate\":$converted_isValid," .
  "\"xval\":\"$coordX\"," .
  "\"yval\":\"$coordY\"," .
  "\"rval\":\"$coordR\"," .
  "\"curtime\":\"$now\"," .
  "\"exectime\":\"$executionTime\"," .
  "\"hitres\":$converted_isHit" .
  "}";

echo $jsonData;