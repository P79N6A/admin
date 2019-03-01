<?php

$data = $_POST?$_POST:$_GET;
$url = $_POST['url']?$_POST['url']:$_GET['url'];

$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
$result = curl_exec($ch);
curl_close($ch);

echo $result;




 ?>