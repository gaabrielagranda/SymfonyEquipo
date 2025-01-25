<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../bootstrap.php";
require_once '../src/JugadorBidireccional.php';
require_once '../src/EquipoBidireccional.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
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
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $edad = $_POST['edad'];
        $equipo_id = $_POST['equipo_id'];

        if ($id) {
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Jugadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: #eaeaea;
        }
        .form-container {
            background-color: #16213e;
            border-radius: 10px;
            padding: 20px;
        }
        .table-container {
            background-color: #0f3460;
            border-radius: 10px;
            padding: 20px;
        }
        .btn-custom {
            background-color: #e94560;
            color: white;
        }
        .btn-custom:hover {
            background-color: #d42b4f;
        }
        .btn-secondary-custom {
            background-color: #533483;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Gestión de Jugadores</h1>

        <div class="form-container mb-5">
            <h2 class="text-center mb-3">Crear/Editar Jugador</h2>
            <form method="post" action="crear_ver_jugador.php">
                <input type="hidden" name="id" id="jugador_id">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" required>
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingresa los apellidos" required>
                </div>
                <div class="mb-3">
                    <label for="edad" class="form-label">Edad</label>
                    <input type="number" class="form-control" name="edad" id="edad" placeholder="Ingresa la edad" required>
                </div>
                <div class="mb-3">
                    <label for="equipo_id" class="form-label">Equipo</label>
                    <select name="equipo_id" id="equipo_id" class="form-select" required>
                        <option value="">Selecciona un equipo</option>
                        <?php foreach ($equipos as $equipo): ?>
                            <option value="<?php echo $equipo->getId(); ?>"><?php echo $equipo->getNombre(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom w-100">Guardar</button>
            </form>
        </div>

        <div class="table-container">
            <h2 class="text-center mb-3">Lista de Jugadores</h2>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Edad</th>
                        <th>Equipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($jugadores): ?>
                        <?php foreach ($jugadores as $jugador): ?>
                        <tr>
                            <td><?php echo $jugador->getId(); ?></td>
                            <td><?php echo $jugador->getNombre(); ?></td>
                            <td><?php echo $jugador->getApellidos(); ?></td>
                            <td><?php echo $jugador->getEdad(); ?></td>
                            <td><?php echo $jugador->getEquipo() ? $jugador->getEquipo()->getNombre() : 'N/A'; ?></td>
                            <td>
                                <button class="btn btn-secondary-custom btn-sm me-2" onclick="editJugador(<?php echo $jugador->getId(); ?>, '<?php echo $jugador->getNombre(); ?>', '<?php echo $jugador->getApellidos(); ?>', <?php echo $jugador->getEdad(); ?>, <?php echo $jugador->getEquipo() ? $jugador->getEquipo()->getId() : 'null'; ?>)">Editar</button>
                                <form method="post" action="crear_ver_jugador.php" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $jugador->getId(); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay jugadores registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <button class="btn btn-light mt-4 w-100" onclick="location.href='index.php'">Volver al Índice</button>
    </div>

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
