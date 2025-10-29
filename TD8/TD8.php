<?php
ob_start();

http_response_code(201);
header('xxx-headerTD8: valeurTest');

echo "<pre>";
echo "=== Contenu de \$_SERVER ===\n";
var_dump($_SERVER);

echo "\n=== Requête HTTP Reconstituée ===\n";

$method   = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
$path     = $_SERVER['REQUEST_URI'] ?? '';
$protocol = $_SERVER['SERVER_PROTOCOL'] ?? '';

echo "{$method} {$path} {$protocol}\n";

if (function_exists('getallheaders')) {
    $headers = getallheaders();
    foreach ($headers as $name => $value) {
        echo "{$name}: {$value}\n";
    }
} else {
    echo "(getallheaders() non disponible)\n";
}

ob_end_flush();
?>
