<?php
session_start();
include 'conexion.php'; // Incluye la conexión a la base de datos

// Se valida si se ha enviado información con la función isset()
if (!isset($_POST['username'], $_POST['password'])) {
    // Si no hay datos, muestra error y redirecciona
    header('Location: login.php');
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT id, username, role FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Almacena el user_id, nombre de usuario y rol en la sesión
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['usuario'] = $row['username'];
    $_SESSION['rol'] = $row['role'];

    // Redirige a la página correspondiente según el rol
    if ($_SESSION['rol'] == 'admin') {
        header("Location: adminpage.php");
    } else {
        header("Location: userpage.php");
    }
    exit();
} else {
    // Si las credenciales no son válidas, redirigir al formulario de inicio de sesión con un mensaje de error
    header("Location: login.php?error=1");
    exit();
}

// Cierra la conexión
$conn->close();
