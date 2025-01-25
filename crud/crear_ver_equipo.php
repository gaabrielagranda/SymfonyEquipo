<?php
// Mostrar errores en pantalla para facilitar la depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir archivos necesarios para la aplicación
require_once "../bootstrap.php"; // Archivo de inicialización
require_once '../src/EquipoBidireccional.php'; // Incluye la clase EquipoBidireccional correctamente

// Comprobar si se envió el formulario con método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        // Eliminar un equipo existente si se ha enviado el ID de eliminación
        $id = $_POST['delete_id'];
        $equipo = $entityManager->find('EquipoBidireccional', $id); // Buscar el equipo por ID
        if ($equipo) {
            $entityManager->remove($equipo); // Eliminar el equipo
            $entityManager->flush(); // Confirmar cambios en la base de datos
            echo "Equipo eliminado: " . $equipo->getId() . "\n";
        } else {
            echo "Equipo no encontrado."; // En caso de que no exista el equipo
        }
    } else {
        // Crear o actualizar un equipo según se indique en el formulario
        $id = $_POST['id'];
        $nombre = $_POST['nombre']; // Nombre del equipo
        $fundacion = $_POST['fundacion']; // Año de fundación del equipo
        $socios = $_POST['socios']; // Número de socios
        $ciudad = $_POST['ciudad']; // Ciudad del equipo

        if ($id) {
            // Si se pasa un ID, actualizar un equipo existente
            $equipo = $entityManager->find('EquipoBidireccional', $id); // Buscar equipo por ID
            if ($equipo) {
                // Actualizar los atributos del equipo con los nuevos valores del formulario
                $equipo->setNombre($nombre);
                $equipo->setFundacion($fundacion);
                $equipo->setSocios($socios);
                $equipo->setCiudad($ciudad);
                $entityManager->flush(); // Confirmar cambios en la base de datos
                echo "Equipo actualizado: " . $equipo->getId() . "\n";
            } else {
                echo "Equipo no encontrado."; // Si no se encuentra el equipo
            }
        } else {
            // Si no se pasa un ID, crear un nuevo equipo
            $nuevo = new EquipoBidireccional(); // Crear una nueva instancia de la clase EquipoBidireccional
            $nuevo->setNombre($nombre);
            $nuevo->setFundacion($fundacion);
            $nuevo->setSocios($socios);
            $nuevo->setCiudad($ciudad);
            $entityManager->persist($nuevo); // Guardar el nuevo equipo en la base de datos
            $entityManager->flush(); // Confirmar cambios
            echo "Equipo insertado: " . $nuevo->getId() . "\n";
        }
    }
}

// Obtener todos los jugadores y equipos de la base de datos para mostrar en la interfaz
$jugadores = $entityManager->getRepository('JugadorBidireccional')->findAll();
$equipos = $entityManager->getRepository('EquipoBidireccional')->findAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear y Ver Equipos</title> <!-- Título de la página -->
</head>
<body>
    <h1>Crear/Modificar Equipo</h1>
    <!-- Formulario para crear o modificar un equipo -->
    <form method="post" action="crear_ver_equipo.php">
        <input type="hidden" name="id" id="equipo_id"> <!-- Campo oculto para el ID del equipo -->
        Nombre: <input type="text" name="nombre" id="nombre" required><br>
        Fundación: <input type="number" name="fundacion" id="fundacion" required><br>
        Socios: <input type="number" name="socios" id="socios" required><br>
        Ciudad: <input type="text" name="ciudad" id="ciudad" required><br>
        <input type="submit" value="Guardar"> <!-- Botón para enviar el formulario -->
    </form>

    <h1>Lista de Equipos</h1>
    <!-- Mostrar la lista de equipos existentes -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Fundación</th>
            <th>Socios</th>
            <th>Ciudad</th>
            <th>Acciones</th>
        </tr>
        <?php if ($equipos): ?>
            <?php foreach ($equipos as $equipo): ?>
            <tr>
                <td><?php echo $equipo->getId(); ?></td>
                <td><?php echo $equipo->getNombre(); ?></td>
                <td><?php echo $equipo->getFundacion(); ?></td>
                <td><?php echo $equipo->getSocios(); ?></td>
                <td><?php echo $equipo->getCiudad(); ?></td>
                <td>
                    <!-- Botón para editar el equipo -->
                    <button onclick="editEquipo(<?php echo $equipo->getId(); ?>, '<?php echo $equipo->getNombre(); ?>', <?php echo $equipo->getFundacion(); ?>, <?php echo $equipo->getSocios(); ?>, '<?php echo $equipo->getCiudad(); ?>')">Editar</button>
                    <!-- Formulario para eliminar un equipo -->
                    <form method="post" action="crear_ver_equipo.php" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $equipo->getId(); ?>">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No hay equipos.</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Función para llenar el formulario de edición con los datos del equipo -->
    <script>
        function editEquipo(id, nombre, fundacion, socios, ciudad) {
            document.getElementById('equipo_id').value = id; // Asignar el ID del equipo
            document.getElementById('nombre').value = nombre; // Asignar el nombre
            document.getElementById('fundacion').value = fundacion; // Asignar el año de fundación
            document.getElementById('socios').value = socios; // Asignar el número de socios
            document.getElementById('ciudad').value = ciudad; // Asignar la ciudad
        }
    </script><br>
    <div>
        <button onclick="location.href='index.php'">Volver al índice</button>
    </div>
</body>
</html>
