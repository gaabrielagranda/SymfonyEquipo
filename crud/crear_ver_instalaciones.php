<?php
// Mostrar errores en pantalla para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Habilitar todos los errores

// Incluir archivos necesarios
require_once "../bootstrap.php";
require_once '../src/Instalacion.php'; //
require_once '../src/EquipoBidireccional.php'; 

// Verificar si el método de la solicitud es POST, post se usa para enviar datos a un recurso para su procesamiento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        // Eliminar instalación existente de la base de datos para que no se muestre en la vista
        $id = $_POST['delete_id'];
        $instalacion = $entityManager->find('Instalacion', $id);
        if ($instalacion) {
            $entityManager->remove($instalacion); // Marcar la entidad para eliminar
            $entityManager->flush(); // Persistir los cambios en la base de datos, persistir es guardar los cambios en la base de datos
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
            $instalacion = $entityManager->find('Instalacion', $id); // Buscar la instalación por ID
            if ($instalacion) {
                $instalacion->setNombre($nombre);
                $instalacion->setDireccion($direccion);
                $instalacion->setCapacidad($capacidad);

                // Asociar un equipo existente
                $equipo = $entityManager->find('EquipoBidireccional', $equipo_id);
                $instalacion->setEquipo($equipo);

                $entityManager->flush(); // Guardar los cambios
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

            // Asociar un equipo existente
            $equipo = $entityManager->find('EquipoBidireccional', $equipo_id);
            $nueva->setEquipo($equipo);

            $entityManager->persist($nueva); // Preparar para insertar
            $entityManager->flush(); // Guardar en la base de datos
            echo "Instalación insertada " . $nueva->getId() . "\n";
        }
    }
}

// Obtener datos para mostrar en la vista
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
    <!-- Formulario para crear o modificar instalaciones -->
    <h1>Crear/Modificar Instalación</h1>
    <form id="editForm" method="post" action="crear_ver_instalaciones.php">
        <input type="hidden" id="id" name="id">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br>
        <label for="capacidad">Capacidad:</label>
        <input type="number" id="capacidad" name="capacidad" required><br>
        <label for="equipo_id">Equipo:</label>
        <select id="equipo_id" name="equipo_id">
            <option value="">Seleccione un equipo</option><br>
            <!-- Iterar sobre los equipos disponibles -->
            <?php foreach ($equipos as $equipo): ?>
                <option value="<?php echo $equipo->getId(); ?>"><?php echo $equipo->getNombre(); ?></option><br>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Guardar">
    </form>

    <!-- Tabla para listar las instalaciones existentes -->
    <h2>Lista de Instalaciones</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
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
                    <!-- Botón para editar instalación -->
                    <button onclick="editInstalacion(
                        <?php echo $instalacion->getId(); ?>, 
                        '<?php echo $instalacion->getNombre(); ?>', 
                        '<?php echo $instalacion->getDireccion(); ?>', 
                        <?php echo $instalacion->getCapacidad(); ?>, 
                        <?php echo $instalacion->getEquipo() ? $instalacion->getEquipo()->getId() : 'null'; ?>
                    )">Editar</button>
                    <!-- Formulario para eliminar instalación -->
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

    <!-- Script para completar el formulario al editar -->
    <script>
        function editInstalacion(id, nombre, direccion, capacidad, equipo_id) {
            document.getElementById('id').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('direccion').value = direccion;
            document.getElementById('capacidad').value = capacidad;
            document.getElementById('equipo_id').value = equipo_id;
        }
    </script><br>
    <!-- Botón para volver al índice -->
    <div>
        <button onclick="location.href='index.php'">Volver al índice</button>
    </div>
</body>
</html>
