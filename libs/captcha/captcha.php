<?php

session_start();

$string = substr(md5(microtime() * mktime()),0,3);
$captcha = imagecreatefrompng("fondo.png");
$color = imagecolorallocate($captcha, 0, 0, 63);
$linea = imagecolorallocate($captcha,63,63,63);
imageline($captcha,0,0,39,29,$linea);
imageline($captcha,55,0,0,29,$linea);
imageline($captcha,40,0,64,29,$linea);
imagestring($captcha, 5, 10, 5, $string, $color);
$_SESSION['CAPTCHA'] = $string;
header("Content-type: image/png");
imagepng($captcha);
?>