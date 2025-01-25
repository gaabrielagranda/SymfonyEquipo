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
    <form id="editForm" method="post" action="crear_ver_instalaciones.php">
        <input type="hidden" id="id" name="id">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" required><br>
        <label for="capacidad">Capacidad:</label>
        <input type="number" id="capacidad" name="capacidad" required><br>
        <label for="equipo_id">Equipo:</label>
        <select id="equipo_id" name="equipo_id">
            <option value="">Seleccione un equipo</option><br>
            <?php foreach ($equipos as $equipo): ?>
                <option value="<?php echo $equipo->getId(); ?>"><?php echo $equipo->getNombre(); ?></option><br>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Guardar">
    </form>

    <h2>Lista de Instalaciones</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Capacidad</th>
            <th>Equipo</th>
            <th>Acciones</th>
        </tr>
        <?php if ($instalaciones): ?>
            <?php foreach ($instalaciones as $instalacion): ?>
            <tr>
                <td><?php echo $instalacion->getId(); ?></td>
                <td><?php echo $instalacion->getNombre(); ?></td>
                <td><?php echo $instalacion->getDireccion(); ?></td>
                <td><?php echo $instalacion->getCapacidad(); ?></td>
                <td><?php echo $instalacion->getEquipo() ? $instalacion->getEquipo()->getNombre() : 'N/A'; ?></td>
                <td>
                    <button onclick="editInstalacion(
                        <?php echo $instalacion->getId(); ?>, 
                        '<?php echo $instalacion->getNombre(); ?>', 
                        '<?php echo $instalacion->getDireccion(); ?>', 
                        <?php echo $instalacion->getCapacidad(); ?>, 
                        <?php echo $instalacion->getEquipo() ? $instalacion->getEquipo()->getId() : 'null'; ?>
                    )">Editar</button>
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
            document.getElementById('id').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('direccion').value = direccion;
            document.getElementById('capacidad').value = capacidad;
            document.getElementById('equipo_id').value = equipo_id;
        }
    </script>
</body>
</html>