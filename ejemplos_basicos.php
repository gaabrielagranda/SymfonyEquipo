<?php
// ejemplo_basicos.php
require_once "bootstrap.php";
require_once 'src/Equipo.php';
require_once 'src/Jugador.php';
// buscar por clave primaria
$eq = $entityManager->find("Equipo", 1);
// mostrar datos
echo $eq->getSocios();
// cambiar el número de socios
$eq->setSocios(70000);
$entityManager->flush();
// si el equipo no existe devuelve null
$eq = $entityManager->find("Equipo", 4);
if(!$eq){
	echo "Equipo no encontrado";
}
//--------------------
$eq1 = $entityManager->find("jugador", 1);
echo $eq1->getNombre();
if(!$eq1){
	echo "Jugador no encontrado";
}