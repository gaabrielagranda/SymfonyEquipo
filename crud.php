<?php
include 'db.php';

// Manejo de formularios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'create') {
        $table = $_POST['table'];
        if ($table == 'equipo') {
            $nombre = $_POST['nombre'];
            $fundacion = $_POST['fundacion'];
            $socios = $_POST['socios'];
            $ciudad = $_POST['ciudad'];
            $query = "INSERT INTO equipo (nombre, fundacion, socios, ciudad) VALUES ('$nombre', $fundacion, $socios, '$ciudad')";
        } elseif ($table == 'jugador') {
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $edad = $_POST['edad'];
            $equipo = $_POST['equipo'];
            $query = "INSERT INTO jugador (Nombre, Apellidos, Edad, Equipo) VALUES ('$nombre', '$apellidos', $edad, $equipo)";
        }
        $conn->query($query);
    } elseif ($action == 'update') {
        $table = $_POST['table'];
        $id = $_POST['id'];
        if ($table == 'equipo') {
            $nombre = $_POST['nombre'];
            $fundacion = $_POST['fundacion'];
            $socios = $_POST['socios'];
            $ciudad = $_POST['ciudad'];
            $query = "UPDATE equipo SET nombre='$nombre', fundacion=$fundacion, socios=$socios, ciudad='$ciudad' WHERE id=$id";
        } elseif ($table == 'jugador') {
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $edad = $_POST['edad'];
            $equipo = $_POST['equipo'];
            $query = "UPDATE jugador SET Nombre='$nombre', Apellidos='$apellidos', Edad=$edad, Equipo=$equipo WHERE Id=$id";
        }
        $conn->query($query);
    } elseif ($action == 'delete') {
        $table = $_POST['table'];
        $id = $_POST['id'];
        $query = "DELETE FROM $table WHERE id=$id";
        $conn->query($query);
    }
}

// Consultas para mostrar datos
$equipos = $conn->query("SELECT * FROM equipo");
$jugadores = $conn->query("SELECT * FROM jugador");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Equipo y Jugador</title>
</head>
<body>
    <h1>Gestión de Equipos</h1>
    <form method="POST">
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="table" value="equipo">
        <label>Nombre: <input type="text" name="nombre"></label>
        <label>Fundación: <input type="number" name="fundacion"></label>
        <label>Socios: <input type="number" name="socios"></label>
        <label>Ciudad: <input type="text" name="ciudad"></label>
        <button type="submit">Agregar Equipo</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Fundación</th>
            <th>Socios</th>
            <th>Ciudad</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $equipos->fetch_assoc()): ?>
        <tr>
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="table" value="equipo">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <td><?= $row['id'] ?></td>
                <td><input type="text" name="nombre" value="<?= $row['nombre'] ?>"></td>
                <td><input type="number" name="fundacion" value="<?= $row['fundacion'] ?>"></td>
                <td><input type="number" name="socios" value="<?= $row['socios'] ?>"></td>
                <td><input type="text" name="ciudad" value="<?= $row['ciudad'] ?>"></td>
                <td>
                    <button type="submit">Actualizar</button>
                    <button type="button" onclick="deleteItem(<?= $row['id'] ?>, 'equipo')">Eliminar</button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>

    <h1>Gestión de Jugadores</h1>
    <form method="POST">
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="table" value="jugador">
        <label>Nombre: <input type="text" name="nombre"></label>
        <label>Apellidos: <input type="text" name="apellidos"></label>
        <label>Edad: <input type="number" name="edad"></label>
        <label>Equipo: <input type="number" name="equipo"></label>
        <button type="submit">Agregar Jugador</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Edad</th>
            <th>Equipo</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $jugadores->fetch_assoc()): ?>
        <tr>
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="table" value="jugador">
                <input type="hidden" name="id" value="<?= $row['Id'] ?>">
                <td><?= $row['Id'] ?></td>
                <td><input type="text" name="nombre" value="<?= $row['Nombre'] ?>"></td>
                <td><input type="text" name="apellidos" value="<?= $row['Apellidos'] ?>"></td>
                <td><input type="number" name="edad" value="<?= $row['Edad'] ?>"></td>
                <td><input type="number" name="equipo" value="<?= $row['Equipo'] ?>"></td>
                <td>
                    <button type="submit">Actualizar</button>
                    <button type="button" onclick="deleteItem(<?= $row['Id'] ?>, 'jugador')">Eliminar</button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>

    <script>
        function deleteItem(id, table) {
            if (confirm('¿Seguro que deseas eliminar este elemento?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="table" value="${table}">
                    <input type="hidden" name="id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
