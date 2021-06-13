<?php
	// Generación de la solución (el valor del captcha):
	session_start();
	$captcha = rand(1000, 9999);
	$_SESSION["captcha"] = $captcha;

	// Generar imagen del captcha:
	$im = imagecreatetruecolor(50, 24);
	$bg = imagecolorallocate($im, 22, 86, 165); // Color azul
	$fg = imagecolorallocate($im, 255, 255, 255); // Color blanco
	imagefill($im, 0, 0, $bg);
	imagestring($im, rand(1, 7), rand(1, 7), rand(1, 7),  $captcha, $fg);

	// Prevenir almacenamiento en la caché:
	header("Cache-Control: no-store, no-cache");

	// Devolver imagen:
	header('Content-type: image/png');
	imagepng($im);
	imagedestroy($im);
?>
