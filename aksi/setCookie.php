<?php

$nama = $_POST['namakuki'];
$value = $_POST['value'];
$durasi = $_POST['durasi'];

setcookie($nama, $value, time() + $durasi, "/");
echo $nama." setted to ".$value;