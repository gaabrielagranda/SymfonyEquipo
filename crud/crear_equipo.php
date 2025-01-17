<?php
require_once "../bootstrap.php";
require_once '../src/Equipo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nombre = $_POST['nombre'];
    $fundacion = $_POST['fundacion'];
    $socios = $_POST['socios'];
    $ciudad = $_POST['ciudad'];

    $nuevo = new Equipo();
    $nuevo->setNombre($Nombre);
    $nuevo->setFundacion($fundacion);
    $nuevo->setSocios($socios);
    $nuevo->setCiudad($ciudad);

    $entityManager->persist($nuevo);
    $entityManager->flush();

    echo "Equipo insertado " . $nuevo->getId() . "\n";
} else {
    ?>
    <form method="post" action="crear_equipo.php">
        Nombre: <input type="text" name="nombre" required><br>
        Fundación: <input type="number" name="fundacion" required><br>
        Socios: <input type="number" name="socios" required><br>
        Ciudad: <input type="text" name="ciudad" required><br>
        <input type="submit" value="Crear Equipo">
    </form>
    <?php
}
?>