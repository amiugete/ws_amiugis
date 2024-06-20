<?php
require("vendor/autoload.php");
//echo 'OK';
//exit();
$openapi = \OpenApi\scan(__DIR__, ['exclude' => ['index.php'], 'pattern' => 'GetPercorsi.php']);
echo "ok";
//header('Content-Type: application/x-yaml');
//echo $openapi->toYaml();

?>
