<?php
require_once "../bootstrap.php";
require_once '../src/Jugador.php';
require_once '../src/Equipo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $Nombre = $_POST['nombre'];
    $Apellidos = $_POST['apellidos'];
    $Edad = $_POST['edad'];
    $equipoId = $_POST['equipo_id'];

    $eq = $entityManager->find("Equipo", $equipoId);
    $nuevo->setEquipo($eq);
    $entityManager->persist($nuevo);
    $entityManager->flush();

    echo "Jugador insertado " . $nuevo->getId() . "\n";
} else {
    $equipos = $entityManager->getRepository('Equipo')->findAll();

    ?>
     <form method="post" action="crear_jugador.php">
        Nombre: <input type="text" name="nombre" required><br>
        Apellidos: <input type="text" name="apellidos" required><br>
        Edad: <input type="number" name="edad" required><br>
        Equipo: 
        <select name="equipo_id" required>
            <?php foreach ($equipos as $equipo) { ?>
                <option value="<?php echo $equipo->getId(); ?>"><?php echo $equipo->getNombre(); ?></option>
            <?php } ?>
        </select><br>
        <input type="submit" value="Crear Jugador">
    </form>
    <?php
}
?>