<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Rutas donde están las entidades
$paths = array("./src/Entity"); // Cambié a src/Entity

// Modo desarrollo
$isDevMode = true;

// Configuración de la base de datos
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'doctrine',
    'host'     => 'localhost',
);

// Configuración de Doctrine
$proxyDir = __DIR__ . '/var/proxies'; // Directorio de proxies
if (!is_dir($proxyDir)) {
    mkdir($proxyDir, 0777, true); // Crear directorio si no existe
}
// Se crea la configuración de Doctrine porque se necesita el directorio de proxies para que funcionen las relaciones
$config = Setup::createAnnotationMetadataConfiguration(
    $paths, 
    $isDevMode, 
    $proxyDir, // Directorio de proxies
    null, 
    false
);

// Crear el EntityManager
$entityManager = EntityManager::create($dbParams, $config);