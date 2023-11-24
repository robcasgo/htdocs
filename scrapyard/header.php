<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>scrapyard</title>
</head>

<body>

    <header>
        <h1>scrapyard</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php
// Iniciar la sesión si no existe
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la clave 'rol' existe en la sesión antes de acceder a ella
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

// Verificar si el usuario está logueado y tiene un rol asignado
if (isset($_SESSION['usuario']) && isset($rol)) {
    // Mostrar enlace según el rol del usuario
    if ($rol == 'admin') {
        echo '<li><a href="adminpage.php">Página de Administrador</a></li>';
    } else {
        echo '<li><a href="userpage.php">Página de Usuario</a></li>';
    }
    // Agregar enlace para cerrar sesión
    echo '<li><a href="cerrarsesion.php">Cerrar Sesión</a></li>';
} else {
    echo '<li><a href="login.php">Identifícate</a></li>';
}
?>
            </ul>
        </nav>
    </header>

    <main>