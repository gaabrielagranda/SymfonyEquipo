<?php
require_once "bootstrap.php";
require_once 'src/Jugador.php';
require_once 'src/Equipo.php';
$nuevo = new Jugador();
$nuevo->setNombre('Gaby');
$nuevo->setApellidos('Granda');
$nuevo->setEdad(24);

$eq = $entityManager->find("Equipo", 4);
$nuevo->setEquipo($eq);
$entityManager->persist($nuevo);
$entityManager->flush();
echo "Jugador insertado " . $nuevo->getId() . "\n";