<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../bootstrap.php";
require_once '../src/JugadorBidireccional.php';
require_once '../src/EquipoBidireccional.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        // Delete existing jugador
        $id = $_POST['delete_id'];
        $jugador = $entityManager->find('JugadorBidireccional', $id);
        if ($jugador) {
            $entityManager->remove($jugador);
            $entityManager->flush();
            echo "Jugador eliminado " . $jugador->getId() . "\n";
        } else {
            echo "Jugador no encontrado.";
        }
    } else {
        // Create or update jugador
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $edad = $_POST['edad'];
        $equipo_id = $_POST['equipo_id'];

        if ($id) {
            // Update existing jugador
            $jugador = $entityManager->find('JugadorBidireccional', $id);
            if ($jugador) {
                $jugador->setNombre($nombre);
                $jugador->setApellidos($apellidos);
                $jugador->setEdad($edad);
                $jugador->setEquipo($entityManager->find('EquipoBidireccional', $equipo_id));
                $entityManager->flush();
                echo "Jugador actualizado " . $jugador->getId() . "\n";
            } else {
                echo "Jugador no encontrado.";
            }
        } else {
            // Create new jugador
            $nuevo = new JugadorBidireccional();
            $nuevo->setNombre($nombre);
            $nuevo->setApellidos($apellidos);
            $nuevo->setEdad($edad);
            $nuevo->setEquipo($entityManager->find('EquipoBidireccional', $equipo_id));
            $entityManager->persist($nuevo);
            $entityManager->flush();
            echo "Jugador insertado " . $nuevo->getId() . "\n";
        }
    }
}

$jugadores = $entityManager->getRepository('JugadorBidireccional')->findAll();
$equipos = $entityManager->getRepository('EquipoBidireccional')->findAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear y Ver Jugadores</title>
</head>
<body>
    <h1>Crear/Modificar Jugador</h1>
    <form method="post" action="crear_ver_jugador.php">
        <input type="hidden" name="id" id="jugador_id">
        Nombre: <input type="text" name="nombre" id="nombre" required><br>
        Apellidos: <input type="text" name="apellidos" id="apellidos" required><br>
        Edad: <input type="number" name="edad" id="edad" required><br>
        Equipo: 
        <select name="equipo_id" id="equipo_id" required>
            <?php foreach ($equipos as $equipo): ?>
                <option value="<?php echo $equipo->getId(); ?>"><?php echo $equipo->getNombre(); ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="Guardar">
    </form>

    <h1>Lista de Jugadores</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Edad</th>
            <th>Equipo</th>
            <th>Acciones</th>
        </tr>
        <?php if ($jugadores): ?>
            <?php foreach ($jugadores as $jugador): ?>
            <tr>
                <td><?php echo $jugador->getId(); ?></td>
                <td><?php echo $jugador->getNombre(); ?></td>
                <td><?php echo $jugador->getApellidos(); ?></td>
                <td><?php echo $jugador->getEdad(); ?></td>
                <td><?php echo $jugador->getEquipo() ? $jugador->getEquipo()->getNombre() : 'N/A'; ?></td>
                <td>
                    <button onclick="editJugador(<?php echo $jugador->getId(); ?>, '<?php echo $jugador->getNombre(); ?>', '<?php echo $jugador->getApellidos(); ?>', <?php echo $jugador->getEdad(); ?>, <?php echo $jugador->getEquipo() ? $jugador->getEquipo()->getId() : 'null'; ?>)">Editar</button>
                    <form method="post" action="crear_ver_jugador.php" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $jugador->getId(); ?>">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No hay jugadores.</td>
            </tr>
        <?php endif; ?>
    </table>

    <script>
        function editJugador(id, nombre, apellidos, edad, equipo_id) {
            document.getElementById('jugador_id').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('apellidos').value = apellidos;
            document.getElementById('edad').value = edad;
            document.getElementById('equipo_id').value = equipo_id;
        }
    </script>
</body>
</html>