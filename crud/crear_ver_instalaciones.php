<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../bootstrap.php";
require_once '../src/Instalacion.php';
require_once '../src/EquipoBidireccional.php'; // Incluye la clase EquipoBidireccional

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        // Eliminar instalación existente
        $id = $_POST['delete_id'];
        $instalacion = $entityManager->find('Instalacion', $id);
        if ($instalacion) {
            $entityManager->remove($instalacion);
            $entityManager->flush();
            echo "Instalación eliminada " . $instalacion->getId() . "\n";
        } else {
            echo "Instalación no encontrada.";
        }
    } else {
        // Crear o actualizar instalación
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $capacidad = $_POST['capacidad'];
        $equipo_id = $_POST['equipo_id'];

        if ($id) {
            // Actualizar instalación existente
            $instalacion = $entityManager->find('Instalacion', $id);
            if ($instalacion) {
                $instalacion->setNombre($nombre);
                $instalacion->setDireccion($direccion);
                $instalacion->setCapacidad($capacidad);
                // Usamos EquipoBidireccional para obtener el equipo
                $equipo = $entityManager->find('EquipoBidireccional', $equipo_id);
                $instalacion->setEquipo($equipo);
                $entityManager->flush();
                echo "Instalación actualizada " . $instalacion->getId() . "\n";
            } else {
                echo "Instalación no encontrada.";
            }
        } else {
            // Crear nueva instalación
            $nueva = new Instalacion();
            $nueva->setNombre($nombre);
            $nueva->setDireccion($direccion);
            $nueva->setCapacidad($capacidad);
            // Usamos EquipoBidireccional para obtener el equipo
            $equipo = $entityManager->find('EquipoBidireccional', $equipo_id);
            $nueva->setEquipo($equipo);
            $entityManager->persist($nueva);
            $entityManager->flush();
            echo "Instalación insertada " . $nueva->getId() . "\n";
        }
    }
}
$jugadores = $entityManager->getRepository('JugadorBidireccional')->findAll();
$equipos = $entityManager->getRepository('EquipoBidireccional')->findAll();
$instalaciones = $entityManager->getRepository('Instalacion')->findAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear y Ver Instalaciones</title>
</head>
<body>
    <h1>Crear/Modificar Instalación</h1>
    <form method="post" action="crear_ver_instalaciones.php">
        <input type="hidden" name="id" id="instalacion_id">
        Nombre: <input type="text" name="nombre" id="nombre" required><br>
        Dirección: <input type="text" name="direccion" id="direccion" required><br>
        Capacidad: <input type="number" name="capacidad" id="capacidad" required><br>
        Equipo ID: <input type="number" name="equipo_id" id="equipo_id"><br>
        <input type="submit" value="Guardar">
    </form>

    <h1>Lista de Instalaciones</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Capacidad</th>
            <th>Equipo ID</th>
            <th>Acciones</th>
        </tr>
        <?php if ($instalaciones): ?>
            <?php foreach ($instalaciones as $instalacion): ?>
            <tr>
                <td><?php echo $instalacion->getId(); ?></td>
                <td><?php echo $instalacion->getNombre(); ?></td>
                <td><?php echo $instalacion->getDireccion(); ?></td>
                <td><?php echo $instalacion->getCapacidad(); ?></td>
                <td><?php echo $instalacion->getEquipo() ? $instalacion->getEquipo()->getId() : 'N/A'; ?></td>
                <td>
                    <button onclick="editInstalacion(<?php echo $instalacion->getId(); ?>, '<?php echo $instalacion->getNombre(); ?>', '<?php echo $instalacion->getDireccion(); ?>', <?php echo $instalacion->getCapacidad(); ?>, <?php echo $instalacion->getEquipo() ? $instalacion->getEquipo()->getId() : 'null'; ?>)">Editar</button>
                    <form method="post" action="crear_ver_instalaciones.php" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $instalacion->getId(); ?>">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No hay instalaciones.</td>
            </tr>
        <?php endif; ?>
    </table>

    <script>
        function editInstalacion(id, nombre, direccion, capacidad, equipo_id) {
            document.getElementById('instalacion_id').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('direccion').value = direccion;
            document.getElementById('capacidad').value = capacidad;
            document.getElementById('equipo_id').value = equipo_id;
        }
    </script>
</body>
</html>