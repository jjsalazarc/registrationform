<?php
require_once ("../phpqrcode/qrlib.php");

$unique='13545';
QRcode::png($unique, 'images/' . $unique . 'image.png');
// creates file
?>

<img src="filename.png">