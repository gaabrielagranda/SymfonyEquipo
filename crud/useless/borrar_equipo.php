<?php
require_once "../bootstrap.php";
require_once '../src/Equipo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipoId = $_POST['equipo_id'];

    $equipo = $entityManager->find("Equipo", $equipoId);
    if ($equipo) {
        $entityManager->remove($equipo);
        $entityManager->flush();
        echo "Equipo borrado exitosamente.";
    } else {
        echo "Equipo no encontrado.";
    }
} else {
    // Obtener todos los equipos para el dropdown
    $equipos = $entityManager->getRepository('Equipo')->findAll();
    ?>
    <form method="post" action="borrar_equipo.php">
        Selecciona el equipo a borrar: 
        <select name="equipo_id" required>
            <?php foreach ($equipos as $equipo) { ?>
                <option value="<?php echo $equipo->getId(); ?>"><?php echo $equipo->getNombre(); ?></option>
            <?php } ?>
        </select><br>
        <input type="submit" value="Borrar Equipo">
    </form>
    <?php
}
?>