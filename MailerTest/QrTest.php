<?php

require_once ("phpqrcode/qrlib.php");

function QrGenerate($unique) {
    QRcode::png($unique, 'images/' . $unique . 'image.png');
    
}
?>
