<?php
require_once "../bootstrap.php";
require_once '../src/Equipo.php';

$equipos = $entityManager->getRepository('Equipo')->findAll();

if (!$equipos) {
    echo "No hay equipos.\n";
    exit(1);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Equipos</title>
</head>
<body>
    <h1>Lista de Equipos</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Fundación</th>
            <th>Socios</th>
            <th>Ciudad</th>
        </tr>
        <?php foreach ($equipos as $equipo): ?>
        <tr>
            <td><?php echo $equipo->getId(); ?></td>
            <td><?php echo $equipo->getNombre(); ?></td>
            <td><?php echo $equipo->getFundacion(); ?></td>
            <td><?php echo $equipo->getSocios(); ?></td>
            <td><?php echo $equipo->getCiudad(); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>