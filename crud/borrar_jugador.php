<?php
require_once "../bootstrap.php";
require_once '../src/Jugador.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $jugadorId = $_POST['jugador_id'];

    $jugador = $entityManager->find("Jugador", $jugadorId);
    if ($jugador) {
        $entityManager->remove($jugador);
        $entityManager->flush();
        echo "Jugador borrado exitosamente.";
    } else {
        echo "Jugador no encontrado.";
    }
} else{
    $jugadores = $entityManager->getRepository('Jugador')->findAll();
    ?>
    <form method="post" action="borrar_jugador.php">
        Seleccione el jugador a borrar:
        <select name="jugador_id" required>
            <?php foreach ($jugadores as $jugador) { ?>
                <option value="<?php echo $jugador->getId(); ?>"><?php echo $jugador->getNombre(); ?></option>
            <?php } ?>
        </select><br>
        <input type="submit" value="Borrar Jugador">
    </form>
    <?php
}
?>