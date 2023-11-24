<?php
session_start();

include "conexion.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Se valida si se ha enviado información con la función isset()
if (!isset($username, $password)) {
    // Si no hay datos, muestra error y redirecciona
    header('Location: login.php');
}

$sql = "SELECT * FROM users WHERE username = '" . $username . "'";
// Ejecutamos y recogemos el resultado
$result = $conn->query($sql);
// Recorro el array
$row = mysqli_fetch_assoc($result);

// Comprobamos el rol y que las contraseñas sean iguales
if ($row["role"] == "admin" && $row["password"] == $password) {
    // Guardar el nombre de usuario en la sesión
    $_SESSION['usuario'] = $username;
    header("Location: adminpage.php");
} elseif ($row["password"] == $password) {
    // Guardar el nombre de usuario en la sesión
    $_SESSION['usuario'] = $username;
    header("Location: userpage.php");
} else {
    // Si las credenciales no son válidas, redirigir al formulario de inicio de sesión con un mensaje de error
    header("Location: login.php?error=1");
}

// Cierro la conexión
$conn->close();
