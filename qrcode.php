<?php
header("Content-type: image/png");
header('Content-Disposition: filename=$filename.png');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
$psw = $_GET[psw];
$file = './data/qr/'. $_GET[filename] .'.png';

if($psw == 'ZHBNLdJ53PLBDsL'){
readfile("$file");
}
?>