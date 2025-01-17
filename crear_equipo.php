<?php
require_once "bootstrap.php";
require_once 'src/Equipo.php';
$nuevo = new Equipo();
$nuevo->setNombre('Betis');
$nuevo->setFundacion(1800);
$nuevo->setSocios(60000);
$nuevo->setCiudad('Sevilla');
$entityManager->persist($nuevo);
$entityManager->flush();
echo "Equipo insertado " . $nuevo->getId() . "\n";
