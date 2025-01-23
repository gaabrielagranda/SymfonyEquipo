<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../bootstrap.php";
require_once '../src/EquipoBidireccional.php'; // Incluye la clase correctamente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        // Eliminar un equipo existente
        $id = $_POST['delete_id'];
        $equipo = $entityManager->find('EquipoBidireccional', $id); // Asegúrate de que el namespace sea correcto
        if ($equipo) {
            $entityManager->remove($equipo);
            $entityManager->flush();
            echo "Equipo eliminado: " . $equipo->getId() . "\n";
        } else {
            echo "Equipo no encontrado.";
        }
    } else {
        // Crear o actualizar equipo
        $id = $_POST['id'];
        $nombre = $_POST['nombre']; // Corrige capitalización
        $fundacion = $_POST['fundacion'];
        $socios = $_POST['socios'];
        $ciudad = $_POST['ciudad'];

        if ($id) {
            // Actualizar un equipo existente
            $equipo = $entityManager->find('EquipoBidireccional', $id);
            if ($equipo) {
                $equipo->setNombre($nombre);
                $equipo->setFundacion($fundacion);
                $equipo->setSocios($socios);
                $equipo->setCiudad($ciudad);
                $entityManager->flush();
                echo "Equipo actualizado: " . $equipo->getId() . "\n";
            } else {
                echo "Equipo no encontrado.";
            }
        } else {
            // Crear un equipo nuevo
            $nuevo = new EquipoBidireccional();
            $nuevo->setNombre($nombre);
            $nuevo->setFundacion($fundacion);
            $nuevo->setSocios($socios);
            $nuevo->setCiudad($ciudad);
            $entityManager->persist($nuevo);
            $entityManager->flush();
            echo "Equipo insertado: " . $nuevo->getId() . "\n";
        }
    }
}
$jugadores = $entityManager->getRepository('JugadorBidireccional')->findAll();
$equipos = $entityManager->getRepository('EquipoBidireccional')->findAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear y Ver Equipos</title>
</head>
<body>
    <h1>Crear/Modificar Equipo</h1>
    <form method="post" action="crear_ver_equipo.php">
        <input type="hidden" name="id" id="equipo_id">
        Nombre: <input type="text" name="nombre" id="nombre" required><br>
        Fundación: <input type="number" name="fundacion" id="fundacion" required><br>
        Socios: <input type="number" name="socios" id="socios" required><br>
        Ciudad: <input type="text" name="ciudad" id="ciudad" required><br>
        <input type="submit" value="Guardar">
    </form>

    <h1>Lista de Equipos</h1>
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
                    <button onclick="editEquipo(<?php echo $equipo->getId(); ?>, '<?php echo $equipo->getNombre(); ?>', <?php echo $equipo->getFundacion(); ?>, <?php echo $equipo->getSocios(); ?>, '<?php echo $equipo->getCiudad(); ?>')">Editar</button>
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

    <script>
        function editEquipo(id, nombre, fundacion, socios, ciudad) {
            document.getElementById('equipo_id').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('fundacion').value = fundacion;
            document.getElementById('socios').value = socios;
            document.getElementById('ciudad').value = ciudad;
        }
    </script>
</body>
</html>