<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Equipos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }
        .container {
            margin-top: 50px;
        }
        .btn-custom {
            background-color: #6c757d;
            color: #ffffff;
        }
        .btn-custom:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1>Gestión de Equipos</h1>
        <div class="mt-4">
            <button class="btn btn-custom btn-lg" onclick="location.href='crear_ver_jugador.php'">Gestionar Jugadores</button>
        </div>
        <div class="mt-4">
            <button class="btn btn-custom btn-lg" onclick="location.href='crear_ver_instalaciones.php'">Gestionar Instalaciones</button>
        </div>
        <div class="mt-4">
            <button class="btn btn-custom btn-lg" onclick="location.href='crear_ver_equipo.php'">Gestionar Equipos</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>